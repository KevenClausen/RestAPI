<?php

namespace KPG\RestAPI\API\Exception;

class CategoryNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'CATEGORY_NOT_FOUND';
}
