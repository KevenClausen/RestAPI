<?php

namespace KPG\RestAPI\ILIAS\Database\Repository;

class LogTable
{
    private const TABLE_NAME = 'kpg_api_log';

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
            'execution_time' => ['float', $log['executionTime']]
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
