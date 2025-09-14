<?php

namespace KPG\RestAPI\ILIAS\User\classes;

class UserUtilHandler
{
    public function userExists(int $id): bool
    {
        if (\ilObjUser::_exists($id)) {
            return true;
        } else {
            return false;
        }
    }
    public function roleExists(int $id): bool
    {
        if (\ilObjRole::_exists($id)) {
            return true;
        } else {
            return false;
        }
    }
}
