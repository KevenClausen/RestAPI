<?php

namespace KPG\RestAPI\ILIAS\Database;

class DatabaseSetup
{
    private array $table_fields = [
        'kpg_api_component' => [
            'component_name' => [
                'type' => 'text',
                'length' => 255,
                'notnull' => true
            ],
            'role_id' => [
                'type' => 'integer',
                'length' => 4,
                'notnull' => true
            ],
            'permission' => [
                'type' => 'text',
                'length' => 255,
                'notnull' => false
            ],
        ],
        'kpg_api_role' => [
            'role_id' => [
                'type' => 'integer',
                'length' => 4,
                'notnull' => true
            ],
            'permission' => [
                'type' => 'integer',
                'length' => 1,
                'notnull' => false
            ],
        ],
        'kpg_api_log' => [
            'id' => [
                'type' => 'integer',
                'length' => 4,
                'notnull' => true
            ],
            'timestamp' => [
                'type' => 'integer',
                'length' => 8,
                'notnull' => false
            ],
            'user_id' => [
                'type' => 'integer',
                'length' => 4,
                'notnull' => false
            ],
            'request_url' => [
                'type' => 'clob',
            ],
            'http_method' => [
                'type' => 'text',
                'length' => 20,
                'notnull' => false
            ],
            'request_body' => [
                'type' => 'clob',
                'notnull' => false
            ],
            'response_body' => [
                'type' => 'clob',
                'notnull' => false
            ],
            'response_code' => [
                'type' => 'integer',
                'length' => 4,
                'notnull' => true
            ],
            'execution_time' => [
                'type' => 'float',
                'notnull' => false
            ]
        ]
    ];
    public function install(\ilDBInterface $database)
    {
        global $ilDB;
        foreach ($this->table_fields as $table_name => $fields) {
            if (!$ilDB->tableExists($table_name)) {
                $ilDB->createTable($table_name, $fields);
            }
            switch ($table_name) {
                case 'kpg_api_component':
                    $ilDB->addPrimaryKey($table_name, ['component_name', 'role_id']);
                    break;
                case 'kpg_api_role':
                    $ilDB->addPrimaryKey($table_name, ['role_id']);
                    break;
                case 'kpg_api_log':
                    $ilDB->addPrimaryKey($table_name, ['id']);
            }
        }
    }

    public function uninstall(\ilDBInterface $database)
    {
        global $ilDB;
        foreach ($this->table_fields as $table_name => $fields) {
            if ($ilDB->tableExists($table_name)) {
                $ilDB->dropTable($table_name);
            }
        }
    }
}
