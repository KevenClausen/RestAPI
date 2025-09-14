<?php

namespace KPG\RestAPI\ILIAS\Database\Repository;

class RolePermissionTable
{
    private const TABLE_NAME = 'kpg_api_role';

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

    public function getPermissionByRoleID(int $role_id): int
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

    public function getAll(): array
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

    public function getCustomRoles(): array
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
