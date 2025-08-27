<?php

namespace KPG\RestAPI\ILIAS;

use ilInitialisation;

chdir("../../../../../../../../");

include_once "Services/Context/classes/class.ilContext.php";
include_once "Services/Init/classes/class.ilInitialisation.php";

class ILIASInit extends ilInitialisation
{
    public static function init()
    {
        \ilContext::init(\ilContext::CONTEXT_REST);
        \ilInitialisation::initILIAS();
        self::initGlobal('ilUser', 'ilObjUser', './Services/User/classes/class.ilObjUser.php');
        global $DIC;
        self::initAccessHandling();
        self::initAccessibilityControlConcept($DIC);
        self::initHTML();
        self::initLegalDocuments($DIC);
    }
}
