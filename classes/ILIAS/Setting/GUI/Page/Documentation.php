<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Page;

use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;

class Documentation extends BasePage
{
    public function getMainTab(): Tab
    {
        return Tab::DOCUMENTATION;
    }

    public function getSubTab(): ?Tab
    {
        return null;
    }

    public function getContent(): array
    {
        return [];
    }
}
