<?php

namespace KPG\RestAPI\ILIAS\Database\Tables;

class RolesPermissionTable
{
    private const TABLE_NAME = 'kpg_api_co_permission';

    public function install()
    {
        global $ilDB;
        if (!$ilDB->tableExists(self::TABLE_NAME)) {
            $fields = [
                'component_name' => [
                    'type' => 'text',
                    'length' => 255,
                    'notnull' => true
                ],
                'role_id' => [
                    'type' => 'integer',
                    'length' => 4,
                    'notnull' => true

                ],
                'permission' => [
                    'type' => 'text',
                    'length' => 255,
                    'notnull' => false
                ],

            ];
            $ilDB->createTable(self::TABLE_NAME, $fields);
            $ilDB->addPrimaryKey(self::TABLE_NAME, ['component_name', 'role_id']);
        }
    }

    public function uninstall()
    {
        global $ilDB;
        if ($ilDB->tableExists(self::TABLE_NAME)) {
            $ilDB->dropTable(self::TABLE_NAME);
        }
    }

    public function insertOrUpdatePermission(string $component_name, int $role_id, string $permission): bool
    {
        global $ilDB;
        $sql = "INSERT INTO " . self::TABLE_NAME . " (component_name, role_id, permission) 
        VALUES (" . $ilDB->quote($component_name, "string") . ", " . $ilDB->quote($role_id, "integer") . ", " . $ilDB->quote(
            $permission,
            "text"
        ) . ")
            ON DUPLICATE KEY UPDATE 
            component_name = " . $ilDB->quote($component_name, "string") . ",
            role_id = " . $ilDB->quote($role_id, "integer") . ",
            permission = " . $ilDB->quote($permission, "text") . "
        ";
        $ilDB->manipulate($sql);
        return true;
    }
    public function getPermissionByComponentNameAndRoleID(string $component_name, int $role_id)
    {
        global $ilDB;
        $sql = "SELECT permission FROM " . self::TABLE_NAME . " WHERE component_name = " . $ilDB->quote($component_name, "string") . " AND role_id = " . $ilDB->quote($role_id, "integer") . "
        ";
        $result = $ilDB->query($sql);
        $result = $ilDB->fetchAssoc($result);
        if (!$result) {
            return '';
        }
        return $result['permission'];
    }

    public function deletePermission(string $name, int $role_id): void
    {
        global $ilDB;
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE component_name = " . $ilDB->quote($name, "string") . " AND role_id = " . $ilDB->quote($role_id, "integer") . "
        ";
        $ilDB->manipulate($sql);
    }
    public function deletePermissionByRoleID(int $role_id): void
    {
        global $ilDB;
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE role_id = " . $ilDB->quote($role_id, "integer") . "
        ";
        $ilDB->manipulate($sql);
    }
    public function getAllByRoleID(int $role_id)
    {
        global $ilDB;
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE role_id = " . $ilDB->quote($role_id, "integer") . "";
        $result = $ilDB->query($sql);
        $records = null;
        while ($record = $ilDB->fetchAssoc($result)) {
            $records[] = $record;
        }
        return $records;
    }
}
