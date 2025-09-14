<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Page;

use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;

class LogSetting extends BasePage
{
    public function getMainTab(): Tab
    {
        return Tab::LOG;
    }

    public function getSubTab(): ?Tab
    {
        return TAB::LOG_SETTING;
    }

    public function getContent(): array
    {
        return [];
    }
}
