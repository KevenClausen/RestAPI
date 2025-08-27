<?php
namespace KPG\RestAPI\API\Exception;

class ObjectNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'OBJECT_NOT_FOUND';
}