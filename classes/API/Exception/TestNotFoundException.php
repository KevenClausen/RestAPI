<?php

namespace KPG\RestAPI\API\Exception;

class TestNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'TEST_NOT_FOUND';
}
