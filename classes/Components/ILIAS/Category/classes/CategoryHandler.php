<?php

namespace KPG\RestAPI\ILIAS\Category\classes;


use KPG\RestAPI\API\Exception\CategoryNotFoundException;

class CategoryHandler
{
    private $DIC;
    private CategoryUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new CategoryUtilHandler();
    }

    public function getCategory(int $cat_ref_id = null): array
    {
        if ($cat_ref_id == null) {
            $ref_ids = [];
            foreach (\ilObject::_getObjectsByType('cat') as $obj_test) {
                foreach (\ilObjCourse::_getAllReferences($obj_test['obj_id']) as $ref_id) {
                    if (\ilObject::_isInTrash($ref_id)) {
                        continue;
                    }
                    $ref_ids[] = $ref_id;
                }
            }
            $cats = [];
            foreach ($ref_ids as $ref_id) {
                $cats[] = [
                    'ref_id' => $ref_id,
                    'obj_id' => \ilObjTest::_lookupObjId($ref_id),
                    'title' => \ilObjTest::_lookupTitle(\ilObjTest::_lookupObjId($ref_id)),
                    'parent_id' => $this->DIC->repositoryTree()->getParentId($ref_id)
                ];
            }
            return $cats;
        } else {
            if (!$this->utilHandler->categoryExists($cat_ref_id)) {
                throw new CategoryNotFoundException();
            }
            $obj_category = new \ilObjCategory($cat_ref_id);
            $category_information = [
                'ref_id' => $cat_ref_id,
                'obj_id' => \ilObjTest::_lookupObjId($cat_ref_id),
                'title' => $obj_category->getTitle(),
                'presentation_title' => $obj_category->getPresentationTitle(),
                'description' => $obj_category->getDescription(),
                'long_description' => $obj_category->getLongDescription(),
                'offline_status' => $obj_category->getOfflineStatus(),
                'owner' => $obj_category->getOwner(),
                'create_date' => $obj_category->getCreateDate(),
            ];
            return $category_information;
        }
    }
}