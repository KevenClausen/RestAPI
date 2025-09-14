<?php

use KPG\RestAPI\ILIAS\Setting\Enum\CMD;
use KPG\RestAPI\ILIAS\Setting\SettingHandler;

/**
 * @ilCtrl_IsCalledBy ilRestAPIConfigGUI: ilObjComponentSettingsGUI
 */
class ilRestAPIConfigGUI extends ilPluginConfigGUI
{
    public function performCommand(string $cmd): void
    {

        global $DIC;
        $page_handler = new SettingHandler(
            $DIC->ui()->factory(),
            $DIC->ui()->mainTemplate(),
            $DIC->ui()->renderer(),
            $DIC->ctrl(),
            $this->getPluginObject(),
            $DIC->tabs(),
            $DIC->http()->request(),
        );
        $page_handler->executeCommand(CMD::from($cmd));
    }
}
