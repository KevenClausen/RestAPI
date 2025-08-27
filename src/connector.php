<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use KPG\RestAPI\ILIAS\Authenticator;
use KPG\RestAPI\ILIAS\ILIASInit;
use KPG\RestAPI\ILIAS\Logger\Logger;

require_once('ILIASInit.php');
ILIASInit::init();

try {
    $authenticator = new Authenticator();
    if ($authenticator->auth()) {
        global $DIC;
        Logger::setUserId($DIC->user()->getId());
        (new \KPG\RestAPI\API\HTTP\Request())->route();
    } else {
        (new \KPG\RestAPI\API\HTTP\Response())->send401();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
