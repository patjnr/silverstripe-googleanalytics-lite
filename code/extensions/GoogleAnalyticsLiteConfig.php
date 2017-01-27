<?php

//namespace InsiteApps\GoogleAnalyticsLite;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\OptionsetField;

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
                ->setSource(singleton("SiteConfig")->dbObject("SnippetPlacement")->enumValues())
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
        if (class_exists('SiteConfig') && SiteConfig::has_extension('GoogleAnalyticsLiteConfig')) {
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