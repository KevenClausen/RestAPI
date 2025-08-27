<?php
namespace KPG\RestAPI\API\Exception;

class RoleNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'ROLE_NOT_FOUND';
}