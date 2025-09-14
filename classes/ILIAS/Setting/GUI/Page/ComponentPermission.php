<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Page;

use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;

class ComponentPermission extends BasePage
{

    public function getMainTab(): Tab
    {
        return Tab::PERMISSION;
    }

    public function getSubTab(): ?Tab
    {
        return Tab::PERMISSION_COMPONENT;
    }

    public function getContent(): array
    {
        return [];
    }
}
