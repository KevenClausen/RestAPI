<?php
namespace KPG\RestAPI\ILIAS\Test\classes;

use KPG\RestAPI\ILIAS\Test\TestUtilHandler;
use KPG\RestAPI\API\Exception\TestNotFoundException;
use ilTestParticipantList;
use ilObjUser;

class TestParticipants {

    private $DIC;
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new TestUtilHandler();
    }

    public function getParticipants(int $test_ref_id) : array
    {
        if (!$this->utilHandler->testExists($test_ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($test_ref_id, true);

        $participant_list = $obj_test->getActiveParticipantList();
        $participants = [];

        foreach ($participant_list as $participant) {
            $participants[] = [
                'active_id' => $participant->getActiveId(),
                'usr_id' => $participant->getUsrId(),
                'anonymous_id' => $participant->getAnonymousId(),
                'login' => $participant->getLogin(),
                'firstname' => $participant->getFirstname(),
                'lastname' => $participant->getLastname(),
                'matriculation' => $participant->getMatriculation(),
                'finished' => $participant->isTestFinished(),
                'finished_tries' => $participant->getFinishedTries(),
                'unfinished' => $participant->hasUnfinishedPasses(),
            ];
        }
        return $participants;
    }
}