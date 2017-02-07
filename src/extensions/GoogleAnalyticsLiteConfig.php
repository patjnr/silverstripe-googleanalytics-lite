<?php
/**
 *
 * @copyright (c) 2016 - 2017 Insite Apps - http://www.insiteapps.co.za
 * @package insiteapps
 * @author Patrick Chitovoro  <patrick@insiteapps.co.za>
 * All rights reserved. No warranty, explicit or implicit, provided.
 *
 * NOTICE:  All information contained herein is, and remains the property of Insite Apps and its suppliers,  if any.  
 * The intellectual and technical concepts contained herein are proprietary to Insite Apps and its suppliers and may be covered by South African. and Foreign Patents, patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material is strictly forbidden unless prior written permission is obtained from Insite Apps.
 *
 * There is no freedom to use, share or change this file.
 *
 *
 */

//namespace InsiteApps\GoogleAnalyticsLite;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * @package googleanalytics-lite
 * @author Patrick Chitovoro
 * @copyright (c) Chito Systems 2017
 */
class GoogleAnalyticsLiteConfig extends DataExtension
{

    private static $db = array(
        'GoogleAnalyticsLiteCode' => 'Varchar',
        'SnippetPlacement' => 'Enum("Footer,Head","Footer")'
    );

    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldToTab("Root", new Tab('GoogleAnalyticsLite'));
        $fields->addFieldsToTab('Root.GoogleAnalyticsLite', array(
            TextField::create("GoogleAnalyticsLiteCode")->setTitle("Google Analytics Code")->setRightTitle("(UA-XXXXXX-X)"),
            OptionsetField::create('SnippetPlacement')
                ->setTitle('Google analytics snippet placement')
                ->setSource(singleton("SilverStripe\\SiteConfig\\SiteConfig")->dbObject("SnippetPlacement")->enumValues())
        ));

    }

    /**
     * Return various configuration values
     *
     * @param $key
     * @return bool
     */
    public static function get_google_config($key)
    {
        if (class_exists('SilverStripe\\SiteConfig\\SiteConfig') && SiteConfig::has_extension('GoogleAnalyticsLiteConfig')) {
            $config = SiteConfig::current_site_config();
            switch ($key) {
                case 'code':
                    return $config->GoogleAnalyticsLiteCode ? $config->GoogleAnalyticsLiteCode : false;
                case 'placement':
                    return $config->SnippetPlacement ? $config->SnippetPlacement : false;
            }

        }

        return false;


    }

}