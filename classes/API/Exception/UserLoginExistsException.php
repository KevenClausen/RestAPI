<?php
namespace KPG\RestAPI\API\Exception;

class UserLoginExistsException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'USER_LOGIN_EXISTS';
}