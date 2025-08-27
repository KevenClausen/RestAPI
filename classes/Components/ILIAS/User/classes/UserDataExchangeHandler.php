<?php

namespace KPG\RestAPI\ILIAS\User\classes;

use KPG\RestAPI\API\Exception\UserNotFoundException;
use ReflectionClass;
use KPG\RestAPI\API\Exception\RequierdFieldsNotFoundException;
use KPG\RestAPI\API\Exception\UserLoginExistsException;

class UserDataExchangeHandler
{
    private array $not_valid_property = [
        'password',
        'roles',
        'timezone',
        'timeformat',
        'dateformat',
        'passwdtype',
        'passwordage',
        'pcclipboardcontent',
        'orgunitsrepresentation',
        'publicname',
        'personaldataexportfile',
        'generalinterestsastext',
        'offeringhelpastext',
        'lookingforhelpastext',
        'presentationtitle',
        'untranslatedtitle',
        'longdescription',
        'ownername',
        'createdate',
        'lastupdatedate',
        'xmlzip',
        'htmldirectory',
        'AllUserLogins',
        'Avatar',
        'Objectproperties'
    ];
    private $DIC;
    private UserUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new UserUtilHandler();
    }

    public function exportUsers(string $user_id): array
    {
        $arr_usr_ids = explode(',', $user_id);
        $export_array = [];
        foreach ($arr_usr_ids as $usr_id) {
            $export_array[] = $this->exportUser((int)$usr_id);
        }
        return $export_array;
    }

    public function exportUser(int $user_id): array
    {
        if (!$this->utilHandler->userExists($user_id)) {
            throw new UserNotFoundException(['failed_user_id' => $user_id]);;
        }

        $obj_user = new \ilObjUser($user_id);
        $export_array = [];
        $reflectionClass = new ReflectionClass($obj_user);
        foreach ($reflectionClass->getMethods() as $method) {
            $method_name = $method->name;
            if ($method->isPublic() &&
                strpos($method_name, 'get') === 0 &&
                $method->getNumberOfParameters() === 0 &&
                $this->verifyMethods($method_name)
            ) {
                $export_array[strtolower(substr($method_name, 3))] = $obj_user->$method_name();
            }
        }
        $export_array['roles'] = $this->DIC->rbac()->review()->assignedRoles($user_id);

        $handler = new UserHandler();
        $export_array['userdefineddata'] = $handler->getUserDefinedValues($user_id);

        return $export_array;
    }

    public function importUsers(array $import_array): array
    {
        $new_user_ids = [];
        if ($this->isAssociativeArray($import_array)) {
            $new_user_ids[] = $this->importUser($import_array);
        } else {
            foreach ($import_array as $import_user) {
                $new_user_ids[] = $this->importUser($import_user);
            }
        }

        return $new_user_ids;
    }

    public function importUser(array $import_array): int
    {
        $this->verifyImportData($import_array);

        $new_obj_user = new \ilObjUser();
        $new_obj_user->setLogin($import_array['login']);
        $new_obj_user->setPasswd($import_array['passwd']);

        foreach ($import_array as $key => $value) {
            if (in_array($key, $this->not_valid_property)) {
                continue;
            }
            if(!in_array($key, ['userdefineddata', 'roles'])) {
                $method_name = "set" . ucfirst($key);
                $new_obj_user->$method_name($value);
            }
        }
        if (array_key_exists('roles', $import_array) && !empty($import_array['roles'])) {
            foreach ($import_array['roles'] as $role_id) {
                if ($this->DIC->rbac()->review()->roleExists(\ilObjRole::_lookupTitle($role_id))) {
                    $this->DIC->rbac()->admin()->assignUser($role_id, $new_obj_user->getId());
                }
            }
        }
        $handler = new UserHandler();
        if (array_key_exists('userdefineddata', $import_array) && !empty($import_array['userdefineddata'])) {
            $handler->setUserDefinedValues($new_obj_user->getId(), $import_array['userdefineddata']);
        }
        $new_obj_user->create();
        $new_obj_user->saveAsNew();
        return $new_obj_user->getId();
    }

    public function verifyMethods(string $method_name): bool
    {
        $modified_not_valid_property = array_map(function ($property) {
            return 'get' . ucfirst($property);
        }, $this->not_valid_property);
        return !in_array($method_name, $modified_not_valid_property);
    }

    public function verifyImportData($import_array): void
    {
        $missing_required_fields = [];
        if (!array_key_exists('login', $import_array)) {
            $missing_required_fields[] = 'login';
        }
        if (!array_key_exists('passwd', $import_array)) {
            $missing_required_fields[] = 'passwd';
        }
        if (!empty($missing_required_fields)) {
            throw new RequierdFieldsNotFoundException(
                ['Missing required fields: ' => implode(', ', $missing_required_fields)]
            );
        }
        if (\ilObjUser::_loginExists($import_array['login'])) {
            throw new UserLoginExistsException(['login' => $import_array['login']]);
        }
    }

    public function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

}
