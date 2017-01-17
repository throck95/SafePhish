<?php namespace App;

use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use League\Flysystem\Exception;
use Psy\Exception\FatalErrorException;
use App\Exceptions\EmailException;

use App\EmailConfiguration;
use App\TemplateConfiguration;

class Email {

    private static $templateConfig;
    private static $emailConfig;

    /**
     * executeEmail
     * Public-facing method to send an email to a database of users if they are a valid recipient.
     *
     * @param   EmailConfiguration          $emailConfig            Email Configuration object containing required information to send an email
     * @param   TemplateConfiguration       $templateConfig         Template Configuration object containing required information to build a template
     * @param   array                       $recipients             Array of Mailing_List_User objects
     * @throws  EmailException                                      Custom Exception to embody any exceptions thrown in this class
     */
    public static function executeEmail(
        EmailConfiguration $emailConfig,
        TemplateConfiguration $templateConfig,
        array $recipients)
    {
        self::setTemplateConfig($templateConfig);
        self::setEmailConfig($emailConfig);

        try {
            foreach($recipients as $recipient) {
                $data = self::phishingEmailData($recipient);
                self::sendEmail($data['templateData'],$data['emailData']);
                self::logSentEmail($recipient);
            }
        } catch(Exception $e) {
            throw new EmailException(__CLASS__ . ' Exception',0,$e);
        }
    }

    /**
     * logSentEmail
     * Logs to sent_email table info about this email and associated recipient.
     *
     * @param   Mailing_List_User           $recipient
     */
    private static function logSentEmail(Mailing_List_User $recipient) {
        $sent_mail = Sent_Mail::create(
            ['SML_UserId'=>$recipient->MGL_Id,
            'SML_ProjectId'=>self::$templateConfig->getProjectId(),
            'SML_Timestamp'=>Carbon::now()]
        );
    }

    /**
     * phishingEmailData
     * Gathers the required information to generate a phishing email.
     *
     * @param   Mailing_List_User           $recipient
     * @return  array
     */
    private static function phishingEmailData(Mailing_List_User $recipient) {
        $templateData = array(
            'companyName'=>self::$templateConfig->getCompanyName(),
            'projectName'=>self::$templateConfig->getProjectName(),
            'projectId'=>self::$templateConfig->getProjectId(),
            'lastName'=>$recipient->MGL_LastName,
            'username'=>$recipient->MGL_Username,
            'urlId'=>$recipient->MGL_UniqueURLId
        );
        $template = self::$templateConfig->getTemplate();
        $emailData = array(
            'subject'=>self::$emailConfig->getSubject(),
            'from'=>self::$emailConfig->getFromEmail(),
            'to'=>$recipient->MGL_Email,
            'template'=>$template->getConfigPrefix() . $template->getName()
        );
        return array(
            'templateData'=>$templateData,
            'emailData'=>$emailData
        );
    }

    /**
     * sendEmail
     * Sends them an email to the specified recipient.
     *
     * @param   array                   $templateData       Variables required by the template
     * @param   array                   $emailData          Header information for the email
     * @throws  FatalErrorException
     */
    private static function sendEmail($templateData,$emailData) {
        $from = $emailData['from'];
        $to = $emailData['to'];
        $subject = $emailData['subject'];
        $mailResult = Mail::send(
            ['html' => $emailData['template']],
            $templateData,
            function($m) use ($from, $to, $subject) {
                $m->from($from);
                $m->to($to);
                $m->subject($subject);
            }
        );
        if(!$mailResult) {
            throw new FatalErrorException('Email failed to send to ' . $to . ', from ' . $from);
        }
    }

    private static function setTemplateConfig(TemplateConfiguration $templateConfig) {
        self::$templateConfig = $templateConfig;
    }

    private static function setEmailConfig(EmailConfiguration $emailConfig) {
        self::$emailConfig = $emailConfig;
    }
}
