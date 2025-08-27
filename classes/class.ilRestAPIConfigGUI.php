<?php

use KPG\RestAPI\ILIAS\Config\PageHandler;

/**
 * @ilCtrl_IsCalledBy ilRestAPIConfigGUI: ilObjComponentSettingsGUI
 */
class ilRestAPIConfigGUI extends ilPluginConfigGUI
{
    public function performCommand(string $cmd): void
    {
        PageHandler::handleCMD($cmd);
    }
}
