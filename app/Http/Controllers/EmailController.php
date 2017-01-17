<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TemplateConfiguration;
use App\EmailConfiguration;
use App\Email;
use App\Http\Controllers\AuthController as Auth;

use App\Models\Project;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;

use App\Exceptions\ConfigurationException;
use App\Exceptions\EmailException;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    /**
     * sendEmail
     * Function mapped to Laravel route. Defines variable arrays and calls Email Class executeEmail.
     *
     * @param    Request $request Request object passed via AJAX from client.
     */
    public static function sendEmail(Request $request)
    {
        if(Auth::check()) {
            try {
                $templateConfig = new TemplateConfiguration(
                    array(
                        'templateName' => $request->input('emailTemplate'),
                        'companyName' => $request->input('companyText'),
                        'projectName' => $request->input('projectData')['projectName'],
                        'projectId' => intval($request->input('projectData')['projectId'])
                    )
                );
                $currentProject = Project::where('PRJ_Id', $templateConfig->getProjectId())->first();
                $periodInWeeks = 4;
                $emailConfig = new EmailConfiguration(
                    array(
                        'host' => $request->input('mailServerText'),
                        'port' => $request->input('mailPortText'),
                        'authUsername' => $request->input('fromEmailText'),
                        'authPassword' => $request->input('fromPass'),
                        'fromEmail' => $request->input('fromEmailText'),
                        'subject' => $request->input('subject')
                    )
                );
                $recipients = self::validateMailingList($currentProject, $periodInWeeks);

                Email::executeEmail($emailConfig, $templateConfig, $recipients);
            } catch (ConfigurationException $ce) {
                //write to log file
            } catch (EmailException $ee) {
                //write to log file
                //track emails unsent and include in log?
            }
        }
    }

    /**
     * retrieveProjects
     * Helper function to grab the 3 most recent projects for a user, then grab the project object of each project.
     *
     * @param   int             $id         Mailing_List_User ID of the requested user.
     * @return  array
     */
    private static function retrieveProjects($id) {
        $join = DB::table('sent_email')
            ->leftJoin('projects','sent_email.SML_ProjectId','=','projects.PRJ_Id')
            ->where('sent_email.SML_UserId',$id)
            ->orderBy('sent_email.SML_Timestamp','desc')
            ->limit(3)
            ->get();
        $projects = array();
        foreach($join as $item) {
            $projects[] = $item;
        }
        return $projects;
    }

    /**
     * validateMailingList
     * Validates all the mailing_list recipients. Returns only those that will receive the email.
     *
     * @param   array           $currentProject         The current project being validated against.
     * @param   int             $periodInWeeks          Number of weeks back to check for most recent email.
     * @return  array
     */
    private static function validateMailingList(Project $currentProject, $periodInWeeks) {
        $users = Mailing_List_User::all();
        $mailingList = array();
        $date = date('Y-m-d h:i:s',strtotime("-$periodInWeeks weeks"));
        $complexity = $currentProject->PRJ_ComplexityType;
        $target = $currentProject->PRJ_TargetType;
        foreach($users as $user) {
            $projects = self::retrieveProjects($user->MGL_Id);
            if($projects[0]->updated_at <= $date ||
                !((!is_null($projects[0]) &&
                    $complexity == $projects[0]->PRJ_ComplexityType &&
                    $target == $projects[0]->PRJ_TargetType)
                ||
                (!is_null($projects[0]) && !is_null($projects[1]) &&
                    $complexity == $projects[0]->PRJ_ComplexityType &&
                    $complexity == $projects[1]->PRJ_ComplexityType)
                ||
                (!is_null($projects[0]) && !is_null($projects[1]) && !is_null($projects[2]) &&
                    $target == $projects[0]->PRJ_TargetType &&
                    $target == $projects[1]->PRJ_TargetType &&
                    $target == $projects[2]->PRJ_TargetType))) {
                $mailingList[] = $user;
            }
        }
        return $mailingList;
    }
}
