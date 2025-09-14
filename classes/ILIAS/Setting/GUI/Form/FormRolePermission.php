<?php

namespace KPG\RestAPI\ILIAS\Setting\GUI\Form;

use KPG\RestAPI\ILIAS\Setting\Base\BaseContent;
use ILIAS\UI\Factory;
use KPG\RestAPI\ILIAS\Util\Roles;
use KPG\RestAPI\ILIAS\Setting\Enum\CMD;
use ilRestAPIConfigGUI;
use ILIAS\UI\Implementation\Component\Input\Input;
use ILIAS\UI\Component\Input\Container\Container;

class FormRolePermission extends BaseContent
{
    use Roles;

    public function getContent(): Factory|Input|Container
    {
        $section_elements = [];
        foreach ($this->getAllGlobalRoles() as $role_id => $role_title) {
            $role_radio_buttons = $this->factory->input()->field()->radio($role_title, '')->withAdditionalOnLoadCode(
                fn($id) => <<<JS
                (function() {
                  const el = document.getElementById('$id');
                    el.querySelectorAll(':scope > *').forEach(child => {
                      child.classList.add('events_radiobuttons');
                    });
                })();
                JS
            )->withOption(0, $this->plugin->txt('api_permission_radio_button_no_permission'))
                                                ->withOption(1, $this->plugin->txt('api_permission_radio_button_custom'))
                                                ->withOption(2, $this->plugin->txt('api_permission_radio_button_full_permission'));

            $section_elements[$role_id] = $role_radio_buttons;
        }
        $form_action = $this->ctrl->getLinkTargetByClass(
            $this->base_class,
            CMD::SAVE_ROLE_PERMISSION->value
        );
        $form = $this->factory->input()->container()->form()->standard($form_action, $section_elements);

        if ($this->request->getMethod() == "POST") {
            $form = $form->withRequest($this->request);
        }
        return $form;
    }
}
