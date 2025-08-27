<?php
namespace KPG\RestAPI\ILIAS\Repository\classes;

class RepositoryAdvanceMetaDataHandler {

    public function getAdvanceMetaDataByRefID(int $ref_id)
    {
        $all_meta_data = [];
        $all_fields = \ilAdvancedMDValues::findByObjectId(\ilObject::_lookupObjId($ref_id));
        $obj_type = \ilObject::_lookupType($ref_id, true);

        foreach (\ilAdvancedMDRecord::_getSelectedRecordsByObject($obj_type, $ref_id) as $record) {
            $record_title = $record->getTitle();
                foreach ($all_fields as $field_information) {

                    if (!array_key_exists('value', $field_information)) {
                        continue;
                    }
                    $field_obj = \ilAdvancedMDFieldDefinition::getInstance($field_information['field_id']);
                    $all_meta_data[$record_title][$field_obj->getTitle()] = $field_information['value'];
                }

        }
        return $all_meta_data;
    }
}