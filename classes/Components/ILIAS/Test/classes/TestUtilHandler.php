<?php

namespace KPG\RestAPI\ILIAS\Test;

class TestUtilHandler
{
    public function testExists(int $test_ref_id, bool $referenz = true): bool
    {
        if (\ilObject::_exists((int) $test_ref_id, $referenz, 'tst')) {
            return true;
        } else {
            return false;
        }
    }
}
