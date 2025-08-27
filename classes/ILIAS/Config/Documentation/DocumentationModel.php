<?php

namespace ILIAS\Config\Documentation;

use KPG\RestAPI\ILIAS\Util\Roles;
use KPG\RestAPI\ILIAS\Authenticator;
use KPG\RestAPI\ILIAS\Database\Tables\APIPermissionTable;
use KPG\RestAPI\ILIAS\Database\Tables\RolesPermissionTable;

class DocumentationModel
{
    use Roles;

    public function getDocumentationData(bool $filtern = false): string
    {
        return $this->filterDocumentationData(file_get_contents(__DIR__ . '/structure/openapi.json'));
    }

    public function filterDocumentationData(string $json): string
    {

        global $DIC;
        if (self::isUserAdmin($DIC->user()->getId())) {
            return $json;
        }
        $auth = new Authenticator();
        if ($auth->checkFullAccessPermission($DIC->user()->getId())) {
            return $json;
        }

        $user_role = self::getGlobalRolesByUserID($DIC->user()->getId());

        $tbl_api_permission = new APIPermissionTable();
        $tbl_api_co_permission = new RolesPermissionTable();
        $http_permissions = [];

        foreach ($user_role as $role) {
            if ($tbl_api_permission->getPermissionByRoleID($role) == 1) {
                $co_permission = $tbl_api_co_permission->getAllByRoleID($role);
                if ($co_permission != null) {
                    $permissions = $tbl_api_co_permission->getAllByRoleID($role);
                    foreach ($permissions as $permission) {
                        if (!array_key_exists($permission['component_name'], $http_permissions)) {
                            $http_permissions[$permission['component_name']] = explode(',', $permission['permission']);
                        } else {
                            $http_permissions[$permission['component_name']] = array_unique(
                                array_merge(
                                    $http_permissions[$permission['component_name']],
                                    explode(',', $permission['permission'])
                                )
                            );
                        }
                    }
                }
            }
        }

        $json = json_decode($json, true);
        $filteredTags = [];
        $filteredPaths = [];

        foreach ($json['tags'] as $tag) {
            if (isset($http_permissions[$tag['name']])) {
                $filteredTags[] = $tag;
            }
        }
        foreach ($json['paths'] as $path => $methods) {
            $newMethods = [];
            foreach ($methods as $method => $details) {
                $tags = $details['tags'] ?? [];
                if (empty($tags)) {
                    continue;
                }
                $tag = $tags[0];
                if (isset($http_permissions[$tag]) && in_array(strtoupper($method), $http_permissions[$tag])) {
                    $newMethods[$method] = $details;
                }
            }
            if (!empty($newMethods)) {
                $filteredPaths[$path] = $newMethods;
            }
        }
        $json['tags'] = $filteredTags;
        $json['paths'] = $filteredPaths;
        $filteredJson = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $filteredJson;
    }

}
