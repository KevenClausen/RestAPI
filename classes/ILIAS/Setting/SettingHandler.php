<?php

namespace KPG\RestAPI\ILIAS\Setting;

use KPG\RestAPI\ILIAS\Setting\Enum\CMD;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;
use ilRestAPIConfigGUI;
use KPG\RestAPI\ILIAS\Setting\Enum\Mode;
use KPG\RestAPI\ILIAS\Setting\Base\BaseSettingModifiyResult;
use KPG\RestAPI\ILIAS\Setting\Base\BaseModel;
use KPG\RestAPI\ILIAS\Setting\Base\BasePage;
use Psr\Http\Message\RequestInterface;

/**
 * Class SettingHandler
 *
 * Handles the execution of commands related to settings management in the ILIAS framework.
 * Provides functionality to display or save settings based on the command type.
 */
class SettingHandler
{
    public function __construct(
        private readonly \ILIAS\UI\Factory $factory,
        private readonly \ilGlobalTemplateInterface $tpl,
        private readonly \ILIAS\UI\Renderer $renderer,
        private readonly \ilCtrlInterface $ctrl,
        private readonly \ilPlugin $plugin,
        private readonly \ilTabsGUI $tabs,
        private readonly RequestInterface $request,
        private readonly CMD $default_command = CMD::SHOW_ROLE_PERMISSION,
        private readonly string $model_namespace = 'KPG\\RestAPI\\ILIAS\\Setting\\Model\\',
        private readonly string $gui_namespace = 'KPG\\RestAPI\\ILIAS\\Setting\\GUI\\Page\\',
        private readonly string $base_class = \ilRestAPIConfigGUI::class
    ) {

    }

    /**
     * Executes a command based on the provided CMD object.
     * Determines the appropriate command to execute, resolves the command value,
     * and delegates to the appropriate method for handling the command.
     *
     * @param CMD $CMD The command object indicating the action to perform.
     *
     * @return void
     */
    public function executeCommand(CMD $CMD): void
    {

        if ($CMD->name === 'CONFIGURE') {
            $command = $this->default_command;
        } else {
            $command = $CMD;
        }
        $command_prefix = explode('_', $command->value);
        if ($command_prefix[0] == 'show') {
            $this->showSetting($command);
        } else {
            $this->ModifiySetting($command);
        }
    }

    /**
     * Handles the display of a specific setting based on the provided CMD object.
     * Uses the CMD value to determine the appropriate setting class, initializes it,
     * manages tab activations, and renders the content into the template.
     *
     * @param CMD $cmd The command object containing the setting identifier.
     *
     * @return void
     */
    private function showSetting(CMD $cmd): void
    {
        $tab_handler = new Tabhandler($this->plugin, $this->tabs, $this->ctrl);
        [$mode, $gui_name] = explode('_', $cmd->value);
        $className = $this->gui_namespace . $gui_name;
        /** @var BasePage $obj_gui */
        $obj_gui = new $className(
            $this->factory,
            $this->tpl,
            $this->plugin,
            $this->ctrl,
            $this->request,
            $this->base_class
        );
        $tab_handler->initTabs($obj_gui->getMainTab());
        $tab_handler->activateTab($obj_gui->getMainTab(), $obj_gui->getSubTab());
        $this->tpl->setContent($this->renderer->render([$obj_gui->getContent()]));

    }

    /**
     * Modifies a specific setting based on the provided CMD object.
     * Determines the appropriate model class and operation mode, initializes it,
     * applies the modification, and processes the response by setting an on-screen
     * message and redirecting to the appropriate command.
     *
     * @param CMD $cmd The command object containing the setting identifier and mode.
     *
     * @return void
     */
    private function ModifiySetting(CMD $cmd): void
    {
        [$mode, $model] = explode('_', $cmd->value);
        $mode = MODE::from($mode);

        $className = $this->model_namespace . $model;
        /** @var BaseModel $model */
        $obj_model = new $className(
            $this->tpl,
            $this->plugin,
            $this->ctrl,
            $this->base_class
        );
        /** @var BaseSettingModifiyResult $result */
        $result = $obj_model->set($mode);
        $this->tpl->setOnScreenMessage($result->getType()->value, $this->plugin->txt($result->getMessage()), true);
        $this->ctrl->redirectByClass($this->base_class, $result->getRedirectCmd()->value);
    }
}
