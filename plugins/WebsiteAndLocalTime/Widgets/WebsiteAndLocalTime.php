<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\WebsiteAndLocalTime\Widgets;

use Piwik\Plugins\UsersManager\UserPreferences;
use Piwik\Site;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class WebsiteAndLocalTime extends Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('Real-Time');
        $config->setName('Current local time in website\'s timezone');
    }

    public function render(): string
    {
        $userPreferences = new UserPreferences();
        $websiteId = $userPreferences->getDefaultWebsiteId();
        $timezone = Site::getTimezoneFor($websiteId);

        return $this->renderTemplate(
            'websiteAndLocalTime',
            [
                'websiteTimeZoneName' => $timezone
            ]
        );
    }
}
