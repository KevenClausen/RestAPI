<?php

namespace KPG\RestAPI\API\Exception;

use KPG\RestAPI\API\HTTP\Response;

abstract class BaseException extends \Exception
{
    protected int $httpCode = 500;
    protected string $errorCode = 'INTERNAL_SERVER_ERROR';
    protected array $errorDetails = [];

    public function __construct(?array $errorDetails = null)
    {
        parent::__construct();
        if ($errorDetails !== null) {
            $this->errorDetails = $errorDetails;
        }
    }

    public function sendErrorResponse(Response $response): void
    {
        $response->setResponseCode($this->httpCode);
        $response->setError($this->errorCode);
        if (!empty($this->errorDetails)) {
            $response->setResponseData($this->errorDetails);
        }
        $response->send();
    }
}
