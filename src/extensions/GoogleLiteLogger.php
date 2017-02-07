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

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

/**
 * Class GoogleLiteLogger
 */
class GoogleLiteLogger extends DataExtension
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
        if (GoogleAnalyticsLiteConfig::get_google_config('code')) {
            $code = GoogleAnalyticsLiteConfig::get_google_config('code');
            $SnippetPlacement = GoogleAnalyticsLiteConfig::get_google_config('placement');
            $snippet = new ArrayData(array(
                'GoogleAnalyticsCode' => $code,
            ));
            $snippetHtml = $snippet->renderWith('GoogleAnalyticsLiteJSSnippet');

            if ($SnippetPlacement === 'Head') {
                Requirements::insertHeadTags(sprintf("<script type=\"text/javascript\">%s</script>", $snippetHtml->Value));
            } else {
                Requirements::customScript($snippetHtml);
            }


        }

    }


}