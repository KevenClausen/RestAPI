<?php

namespace KPG\RestAPI\ILIAS\Database\Tables;

class APIPermissionTable
{
    private const TABLE_NAME = 'kpg_api_permission';

    public function install()
    {
        global $ilDB;
        if (!$ilDB->tableExists(self::TABLE_NAME)) {
            $fields = [
                'role_id' => [
                    'type' => 'integer',
                    'length' => 4,
                    'notnull' => true

                ],
                'permission' => [
                    'type' => 'integer',
                    'length' => 1,
                    'notnull' => false
                ],

            ];
            $ilDB->createTable(self::TABLE_NAME, $fields);
            $ilDB->addPrimaryKey(self::TABLE_NAME, ['role_id']);
        }
    }

    public function uninstall()
    {
        global $ilDB;
        if ($ilDB->tableExists(self::TABLE_NAME)) {
            $ilDB->dropTable(self::TABLE_NAME);
        }
    }

    public function insertOrUpdatePermission(int $role_id, int $permission): bool
    {
        global $ilDB;
        $sql = "INSERT INTO " . self::TABLE_NAME . " (role_id, permission) VALUES (" . $ilDB->quote(
            $role_id,
            "integer"
        ) . ", " . $ilDB->quote($permission, "integer") . ")
        ON DUPLICATE KEY UPDATE permission = " . $ilDB->quote($permission, "integer") . "
        ";
        $ilDB->manipulate($sql);
        return true;
    }

    public function getPermissionByRoleID(int $role_id)
    {
        global $ilDB;
        $sql = "SELECT permission FROM " . self::TABLE_NAME . " WHERE role_id = " . $ilDB->quote($role_id, "integer") . "
        ";
        $result = $ilDB->query($sql);

        $result = $ilDB->fetchAssoc($result);
        if (!$result) {
            return 0;
        }
        return $result['permission'];
    }

    public function getAll()
    {
        global $ilDB;
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $result = $ilDB->query($sql);
        $records = null;
        while ($record = $ilDB->fetchAssoc($result)) {
            $records[] = $record;
        }
        if (!$records) {
            return [];
        }
        return $records;
    }

    public function getCustomRoles()
    {
        global $ilDB;
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE permission = 1";
        $result = $ilDB->query($sql);
        $records = null;
        while ($record = $ilDB->fetchAssoc($result)) {
            $records[] = $record;
        }
        if (!$records) {
            return [];
        }
        return $records;
    }
}
