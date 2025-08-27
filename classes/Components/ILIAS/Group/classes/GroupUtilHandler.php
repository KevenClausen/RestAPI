<?php

namespace KPG\RestAPI\ILIAS\Group\classes;

use KPG\RestAPI\API\Exception\DefaultRoleNotFoundException;

class GroupUtilHandler
{
    public function groupExists(int $id, bool $referenz = true): bool
    {
        if (\ilObject::_exists((int) $id, $referenz, 'grp')) {
            return true;
        } else {
            return false;
        }
    }

    public function userExists(int $id): bool
    {
        if (\ilObjUser::_exists($id)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByDefaultRole(\ilObjGroup $obj_group, string $default_role): array
    {
        $users = [];
        switch ($default_role) {
            case "member":
                foreach ($obj_group->getMembersObject()->getAdmins() as $user_id) {
                    $obj_user = new \ilObjUser($user_id);
                    $users[] = [
                        'user_id' => $user_id,
                        "login" => $obj_user->getLogin(),
                        "firstname" => $obj_user->getFirstname(),
                        "lastname" => $obj_user->getLastname()
                    ];
                }
                break;
            case "admin":
                foreach ($obj_group->getMembersObject()->getMembers() as $user_id) {
                    $obj_user = new \ilObjUser($user_id);
                    $users[] = [
                        'user_id' => $user_id,
                        "login" => $obj_user->getLogin(),
                        "firstname" => $obj_user->getFirstname(),
                        "lastname" => $obj_user->getLastname()
                    ];
                }
                break;
            default:
                throw new DefaultRoleNotFoundException();
        }
        return $users;
    }
}
