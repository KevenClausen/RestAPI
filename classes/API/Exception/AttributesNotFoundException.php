<?php
namespace KPG\RestAPI\API\Exception;

class AttributesNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'ATTRIBUTES_NOT_FOUND';
}