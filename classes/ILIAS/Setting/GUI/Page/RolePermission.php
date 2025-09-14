<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Page;

use KPG\RestAPI\ILIAS\Setting\Enum\Tab;
use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use KPG\RestAPI\ILIAS\Util\Roles;
use ilRestAPIConfigGUI;
use KPG\RestAPI\ILIAS\Setting\Enum\CMD;
use KPG\RestAPI\ILIAS\Setting\GUI\Form\FormRolePermission;

class RolePermission extends BasePage
{
    use Roles;
    public function getMainTab(): Tab
    {
        return  Tab::PERMISSION;
    }

    public function getSubTab(): ?Tab
    {
        return Tab::PERMISSION_ROLE;
    }

    public function getContent(): array
    {
        $this->tpl->addCss('Customizing/global/plugins/Services/EventHandling/EventHook/RestAPI/css/custom.css');
        $form = new FormRolePermission(
            $this->factory,
            $this->tpl,
            $this->plugin,
            $this->ctrl,
            $this->request,
            $this->base_class
        );
        return [$this->factory->panel()->standard($this->plugin->txt('tab_permission_api'), $form->getContent())];
    }
}
