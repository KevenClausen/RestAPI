<?php

namespace KPG\RestAPI\ILIAS\Logger;

class Logger
{
    private static int $user_id = 0;
    private static string $requestUrl = "";
    private static string $httpMethod = "";
    private static string $requestBody = "";
    private static string $responseBody = "";
    private static int $responseCode = 000;

    public static function setUserId(int $user_id): void
    {
        self::$user_id = $user_id;
    }

    public static function setRequestUrl(string $request_url): void
    {
        self::$requestUrl = $request_url;
    }

    public static function setHttpMethod(string $http_method): void
    {
        self::$httpMethod = $http_method;
    }

    public static function setRequestBody(string $request_body): void
    {
        self::$requestBody = $request_body;
    }

    public static function setResponseBody(string $response_body): void
    {
        self::$responseBody = $response_body;
    }

    public static function setResponseCode(int $response_code): void
    {
        self::$responseCode = $response_code;
    }

    public static function writeLog(): void
    {
        /*  (new ApiLogs())->writeLog([
              'user_id' => self::$user_id,
              'requestUrl' => self::$requestUrl,
              'httpMethod' => self::$httpMethod,
              'requestBody' => self::$requestBody,
              'responseBody' => self::$responseBody,
              'responseCode' => self::$responseCode,
          ]); */
    }
}
