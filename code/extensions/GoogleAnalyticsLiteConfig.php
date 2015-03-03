<?php

/**
 * @package googleanalytics-lite
 * @author Patrick Chitovoro
 * @copyright (c) Chito Systems 2015
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
        if (class_exists('SiteConfig') && SiteConfig::has_extension('GoogleLiteConfig')) {
            $config = SiteConfig::current_site_config();
            switch ($key) {
                case 'code':
                    return $config->GoogleAnalyticsLiteCode ? $config->GoogleAnalyticsLiteCode : false;
                case 'profile':
                    return $config->SnippetPlacement ? $config->SnippetPlacement : false;
            }

        }

        return false;


    }

}