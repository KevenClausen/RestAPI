<?php

use KPG\RestAPI\ILIAS\Authenticator;
use KPG\RestAPI\ILIAS\ILIASInit;
use KPG\RestAPI\API\Logger\Logger;
use KPG\RestAPI\API\HTTP\Request;
use KPG\RestAPI\API\HTTP\Response;

Logger::startTime();

require_once('ILIASInit.php');
ILIASInit::init();

try {
    $authenticator = new Authenticator();
    if ($authenticator->auth()) {
        global $DIC;
        Logger::setUserId($DIC->user()->getId());
        (new Request())->route();
    } else {
        (new Response())->send401();
    }
} catch (Exception $e) {
    if (defined('DEVMODE') && DEVMODE) {
        echo $e->getMessage();
    } else {
        Response::send500();
    }
}
