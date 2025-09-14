<?php

namespace KPG\RestAPI\ILIAS\Setting\Model;

use KPG\RestAPI\ILIAS\Setting\Base\BaseModel;
use KPG\RestAPI\ILIAS\Setting\Enum\Mode;
use KPG\RestAPI\ILIAS\Setting\Base\BaseSettingModifiyResult;

class APIPermission extends BaseModel
{
    public function set(Mode $mode): BaseSettingModifiyResult
    {
        switch ($mode) {
            case MODE::SAVE:
                $this->save();
                break;
        }
    }

    public function get(string $item): mixed
    {
        // TODO: Implement get() method.
    }
    private function save()
    {
        $i = 0;
    }
}
