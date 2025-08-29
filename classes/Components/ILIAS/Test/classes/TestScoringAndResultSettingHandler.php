<?php

namespace KPG\RestAPI\ILIAS\Test;

class TestScoringAndResultSettingHandler
{
    private $DIC;
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new TestUtilHandler();
    }

}
