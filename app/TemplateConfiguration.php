<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/14/2016
 * Time: 8:50 AM
 */

namespace App;

use League\Flysystem\Exception;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use App\Exceptions\ConfigurationException;
use OutOfBoundsException;
use App\Models\Template;

class TemplateConfiguration
{
    private $template;
    private $companyName;
    private $campaignName;
    private $campaignId;

    /**
     * TemplateConfiguration constructor
     * @param   array           $templateSettings       Template Name, Template Path Prefix, Company Name, Campaign Name, Campaign ID
     * @throws  ConfigurationException                  Custom Exception for any exception thrown in this class
     */
    public function __construct($templateSettings) {
        try {
            $this->areSettingsValid($templateSettings);
        } catch(Exception $e) {
            throw new ConfigurationException(__CLASS__ . ' Exception',0,$e);
        }
    }

    /**
     * areSettingsValid
     * Checks to be sure that the settings are valid inputs for their respective objects.
     *
     * @param   array           $templateSettings       Template Name, Template Path Prefix, Company Name, Campaign Name, Campaign ID
     * @throws  OutOfBoundsException
     */
    private function areSettingsValid($templateSettings) {
        if(!is_array($templateSettings) || empty($templateSettings)) {
            throw new OutOfBoundsException('Expected array, received ' . get_class($templateSettings) . ' Object');
        }
        $this->validateSettingsKeys($templateSettings);
        $this->validateSettingsValues($templateSettings);
        $this->setSettings($templateSettings);
    }

    /**
     * validateSettingsValues
     * Checks the values of valid keys to make sure their values are valid.
     *
     * @param   array           $templateSettings       Template Name, Template Path Prefix, Company Name, Campaign Name, Campaign ID
     * @throws  InvalidArgumentException
     */
    private function validateSettingsValues($templateSettings) {
        $message = '';
        if($this->validateRegex($templateSettings['templateName']) || $templateSettings['templateName'] == '') {
            $message .= 'Template Name is not a valid input. Value provided: ' . var_export($templateSettings['templateName'],true) . PHP_EOL;
        }
        if($this->validateRegex($templateSettings['companyName']) || $templateSettings['companyName'] == '') {
            $message .= 'Company Name is not a valid input. Value provided: ' . var_export($templateSettings['companyName'],true) . PHP_EOL;
        }
        if($this->validateRegex($templateSettings['campaignName']) || $templateSettings['campaignName'] == '') {
            $message .= 'Campaign Name is not a valid input. Value provided: ' . var_export($templateSettings['campaignName'],true) . PHP_EOL;
        }
        if($this->validateRegex($templateSettings['campaignId'])) {
            $message .= 'Campaign ID is not a valid input. Value provided: ' . var_export($templateSettings['campaignId'],true) . PHP_EOL;
        }
        if(!empty($message)) {
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * validateSettingsKeys
     * Checks the keys of the template settings to make sure that they have been set.
     *
     * @param   array           $templateSettings       Template Name, Template Path Prefix, Company Name, Campaign Name, Campaign ID
     * @throws  InvalidArgumentException
     */
    private function validateSettingsKeys($templateSettings) {
        $message = '';
        if(is_null($templateSettings['templateName'])) {
            $message .= 'Template Name value cannot be null.' . PHP_EOL;
        }
        if(is_null($templateSettings['companyName'])) {
            $message .= 'Company Name value cannot be null.' . PHP_EOL;
        }
        if(is_null($templateSettings['campaignName'])) {
            $message .= 'Campaign Name value cannot be null.' . PHP_EOL;
        }
        if(is_null($templateSettings['campaignId'])) {
            $message .= 'Campaign ID value cannot be null.' . PHP_EOL;
        }
        if(!empty($message)) {
            throw new OutOfBoundsException($message);
        }
    }

    /**
     * validateRegex
     * Helper function to validate input of template setting values via RegEx.
     *
     * @param   mixed          $value              Value to check against pattern.
     * @return  mixed
     */
    private function validateRegex($value) {
        $pattern = ';(?:[a-zA-z0-9-])(?![/][\^]);';
        return preg_match($value,$pattern);
    }

    /**
     * setSettings
     * Helper function to set all the settings
     *
     * @param   array           $templateSettings       Template Name, Template Path Prefix, Company Name, Campaign Name, Campaign ID
     */
    private function setSettings($templateSettings) {
        $this->template = new Template($templateSettings['templateName']);
        $this->companyName = $templateSettings['companyName'];
        $this->campaignName = $templateSettings['campaignName'];
        $this->campaignId = $templateSettings['campaignId'];
    }

    public function getTemplate() {
        return $this->template;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function getCampaignName() {
        return $this->campaignName;
    }

    public function getCampaignId() {
        return $this->campaignId;
    }
}