<?php

namespace KPG\RestAPI\ILIAS\Config;

use KPG\RestAPI\ILIAS\Util\Language;
use ilRestAPIConfigGUI;
use KPG\RestAPI\ILIAS\Config\Constant\TabConstant;
use KPG\RestAPI\ILIAS\Config\Constant\LangConstant;
use KPG\RestAPI\ILIAS\Config\Constant\CMDConstant;
use KPG\RestAPI\ILIAS\Config\Permission\PermissionController;
use ILIAS\Config\Documentation\DocumentationController;

class PageHandler implements TabConstant, LangConstant, CMDConstant
{
    use Language;

    public static function handleCMD(string $cmd): void
    {
        self::initTabs();
        switch ($cmd) {
            case self::CMD_SAVE_PERMISSION:
                $controller = new PermissionController();
                $controller->saveAPIPermission();
                break;
            case self::CMD_SHOW_ROLE_PERMISSION:
                self::initSubTab(self::TAB_ID_PERMISSION);
                self::activateTab(self::TAB_ID_PERMISSION);
                self::activateSubTab(self::TAB_SUB_ID_ROLE_PERMISSION);
                $controller = new PermissionController();
                $controller->showRolePermission();
                break;
            case self::CMD_SAVE_ROLE_PERMISSION:
                $controller = new PermissionController();
                $controller->saveRolePermission();
                break;
            case self::CMD_SHOW_API_DOCUMENTATION:
                self::activateTab(self::TAB_ID_API_DOCUMENTAION);
                $controller = new DocumentationController();
                $controller->init();
                break;
            case self::CMD_SHOW_LOGS:
            case self::CMD_SHOW_LOGS_DEFAULT:
                self::initSubTab(self::TAB_ID_LOGS);
                self::activateTab(self::TAB_ID_LOGS);
                self::activateSubTab(self::TAB_SUB_ID_LOGS_DEFAULT);
                break;
            case self::CMD_SHOW_LOGS_SETTINGS:
                self::initSubTab(self::TAB_ID_LOGS);
                self::activateTab(self::TAB_ID_LOGS);
                self::activateSubTab(self::TAB_SUB_ID_LOGS_SETTINGS);
                break;
            default:
                self::initSubTab(self::TAB_ID_PERMISSION);
                self::activateTab(self::TAB_ID_PERMISSION);
                self::activateSubTab(self::TAB_SUB_ID_API_PERMISSION);
                $controller = new PermissionController();
                $controller->showAPIPermission();
                break;
        }
    }

    private static function initTabs(): void
    {
        global $DIC;
        $DIC->tabs()->addTab(
            self::TAB_ID_PERMISSION,
            self::getLang(self::LANG_TAB_PERMISSION),
            $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_PERMISSION)
        );
        $DIC->tabs()->addTab(
            self::TAB_ID_API_DOCUMENTAION,
            self::getLang(self::LANG_TAB_API_DOCUMENTATION),
            $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_API_DOCUMENTATION)
        );
        $DIC->tabs()->addTab(
            self::TAB_ID_LOGS,
            self::getLang(self::LANG_TAB_LOGS),
            $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_LOGS)
        );
    }

    private static function initSubTab(string $main_tab): void
    {
        if ($main_tab === self::TAB_ID_PERMISSION) {
            global $DIC;
            $DIC->tabs()->addSubTab(
                self::TAB_SUB_ID_API_PERMISSION,
                self::getLang(self::LANG_TAB_SUB_API_PERMISSION),
                $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_API_PERMISSION)
            );
            global $DIC;
            $DIC->tabs()->addSubTab(
                self::TAB_SUB_ID_ROLE_PERMISSION,
                self::getLang(self::LANG_TAB_SUB_ROLE_PERMISSION),
                $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_ROLE_PERMISSION)
            );
        } elseif ($main_tab === self::TAB_ID_LOGS) {
            global $DIC;
            $DIC->tabs()->addSubTab(
                self::TAB_SUB_ID_LOGS_DEFAULT,
                self::getLang(self::LANG_TAB_SUB_LOGS_DEFAULT),
                $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_LOGS_DEFAULT)
            );
            $DIC->tabs()->addSubTab(
                self::TAB_SUB_ID_LOGS_SETTINGS,
                self::getLang(self::LANG_TAB_SUB_LOGS_SETTINGS),
                $DIC->ctrl()->getLinkTargetByClass(ilRestAPIConfigGUI::class, self::CMD_SHOW_LOGS_SETTINGS)
            );
        }
    }

    private static function activateTab(string $id): void
    {
        global $DIC;
        $DIC->tabs()->activateTab($id);
    }

    private static function activateSubTab(string $id): void
    {
        global $DIC;
        $DIC->tabs()->activateSubTab($id);
    }
}
