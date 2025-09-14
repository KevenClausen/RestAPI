<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Page;

use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;

class LogTable extends BasePage
{

    public function getMainTab(): Tab
    {
        return Tab::LOG;
    }

    public function getSubTab(): ?Tab
    {
        return Tab::LOG_TABLE;
    }

    public function getContent(): array
    {
        return [];
    }
}
