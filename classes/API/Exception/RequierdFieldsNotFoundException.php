<?php

namespace KPG\RestAPI\API\Exception;

class RequierdFieldsNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'USER_REQUIERD_FIELD_NOT_FOUND';
}
