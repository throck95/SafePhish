<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/13/2016
 * Time: 2:50 PM
 */

namespace app;

use League\Flysystem\Exception;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use App\Exceptions\ConfigurationException;
use OutOfBoundsException;


class EmailConfiguration
{
    private $host;
    private $port;
    private $authUsername;
    private $authPassword;
    private $fromEmail;
    private $subject;

    /**
     * EmailConfiguration constructor
     * @param   array           $emailSettings          Host, Port, Authenticating Username, Authenticating Password, From Email Address, Subject
     * @throws  ConfigurationException                  Custom Exception for any exception thrown in this class
     */
    public function __construct($emailSettings) {
        try {
            $this->validateSettings($emailSettings);
        } catch(Exception $e) {
            throw new ConfigurationException(__CLASS__ . ' Exception',0,$e);
        }
    }

    /**
     * areSettingsValid
     * Checks to be sure that the settings are valid inputs for their respective objects.
     *
     * @param   array           $emailSettings          Host, Port, Authenticating Username, Authenticating Password, From Email Address, Subject
     * @throws  OutOfBoundsException
     */
    private function validateSettings($emailSettings) {
        if(var_export($emailSettings) || empty($emailSettings)) {
            throw new OutOfBoundsException('Expected array, received ' . get_class($emailSettings) . ' Object');
        }
        $this->validateSettingsKeys($emailSettings);
        $this->validateSettingsValues($emailSettings);
        $this->setSettings($emailSettings);
    }

    /**
     * validateSettingsValues
     * Checks the values of valid keys to make sure their values are valid.
     *
     * @param   array           $emailSettings          Host, Port, Authenticating Username, Authenticating Password, From Email Address, Subject
     * @throws  InvalidArgumentException
     */
    private function validateSettingsValues($emailSettings) {
        $message = '';
        if($this->isValidDomain($emailSettings['host'])) {
            if(!filter_var($emailSettings['port'],FILTER_VALIDATE_INT)) {
                $message .= 'Port is not a valid integer. Value provided: ' . var_export($emailSettings['port'],true) . PHP_EOL;
            }
            if(!filter_var($emailSettings['fromEmail'],FILTER_VALIDATE_EMAIL)) {
                $message .= 'From Email is not a valid email address. Value provided: ' . var_export($emailSettings['fromEmail'],true) . PHP_EOL;
            }
        } else {
            $message = 'Host is not a valid host name or IP address. Value provided: ' . var_export($emailSettings['host'],true) . PHP_EOL;
        }
        if(!empty($message)) {
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * validateSettingsKeys
     * Checks the keys of the email settings to make sure that they have been set.
     *
     * @param   array           $emailSettings          Host, Port, Authenticating Username, Authenticating Password, From Email Address, Subject
     * @throws  InvalidArgumentException
     */
    private function validateSettingsKeys($emailSettings) {
        $message = '';
        if(is_null($emailSettings['host'])) {
            $message .= 'Host value cannot be null.' . PHP_EOL;
        }
        if(is_null($emailSettings['port'])) {
            $message .= 'Port value cannot be null.' . PHP_EOL;
        }
        if(is_null($emailSettings['authUsername'])) {
            $message .= 'Authenticating username value cannot be null.' . PHP_EOL;
        }
        if(is_null($emailSettings['authPassword'])) {
            $message .= 'Authenticating password value cannot be null.' . PHP_EOL;
        }
        if(is_null($emailSettings['fromEmail'])) {
            $message .= 'From email address value cannot be null.' . PHP_EOL;
        }
        if(is_null($emailSettings['subject'])) {
            $message .= 'Subject value cannot be null.' . PHP_EOL;
        }
        if(!empty($message)) {
            throw new OutOfBoundsException($message);
        }
    }

    /**
     * setSettings
     * Helper function to set all the settings
     *
     * @param   array           $emailSettings          Host, Port, Authenticating Username, Authenticating Password, From Email Address, Subject
     */
    private function setSettings($emailSettings) {
        $this->host = $emailSettings['host'];
        $this->port = $emailSettings['port'];
        $this->authUsername = $emailSettings['authUsername'];
        $this->authPassword = $emailSettings['authPassword'];
        $this->fromEmail = $emailSettings['fromEmail'];
        $this->subject = $emailSettings['subject'];
    }

    /**
     * isValidDomainName
     * Regex check if the Domain Name is valid. This does not require the URL protocol.
     *
     * @param   string      $domainName         Verifies a string ends with a proper suffix
     * @return  int|bool                        returns preg_match() - http://php.net/manual/en/function.preg-match.php
     */
    private function isValidDomainName($domainName) {
        if(is_null($domainName) || $domainName == '') {
            return false;
        }
        $pattern = ';(?:https?://)?(?:[a-zA-z0-9]+?\.(?:com|net|org|gov|edu|co\.uk));';
        return (preg_match($pattern, $domainName));
    }

    /**
     * isValidDomain
     * Check if the provided domain name / IP address is in a valid format.
     *
     * @param   string      $domain         Either the domain name or IP address of the domain to check for validity
     * @return  bool
     */
    private function isValidDomain($domain) {
        return $this->isValidDomainName($domain) || filter_var($domain,FILTER_VALIDATE_IP);
    }

    public function getHost() {
        return $this->host;
    }

    public function getPort() {
        return $this->port;
    }

    public function getAuthUsername() {
        return $this->authUsername;
    }

    public function getAuthPassword() {
        return $this->authPassword;
    }

    public function getFromEmail() {
        return $this->fromEmail;
    }

    public function getSubject() {
        return $this->subject;
    }
}