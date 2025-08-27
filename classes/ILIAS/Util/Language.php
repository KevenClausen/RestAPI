<?php

namespace KPG\RestAPI\ILIAS\Util;

trait Language
{
    public static function getLang(string $lang_var): string
    {
        $plugin_slot_id = "evnt_evhk";
        $plugin_id = "KPG_REST_API";
        global $DIC;
        $DIC->language()->loadLanguageModule($plugin_slot_id . "_" . $plugin_id);
        return $DIC->language()->txt($plugin_slot_id . "_" . $plugin_id . '_' . $lang_var);
    }
}
