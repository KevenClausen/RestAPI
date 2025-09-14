<?php

namespace KPG\RestAPI\API\Logger;

use KPG\RestAPI\ILIAS\Database\Repository\LogTable;

class Logger
{
    private static int $user_id = 0;
    private static string $request_url = "";
    private static string $http_method = "";
    private static string $request_body = "";
    private static string $response_body = "";
    private static int $response_code = 200;
    private static float $start_time;
    private static float $execution_time;

    public static function setUserId(int $user_id): void
    {
        self::$user_id = $user_id;
    }
    public static function startTime(): void
    {
        self::$start_time = microtime(true);
    }
    public static function stopTime(): void
    {
        $endTime = microtime(true);
        self::$execution_time = $endTime - self::$start_time;
    }

    public static function setRequestUrl(string $request_url): void
    {
        self::$request_url = $request_url;
    }

    public static function setHttpMethod(string $http_method): void
    {
        self::$http_method = $http_method;
    }

    public static function setRequestBody(string $request_body): void
    {
        self::$request_body = $request_body;
    }

    public static function setResponseBody(string $response_body): void
    {
        self::$response_body = $response_body;
    }

    public static function setResponseCode(int $response_code): void
    {
        self::$response_code = $response_code;
    }

    public static function writeLog(): void
    {
        (new LogTable())->writeLog([
            'user_id' => self::$user_id,
            'requestUrl' => self::$request_url,
            'httpMethod' => self::$http_method,
            'requestBody' => self::$request_body,
            'responseBody' => self::$response_body,
            'responseCode' => self::$response_code,
            'executionTime' => self::$execution_time,
        ]);
    }
}
