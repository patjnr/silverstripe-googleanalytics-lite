<?php

/**
 * Class GoogleLiteLogger
 */
class GoogleLiteLogger extends Extension
{
    // the Google Analytics code to be used in the JS snippet or
    public static $google_analytics_code;

    public static function activate($code = null)
    {

        switch ($code) {
            case null:
                self::$google_analytics_code = null;
                break;
            case 'SiteConfig':
                SiteConfig::add_extension('GoogleAnalyticsLiteConfig');
                break;
            default:
                self::$google_analytics_code = $code;
        }

        Controller::add_extension('GoogleLiteLogger');

    }

    public function onAfterInit()
    {
        if (
            $this->owner instanceof DevelopmentAdmin ||
            $this->owner instanceof DatabaseAdmin ||
            (class_exists('DevBuildController') && $this->owner instanceof DevBuildController)
        ) {
            return;
        }

        // include the JS snippet into the frontend page markup
        if (GoogleConfig::get_google_config('code')) {
            $snippet = new ArrayData(array(
                'GoogleAnalyticsCode' => GoogleConfig::get_google_config('code'),
                'UseGoogleUniversalSnippet' => GoogleConfig::get_google_config('universal')
            ));

            Requirements::customScript($snippet->renderWith('GoogleAnalyticsJSSnippet'));
        }

    }


}