<?php

namespace KPG\RestAPI\ILIAS\Database\Table;

class Log extends \ActiveRecord
{
    public const TABLE_NAME = 'kpg_api_log';

    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    4
     * @con_is_notnull true
     */
    private $id;

    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    8
     * @con_is_notnull false
     */
    private $timestamp;

    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    4
     * @con_is_notnull false
     */
    private $user_id;

    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype clob
     * @con_is_notnull false
     */
    private $request_url;

    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype text
     * @con_length    20
     * @con_is_notnull false
     */
    private $http_method;

    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype clob
     * @con_is_notnull false
     */
    private $request_body;

    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype clob
     * @con_is_notnull false
     */
    private $response_body;

    /**
     * @var int
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    4
     * @con_is_notnull true
     */
    private $response_code;

    /**
     * @var float
     *
     * @con_has_field true
     * @con_fieldtype float
     * @con_is_notnull false
     */
    private $execution_time;
}
