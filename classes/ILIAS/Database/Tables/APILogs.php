<?php

namespace KPG\RestAPI\ILIAS\Database\Tables;

class APILogs
{
    private const TABLE_NAME = 'kpg_api_logs';

    public function install(): void
    {
        global $ilDB;
        if (!$ilDB->tableExists(self::TABLE_NAME)) {
            $fields = [
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
                'executionTime' => [
                    'type' => 'float',
                    'notnull' => false
                ]
            ];
            $ilDB->createTable(self::TABLE_NAME, $fields);
            $ilDB->addPrimaryKey(self::TABLE_NAME, ['id']);
            $ilDB->createSequence(self::TABLE_NAME);
        }
    }

    public function uninstall(): void
    {
        global $ilDB;
        if ($ilDB->tableExists(self::TABLE_NAME)) {
            $ilDB->dropTable(self::TABLE_NAME);
        }
    }

    public function writeLog(array $log): void
    {
        global $ilDB;
        $next_id = $ilDB->nextId(self::TABLE_NAME);
        $ilDB->insert(self::TABLE_NAME, [
            'id' => ['integer', $next_id],
            'timestamp' => ['integer', time()],
            'user_id' => ['integer', $log['user_id']],
            'request_url' => ['clob', $log['requestUrl']],
            'http_method' => ['text', $log['httpMethod']],
            'request_body' => ['clob', $log['requestBody']],
            'response_body' => ['clob', $log['responseBody']],
            'response_code' => ['integer', $log['responseCode']],
        ]);
    }

    public function deleteAll(): void
    {
        global $ilDB;
        $ilDB->manipulate("DELETE FROM " . self::TABLE_NAME);
    }

    public function getAll(): array
    {
        global $ilDB;
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $result = $ilDB->query($sql);
        $records = null;
        while ($record = $ilDB->fetchAssoc($result)) {
            $records[] = $record;
        }
        if (!$records) {
            return [];
        }
        return $records;
    }
}
