<?php

namespace KPG\RestAPI\API\Exception;

class DefaultRoleNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'DEFAULT_ROLE_NOT_FOUND';
}
