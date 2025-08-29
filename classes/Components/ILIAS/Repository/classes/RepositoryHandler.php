<?php

namespace KPG\RestAPI\ILIAS\Repository\classes;

use ilObject;
use KPG\RestAPI\API\Exception\ObjectNotFoundException;

class RepositoryHandler
{
    private $DIC;
    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
    }

    public function objectExist(int $ref_id): bool
    {
        return \ilObject::_exists($ref_id, true);
    }

    public function getObjectType(int $ref_id): string
    {
        if (!$this->objectExist($ref_id)) {
            throw new ObjectNotFoundException();
        }
        return \ilObject::_lookupType($ref_id, true);
    }

    public function getObjectInformations(int $ref_id): array
    {
        if (!$this->objectExist($ref_id)) {
            throw new ObjectNotFoundException();
        }
        $object = new \ilObject();
        $object->setRefId($ref_id);
        $object->setType(ilObject::_lookupType($ref_id, true));
        $object->read();
        return [
            "title" => $object->getTitle(),
            "descripton" => $object->getDescription(),
            "long_description" => $object->getLongDescription(),
            "object_id" => $object->getId(),
            "ref_id" => $object->getRefId(),
            "type" => $object->getType(),
            "owner_user_id" => $object->getOwner(),
            "owner_name" => $object->getOwnerName(),
            "online" => $object->getOfflineStatus(),
            "last_update" => $object->getLastUpdateDate(),
            "creation_date" => $object->getCreateDate(),
            'parent_id' => $this->DIC->repositoryTree()->getParentId($ref_id),
            'childs' => $this->DIC->repositoryTree()->getChilds($ref_id),
            "possible_sub_objects" => $object->getPossibleSubObjects()
        ];
    }

    public function deleteObject(int $ref_id): void
    {
        if (!$this->objectExist($ref_id)) {
            throw new ObjectNotFoundException();
        }
        $object = new \ilObject();
        $object->setRefId($ref_id);
        $object->setType(ilObject::_lookupType($ref_id, true));
        $object->read();
        $object->delete();
    }

    public function getParent(int $ref_id): array|bool
    {
        if (!$this->objectExist($ref_id)) {
            throw new ObjectNotFoundException();
        }
        global $DIC;
        $parent['ref_id'] = $DIC->repositoryTree()->getParentId($ref_id);
        $parent['obj_id'] = \ilObject::_lookupObjId($DIC->repositoryTree()->getParentId($ref_id));
        $parent['title'] = \ilObject::_lookupTitle(
            \ilObject::_lookupObjId($DIC->repositoryTree()->getParentId($ref_id))
        );
        $parent['type'] = \ilObject::_lookupType(\ilObject::_lookupObjId($DIC->repositoryTree()->getParentId($ref_id)));
        return $parent;
    }

    public function getChildrens(int $ref_id): array|bool
    {
        if (!$this->objectExist($ref_id)) {
            throw new ObjectNotFoundException();
        }
        global $DIC;
        $childs = [];
        foreach ($DIC->repositoryTree()->getChilds($ref_id) as $child) {
            $childs[$child['ref_id']]['ref_id'] = (int) $child['ref_id'];
            $childs[$child['ref_id']]['obj_id'] = \ilObject::_lookupObjId($child['ref_id']);
            $childs[$child['ref_id']]['title'] = $child['title'];
            $childs[$child['ref_id']]['type'] = \ilObject::_lookupType(\ilObject::_lookupObjId($child['ref_id']));
        }
        return $childs;
    }
}
