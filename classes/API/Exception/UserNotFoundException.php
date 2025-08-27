<?php
namespace KPG\RestAPI\API\Exception;

class UserNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'USER_NOT_FOUND';
}