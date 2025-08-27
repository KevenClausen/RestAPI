<?php

namespace KPG\RestAPI\ILIAS\Setup;

use KPG\RestAPI\ILIAS\Database\Tables\APIPermissionTable;
use KPG\RestAPI\ILIAS\Database\Tables\RolesPermissionTable;
use KPG\RestAPI\ILIAS\Database\Tables\APILogs;

class DatabaseSetup
{
    public function install()
    {
        $api_permission_table = new ApiPermissionTable();
        $api_permission_table->install();
        $role_permission_table = new RolesPermissionTable();
        $role_permission_table->install();
        $api_logs = new APILogs();
        $api_logs->install();
    }

    public function uninstall()
    {

        $api_permission_table = new ApiPermissionTable();
        $api_permission_table->uninstall();
        $role_permission_table = new RolesPermissionTable();
        $role_permission_table->uninstall();
        $api_logs = new APILogs();
        $api_logs->uninstall();
    }
}
