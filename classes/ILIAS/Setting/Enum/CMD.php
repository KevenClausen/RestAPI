<?php

namespace KPG\RestAPI\ILIAS\Setting\Enum;

enum CMD: string
{
    case SHOW_COMPONENT_PERMISSION = 'show_ComponentPermission';
    case SHOW_ROLE_PERMISSION = 'show_RolePermission';
    case SHOW_DOCUMENTATION = 'show_Documentation';
    case SHOW_LOG_SETTING = 'show_LogSetting';
    case SHOW_LOG_TABLE = 'show_LogTable';
    case CONFIGURE = 'configure';
    case SAVE_ROLE_PERMISSION = "save_RolePermission";
}
