<?php

namespace KPG\RestAPI\ILIAS\Test;

use KPG\RestAPI\API\Exception\TestNotFoundException;
use ilObject;
use ilObjTestSettingsResultSummary;
use ilDatePresentation;
use DateTimeImmutable;

class TestHandler
{
    private $DIC;
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new TestUtilHandler();
    }

    public function getTest(int $test_ref_id = null): array
    {
        if ($test_ref_id == null) {
            $ref_ids = [];
            foreach (\ilObject::_getObjectsByType('tst') as $obj_test) {
                foreach (\ilObjCourse::_getAllReferences($obj_test['obj_id']) as $ref_id) {
                    if (\ilObject::_isInTrash($ref_id)) {
                        continue;
                    }
                    $ref_ids[] = $ref_id;
                }
            }
            $tests = [];
            foreach ($ref_ids as $ref_id) {
                $tests[] = [
                    'ref_id' => $ref_id,
                    'obj_id' => \ilObjTest::_lookupObjId($ref_id),
                    'title' => \ilObjTest::_lookupTitle(\ilObjTest::_lookupObjId($ref_id)),
                    'parent_id' => $this->DIC->repositoryTree()->getParentId($ref_id)
                ];
            }
            return $tests;
        } else {
            if (!$this->utilHandler->testExists($test_ref_id)) {
                throw new TestNotFoundException();
            }
            $obj_test = new \ilObjTest($test_ref_id, true);
            $test_information = [
                'ref_id' => $test_ref_id,
                'obj_id' => \ilObjTest::_lookupObjId($test_ref_id),
                'test_id' => $obj_test->getTestId(),
                'title' => $obj_test->getPresentationTitle(),
                'description' => $obj_test->getDescription(),
                'long_description' => $obj_test->getLongDescription(),
                'offline_status' => $obj_test->getOfflineStatus(),
                'owner' => $obj_test->getOwner(),
                'create_date' => $obj_test->getCreateDate(),
                'last_update' => $obj_test->getLastUpdateDate(),
                'introduction' => $obj_test->getIntroduction(),
                'final_statement' => $obj_test->getFinalStatement(),
                'starting_time' => $obj_test->getStartingTime(),
                'ending_time' => $obj_test->getEndingTime(),
                'activation_starting_time' => $obj_test->getActivationStartingTime(),
                'activation_ending_time' => $obj_test->getActivationEndingTime(),
                'password' => $obj_test->getPassword(),
            ];
        }
        return $test_information;
    }

    public function getTestInfo(int $test_ref_id): array
    {
        if (!$this->utilHandler->testExists($test_ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($test_ref_id, true);
        $test_info = [];

        $general_settings = [
            'author' => $obj_test->getAuthor(),
            'title' => $obj_test->getPresentationTitle(),
        ];
        $test_info['general_settings'] = $general_settings;
        if ($obj_test->getMainSettings()->getParticipantFunctionalitySettings()->getPostponedQuestionsMoveToEnd()) {
            $test_info['sequence_properties']['sequence'] = 'postpone';
        } else {
            $test_info['sequence_properties']['sequence'] = 'fixed';
        }

        if ($obj_test->getCountSystem() == COUNT_PARTIAL_SOLUTIONS) {
            $test_info['socring']['scoring_system'] = "partial_solutions";
        } else {
            $test_info['socring']['scoring_system'] = "correct_solutions";
        }
        if ($obj_test->getPassScoring() == SCORE_BEST_PASS) {
            $test_info['socring']['pass_scoring'] = 'best_pass';
        } else {
            $test_info['socring']['pass_scoring'] = 'last_pass';
        }

        switch ($obj_test->getScoreReporting()) {
            case ilObjTestSettingsResultSummary::SCORE_REPORTING_FINISHED:
                $test_info['score_reporting']['score_reporting'] = "tst_report_after_test";
                break;
            case ilObjTestSettingsResultSummary::SCORE_REPORTING_IMMIDIATLY:
                $test_info['score_reporting']['score_reporting'] = "tst_report_after_first_question";
                break;
            case ilObjTestSettingsResultSummary::SCORE_REPORTING_DATE:
                $test_info['score_reporting']['score_reporting'] = "tst_report_after_date";
                break;
            case ilObjTestSettingsResultSummary::SCORE_REPORTING_AFTER_PASSED:
                $test_info['score_reporting']['score_reporting'] = "tst_report_after_passed";
                break;
            default:
                $test_info['score_reporting']['score_reporting'] = "tst_report_never";
                break;
        }

        $reporting_date = $obj_test->getScoreSettings()->getResultSummarySettings()->getReportingDate();

        if ($reporting_date !== null) {
            $test_info['score_reporting']['reporting_date'] = $reporting_date;
        }
        if ($obj_test->getNrOfTries() === 0) {
            $test_info['session_settings']['nr_of_tries'] = 'unlimited';
        } else {
            $test_info['session_settings']['nr_of_tries'] = $obj_test->getNrOfTries();
        }
        if ($obj_test->getEnableProcessingTime()) {
            $test_info['session_settings']['processing_time'] = $obj_test->getEnableProcessingTime();
        }

        $starting_time = $obj_test->getStartingTime();
        if ($obj_test->isStartingTimeEnabled() && $starting_time !== 0) {
            $test_info['session_settings']['starting_time'] = $starting_time;
        }

        $ending_time = $obj_test->getEndingTime();;
        if ($obj_test->isEndingTimeEnabled() && $ending_time !== 0) {
            $test_info['session_settings']['ending_time'] = $ending_time;
        }
        return $test_info;
    }

    public function getTestIntroduction(int $test_ref_id): string
    {
        if (!$this->utilHandler->testExists($test_ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($test_ref_id, true);
        return  $obj_test->getIntroduction();
    }

}