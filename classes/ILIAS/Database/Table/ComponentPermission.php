<?php

namespace KPG\RestAPI\ILIAS\Database\Table;

class ComponentPermission extends \ActiveRecord
{
    public const TABLE_NAME = 'kpg_api_component';
    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype text
     * @con_length    255
     * @con_is_notnull true
     */
    private $component_name;
    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    4
     * @con_is_notnull true
     */
    private $role_id;
    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    1
     * @con_is_notnull true
     */
    private $permission;

}
