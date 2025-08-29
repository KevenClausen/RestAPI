<?php

namespace KPG\RestAPI\API\HTTP;

use KPG\RestAPI\API\QueryParameters\QueryProcessor;
use KPG\RestAPI\API\RequestData;
use KPG\RestAPI\API\Logger\Logger;

class Response
{
    public RequestData $obj_requestData;
    private array $responseData = [];
    private array $meta = [];
    private int $responseCode = 200;
    private string $error_code = "";

    public function __construct(?RequestData $obj_requestData = null)
    {
        if ($obj_requestData != null) {
            $this->obj_requestData = $obj_requestData;
        }
    }

    public function setResponseData(array $data): void
    {
        $this->responseData = $data;
        if ($this->error_code === "") {
            if (array_key_exists(0, $this->responseData)) {
                $obj_queryProcessor = new QueryProcessor($this->responseData, $this->obj_requestData);
                $this->responseData = $obj_queryProcessor->process();
                $this->meta = $obj_queryProcessor->getMetadata();
            }
            $this->meta['total'] = count($this->responseData);
        }
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    public function setResponseCode(int $code): void
    {
        $this->responseCode = $code;
    }

    public function setError(string $code): void
    {
        $this->error_code = $code;
    }

    public function send200(): void
    {
        $this->setResponseCode(200);
        $this->send();
    }

    public function send404(): void
    {
        $this->setResponseCode(404);
        $this->setError("ROUTE_NOT_FOUND");
        $this->send();
    }

    public function send201(): void
    {
        $this->setResponseCode(201);
        $this->send();
    }

    public function send401(): void
    {
        $this->setResponseCode(401);
        $this->setError("AUTH_FAILED");
        $this->send();
    }

    public function send500(): void
    {
        $this->setResponseCode(500);
        $this->setError("SERVER_ERROR");
        $this->send();
    }

    public function send(): void
    {
        http_response_code($this->responseCode);
        $responseBody['status_code'] = $this->responseCode;
        $responseBody['error_code'] = $this->error_code;
        $responseBody['response_data'] = $this->responseData;
        if ($this->meta != []) {
            $responseBody['meta'] = $this->meta;
        }
        $json_response = json_encode($responseBody);
        Logger::setResponseBody($json_response);
        Logger::setResponseCode($this->responseCode);
        header('Content-Type: application/json');
        echo $json_response;
        Logger::stopTime();
        Logger::writeLog();
        exit();
    }
}
