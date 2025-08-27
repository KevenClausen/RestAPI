<?php
namespace KPG\RestAPI\API\Exception;

class GroupNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'GROUP_NOT_FOUND';
}