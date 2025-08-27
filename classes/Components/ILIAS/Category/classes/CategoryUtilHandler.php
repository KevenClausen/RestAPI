<?php
namespace KPG\RestAPI\ILIAS\Category\classes;

class CategoryUtilHandler {

    public function categoryExists(int $test_ref_id, bool $referenz = true): bool
    {
        if (\ilObject::_exists((int) $test_ref_id, $referenz, 'cat')) {
            return true;
        } else {
            return false;
        }
    }
}