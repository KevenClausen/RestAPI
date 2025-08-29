<?php

namespace KPG\RestAPI\ILIAS\Test\classes;

use KPG\RestAPI\ILIAS\Test\TestUtilHandler;
use KPG\RestAPI\API\Exception\TestNotFoundException;
use ilObjUser;
use KPG\RestAPI\API\Exception\UserNotFoundException;

class TestResultHandler
{
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        $this->utilHandler = new TestUtilHandler();
    }

    public function getResultsByRefId(int $test_ref_id): array
    {
        if (!$this->utilHandler->testExists($test_ref_id)) {
            throw new TestNotFoundException();
        }
        $results = [];
        $obj_test = new \ilObjTest($test_ref_id, true);

        foreach ($obj_test->getParticipants() as $participant) {
            $user_id = ilObjUser::_lookupId($participant['login']);
            $result = $obj_test->getTestResult($obj_test->getActiveIdOfUser($user_id));
            $results[] = [
                'user_id' => $user_id,
                'login' => $participant['login'],
                'name' => $participant['name'],
                'full_name' => $participant['fullname'],
                'passed' => $result['test']['passed'],
                'total_points' => $result['pass']['total_reached_points'],
                'percent' => $result['pass']['percent'],
                'timestamp' => $result['test']['result_tstamp'],
            ];
        }
        return $results;
    }

    public function getResultsByRefIdAndUserID(int $ref_id, int $user_id): array
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        if (!ilObjUser::_exists($user_id)) {
            throw new UserNotFoundException();
        }
        $obj_user = new \ilObjUser($user_id);
        $obj_test = new \ilObjTest($ref_id, true);
        $result = $obj_test->getTestResult($obj_test->getActiveIdOfUser($user_id));
        $results[] = [
            'user_id' => $user_id,
            'login' => $obj_user->getLogin(),
            'name' => $obj_user->getPublicName(),
            'full_name' => $obj_user->getFullname(),
            'passed' => $result['test']['passed'],
            'total_points' => $result['pass']['total_reached_points'],
            'percent' => $result['pass']['percent'],
            'timestamp' => $result['test']['result_tstamp'],
        ];
        return $results;
    }
}
