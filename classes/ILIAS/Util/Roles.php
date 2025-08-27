<?php

namespace KPG\RestAPI\ILIAS\Util;

trait Roles
{
    public static function getAllGlobalRoles(): array
    {
        global $DIC;
        $global_roles = [];
        foreach ($DIC->rbac()->review()->getGlobalRoles() as $role) {
            if ($role == SYSTEM_ROLE_ID) {
                continue;
            }
            $title = self::getRoleNameByRoleID($role);
            if ($title === "Anonymous" || $title === "Guest") {
                continue;
            }
            $global_roles[$role] = $title;
        }
        return $global_roles;
    }

    public static function getGlobalRolesByUserID(int $user_id): array
    {
        global $DIC;
        return $DIC->rbac()->review()->assignedGlobalRoles($user_id);
    }

    public static function isUserAdmin(int $user_id): bool
    {
        return in_array(SYSTEM_ROLE_ID, self::getGlobalRolesByUserID($user_id));
    }

    public static function getRoleNameByRoleID(int $role_id): string
    {
        return \ilObjRole::_lookupTitle($role_id);
    }
}
