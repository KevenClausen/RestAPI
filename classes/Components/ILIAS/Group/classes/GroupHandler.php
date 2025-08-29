<?php

namespace KPG\RestAPI\ILIAS\Group\classes;

use KPG\RestAPI\API\Exception\GroupNotFoundException;
use KPG\RestAPI\API\Exception\AttributesNotFoundException;

class GroupHandler
{
    private $DIC;
    private GroupUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new GroupUtilHandler();
    }

    public function getGroup(int $ref_id = null): array
    {
        if ($ref_id == null) {
            $ref_ids = [];
            foreach (\ilObject::_getObjectsByType('grp') as $obj_grp) {
                foreach (\ilObjGroup::_getAllReferences($obj_grp['obj_id']) as $ref_id) {
                    if (\ilObject::_isInTrash($ref_id)) {
                        continue;
                    }
                    $ref_ids[] = $ref_id;
                }
            }
            $groups = [];
            foreach ($ref_ids as $ref_id) {
                $groups[] = [
                    'ref_id' => $ref_id,
                    'obj_id' => \ilObjCourse::_lookupObjId($ref_id),
                    'title' => \ilObjCourse::_lookupTitle(\ilObjCourse::_lookupObjId($ref_id)),
                    'parent_id' => $this->DIC->repositoryTree()->getParentId($ref_id)
                ];
            }
            return $groups;
        } else {
            if (!$this->utilHandler->groupExists($ref_id)) {
                throw new GroupNotFoundException();
            }
            $obj_group = new \ilObjGroup($ref_id);

            $group_information['ref_id'] = $ref_id;
            $group_information['obj_id'] = \ilObjCourse::_lookupObjId($ref_id);
            $group_information['title'] = $obj_group->getTitle();
            $group_information['description'] = $obj_group->getDescription();
            $group_information['long_description'] = $obj_group->getLongDescription();
            $group_information['owner'] = ['id' => $obj_group->getOwner(), 'name' => $obj_group->getOwnerName()];
            $group_information['create_date'] = $obj_group->getCreateDate();
            $group_information['last_update'] = $obj_group->getLastUpdateDate();
            $group_information['import_id'] = $obj_group->getImportId();
            $group_information['offline'] = $obj_group->getOfflineStatus();
            $group_information['default_roles'] = [
                'default_member_role' => $obj_group->getDefaultMemberRole(),
                'default_admin_role' => $obj_group->getDefaultAdminRole()
            ];
            $role_information = [];
            foreach ($this->DIC->rbac()->review()->getRolesOfObject($ref_id) as $role) {
                if (!$this->DIC->rbac()->review()->isGlobalRole($role)) {
                    $role_information[$role] = \ilObjectFactory::getInstanceByObjId($role, false)->getTitle();
                }
            }
            $group_information['roles'] = $role_information;
            $group_information['parent']['ref_id'] = $this->DIC->repositoryTree()->getParentId($ref_id);
            $group_information['parent']['obj_id'] = \ilObject::_lookupObjId(
                $this->DIC->repositoryTree()->getParentId($ref_id)
            );
            $group_information['parent']['title'] = \ilObject::_lookupTitle(
                \ilObject::_lookupObjId($this->DIC->repositoryTree()->getParentId($ref_id))
            );
            $group_information['parent']['type'] = \ilObject::_lookupType(
                \ilObject::_lookupObjId($this->DIC->repositoryTree()->getParentId($ref_id))
            );
            $group_information['childs'] = [];
            foreach ($this->DIC->repositoryTree()->getChilds($ref_id) as $child) {
                $group_information['childs'][$child['ref_id']]['ref_id'] = (int) $child['ref_id'];
                $group_information['childs'][$child['ref_id']]['obj_id'] = \ilObject::_lookupObjId($child['ref_id']);
                $group_information['childs'][$child['ref_id']]['title'] = $child['title'];
                $group_information['childs'][$child['ref_id']]['type'] = \ilObject::_lookupType(
                    \ilObject::_lookupObjId($child['ref_id'])
                );
            }
            return $group_information;
        }
    }

    public function updateGroup(int $ref_id, array $request_body): void
    {
        if (!$this->utilHandler->groupExists($ref_id)) {
            throw new GroupNotFoundException();
        }
        $obj_group = new \ilObjGroup($ref_id, true);
        $update_forwarded = true;
        $failed_methods = [];
        $success_methods = [];
        foreach ($request_body as $method => $value) {
            $method_name = 'set' . ucfirst($method);
            if (method_exists($obj_group, $method_name)) {
                $success_methods[$method_name] = $value;
            } else {
                $failed_methods[] = $method;
                $update_forwarded = false;
            }
        }
        if (!$update_forwarded) {
            throw new AttributesNotFoundException($failed_methods);
        }
        foreach ($success_methods as $method => $value) {
            $obj_group->$method($value);
        }
        $obj_group->update();
    }

    public function getGroupInformation($group_ref_id, $group_property): string
    {
        if (!$this->utilHandler->groupExists($group_ref_id)) {
            throw new GroupNotFoundException();
        }
        $obj_group = new \ilObjGroup($group_ref_id, true);
        $obj_methode = "get" . ucfirst($group_property);
        if (!method_exists($obj_group, $obj_methode)) {
            throw new AttributesNotFoundException([$group_property]);
        }
        $property_value = $obj_group->$obj_methode();
        return $property_value;
    }

    public function getGroupRoles(int $group_ref_id): array
    {
        if (!$this->utilHandler->groupExists($group_ref_id)) {
            throw new GroupNotFoundException();
        }
        $roles = [];
        foreach ($this->DIC->rbac()->review()->getRolesOfObject($group_ref_id) as $role) {
            if (!$this->DIC->rbac()->review()->isGlobalRole($role)) {
                $roles[$role] = \ilObjectFactory::getInstanceByObjId($role, false)->getTitle();
            }
        }
        return $roles;
    }
}
