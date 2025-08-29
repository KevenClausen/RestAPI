<?php

namespace KPG\RestAPI\ILIAS\Test;

use KPG\RestAPI\API\Exception\TestNotFoundException;
use KPG\RestAPI\API\Exception\AttributesNotFoundException;

class TestGradingSystemSettingHandler
{
    private $DIC;
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new TestUtilHandler();
    }

    public function getAllGrading(int $ref_id): array
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $marks = [];

        foreach ($obj_test->getMarkSchema()->getMarkSteps() as $mark) {
            $marks[] = [
                'short_name' => $mark->getShortName(),
                'official_name' => $mark->getOfficialName(),
                'minimum_level' => $mark->getMinimumLevel(),
                'passed' => (bool) $mark->getPassed(),
            ];
        }
        return $marks;
    }

    public function addGrading(int $ref_id, array $new_grading): void
    {
        if (!array_key_exists('short_name', $new_grading)) {
            throw new AttributesNotFoundException(["missing_argument" => 'short_name']);
        }
        if (!array_key_exists('official_name', $new_grading)) {
            throw new AttributesNotFoundException(["missing_argument" => 'official_name']);
        }
        if (!array_key_exists('minimum_level', $new_grading)) {
            throw new AttributesNotFoundException(["missing_argument" => 'minimum_level']);
        }
        if (!array_key_exists('passed', $new_grading)) {
            throw new AttributesNotFoundException(["missing_argument" => 'passed']);
        }
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $obj_mark = $obj_test->getMarkSchema();
        $obj_mark->addMarkStep($new_grading['short_name'], $new_grading['official_name'], $new_grading['minimum_level'], $new_grading['passed']);
        $obj_mark->saveToDb($obj_test->getTestId());
    }

    public function deleteGrading(int $ref_id, string $short_name): void
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $obj_mark = $obj_test->getMarkSchema();
        foreach ($obj_test->getMarkSchema()->getMarkSteps() as $index => $mark) {
            if ($mark->getShortName() == $short_name) {
                $obj_mark->deleteMarkStep($index);
                $obj_mark->saveToDb($obj_test->getTestId());
                return;
            }
        }
        throw new AttributesNotFoundException(["missing_argument" => 'short_name']);
    }
    public function patchGrading(int $ref_id, array $update_data): void
    {
        if (!array_key_exists('short_name', $update_data)) {
            throw new AttributesNotFoundException(["missing_argument" => 'short_name']);
        }
        if (!array_key_exists('official_name', $update_data)) {
            throw new AttributesNotFoundException(["missing_argument" => 'official_name']);
        }
        if (!array_key_exists('minimum_level', $update_data)) {
            throw new AttributesNotFoundException(["missing_argument" => 'minimum_level']);
        }
        if (!array_key_exists('passed', $update_data)) {
            throw new AttributesNotFoundException(["missing_argument" => 'passed']);
        }

        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }

        $obj_test = new \ilObjTest($ref_id, true);
        $obj_mark = $obj_test->getMarkSchema();
        foreach ($obj_test->getMarkSchema()->getMarkSteps() as $index => $mark) {
            if ($mark->getShortName() == $update_data['short_name'] or $mark->getOfficialName() == $update_data['official_name'] or $mark->getMinimumLevel() == $update_data['minimum_level']) {
                $mark->setPassed((int) $update_data['passed']);
                $mark->setOfficialName($update_data['official_name']);
                $mark->setShortName($update_data['short_name']);
                $mark->setMinimumLevel($update_data['minimum_level']);
                $obj_mark->saveToDb($obj_test->getTestId());
                return;
            }
        }
        throw new AttributesNotFoundException(["missing_argument" => 'short_name']);
    }

    public function resetGrading(int $ref_id): void
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $obj_mark = $obj_test->getMarkSchema();
        $obj_mark->createSimpleSchema();
        $obj_mark->saveToDb($obj_test->getTestId());
    }

}
