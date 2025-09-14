<?php

namespace KPG\RestAPI\ILIAS\Setting\Enum;

enum Tab: string
{
    case PERMISSION = 'tab_permission';
    case PERMISSION_COMPONENT = 'tab_permission_component';
    case PERMISSION_ROLE = 'tab_permission_role';
    case DOCUMENTATION = 'tab_documentation';
    case LOG = 'tab_log';
    case LOG_TABLE = 'tab_log_table';
    case LOG_SETTING = 'tab_log_setting';
}
