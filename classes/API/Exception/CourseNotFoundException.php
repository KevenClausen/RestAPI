<?php
namespace KPG\RestAPI\API\Exception;

class CourseNotFoundException extends BaseException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'COURSE_NOT_FOUND';
}