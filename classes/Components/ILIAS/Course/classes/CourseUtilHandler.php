<?php

namespace KPG\RestAPI\ILIAS\Course\classes;

use KPG\RestAPI\API\Exception\DefaultRoleNotFoundException;

class CourseUtilHandler
{
    public function courseExists(int $id, bool $referenz = true): bool
    {
        if (\ilObject::_exists((int) $id, $referenz, 'crs')) {
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

    public function getUserByDefaultRole(\ilObject $course, $default_role = "member"): array
    {
        $users = [];
        switch ($default_role) {
            case "member":
                foreach ($course->getMembersObject()->getAdmins() as $user_id) {
                    $obj_user = new \ilObjUser($user_id);
                    $users[] = [
                        'user_id' => $user_id,
                        "login" => $obj_user->getLogin(),
                        "firstname" => $obj_user->getFirstname(),
                        "lastname" => $obj_user->getLastname()
                    ];
                }
                break;
            case "tutor":
                foreach ($course->getMembersObject()->getTutors() as $user_id) {
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
                foreach ($course->getMembersObject()->getMembers() as $user_id) {
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
