<?php

namespace KPG\RestAPI\ILIAS\Config\Permission;

use KPG\RestAPI\ILIAS\Util\Language;
use KPG\RestAPI\ILIAS\Config\Constant\LangConstant;
use KPG\RestAPI\ILIAS\Config\Constant\CMDConstant;

class PermissionController implements LangConstant, CmdConstant
{
    use Language;

    private PermissionModel $permissionModel;
    private PermissionView $permissionView;
    private $DIC;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
        $this->permissionView = new PermissionView();
        global $DIC;
        $this->DIC = $DIC;
    }

    public function showAPIPermission()
    {
        $form = $this->permissionView->initFormAPIPermission();
        $this->DIC->ui()->mainTemplate()->setContent(
            $this->DIC->ui()->renderer()->render(
                $this->DIC->ui()->factory()->panel()->standard(self::getLang(self::LANG_ROLE_PERMISSION), [$form])
            )
        );
    }

    public function saveAPIPermission()
    {
        if ($this->permissionModel->saveAPIPermission($this->permissionView->initFormAPIPermission())) {
            $this->DIC->ui()->mainTemplate()->setOnScreenMessage(
                'success', self::getLang(self::LANG_API_PERMISSION_MSG_SUCCESS), true
            );
            $this->DIC->ctrl()->redirectByClass(\ilRestAPIConfigGUI::class, self::CMD_SHOW_PERMISSION);
        } else {
            $this->DIC->ui()->mainTemplate()->setOnScreenMessage(
                'success', self::getLang(self::LANG_API_PERMISSION_MSG_FAILED), true
            );
            $this->DIC->ctrl()->redirectByClass(\ilRestAPIConfigGUI::class, self::CMD_SHOW_PERMISSION);
        }
    }

    public function showRolePermission()
    {
        $form = $this->permissionView->initFormRolePermission();
        $this->DIC->ui()->mainTemplate()->setContent(
            $this->DIC->ui()->renderer()->render(
                $this->DIC->ui()->factory()->panel()->standard(self::getLang(self::LANG_COMPONENT_PERMISSION), [$form])
            )
        );
    }

    public function saveRolePermission()
    {
        if ($this->permissionModel->saveRolePermission($this->permissionView->initFormRolePermission())) {
            $this->DIC->ui()->mainTemplate()->setOnScreenMessage(
                'success', self::getLang(self::LANG_API_PERMISSION_MSG_SUCCESS), true
            );
        } else {
            $this->DIC->ui()->mainTemplate()->setOnScreenMessage(
                'success', self::getLang(self::LANG_API_PERMISSION_MSG_FAILED), true
            );
        }
        $this->DIC->ctrl()->redirectByClass(\ilRestAPIConfigGUI::class, self::CMD_SHOW_ROLE_PERMISSION);
    }
}
