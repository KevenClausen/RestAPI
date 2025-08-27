<?php

namespace KPG\RestAPI\ILIAS\Test;

use KPG\RestAPI\API\Exception\TestNotFoundException;

class TestMainSettingHandler {

    private $DIC;
    private TestUtilHandler $utilHandler;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->utilHandler = new TestUtilHandler();
    }

    public function getTestSettingsGeneral(int $ref_id): array
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $return_array = [];
        $main_settings = $obj_test->getMainSettings();
        $return_array['general_settings']['title'] = $obj_test->getPresentationTitle();
        $return_array['general_settings']['description'] = $obj_test->getDescription();
        $return_array['general_settings']['question_set_type'] = $main_settings->getGeneralSettings(
        )->getQuestionSetType();
        $return_array['general_settings']['anonymity'] = $main_settings->getGeneralSettings()->getAnonymity();

        $ava = $obj_test->getActivationVisibility();

        $return_array['availability']['online'] = !$obj_test->getOfflineStatus();
        $return_array['availability']['activation_visibility'] = $obj_test->getActivationVisibility();
        $return_array['availability']['time_span']['activation_starting_time'] = (string) $obj_test->getActivationStartingTime(
        );

        $return_array['availability']['time_span']['activation_ending_time'] = (string) $obj_test->getActivationEndingTime(
        );

        $return_array['presentation']['tile_image'] = $obj_test->getImagePathWeb();

        $return_array['introduction']['intro_enabled'] = $main_settings->getIntroductionSettings(
        )->getIntroductionEnabled();
        $return_array['introduction']['conditions_checkbox_enabled'] = $main_settings->getIntroductionSettings(
        )->getExamConditionsCheckboxEnabled();

        $return_array['access']['starting_time_enabled'] = $main_settings->getAccessSettings()->getStartTimeEnabled();
        $return_array['access']['starting_time'] = $main_settings->getAccessSettings()->getStartTime(
        ) != null ? $main_settings->getAccessSettings()->getStartTime()->getTimestamp() : 0;

        $return_array['access']['ending_time_enabled'] = $main_settings->getAccessSettings()->getEndTimeEnabled();
        $return_array['access']['ending_time'] = $main_settings->getAccessSettings()->getEndTime(
        ) != null ? $main_settings->getAccessSettings()->getEndTime()->getTimestamp() : 0;

        $return_array['access']['password_enabled'] = $main_settings->getAccessSettings()->getPasswordEnabled();
        $return_array['access']['password'] = $main_settings->getAccessSettings()->getPassword();

        $return_array['access']['fixed_participants'] = $main_settings->getAccessSettings()->getFixedParticipants();

        $test_run_settings = $main_settings->getTestBehaviourSettings();

        $return_array['test_run']['limit_nr_test_attempts']['number_of_tries'] = $test_run_settings->getNumberOfTries();
        $return_array['test_run']['limit_nr_test_attempts']['block_after_passed_enabled'] = $test_run_settings->getBlockAfterPassedEnabled(
        );
        $array_pass_wating = explode(':', $test_run_settings->getPassWaiting());
        $return_array['test_run']['pass_waiting']['days'] = $array_pass_wating[0];
        $return_array['test_run']['pass_waiting']['hours'] = $array_pass_wating[1];
        $return_array['test_run']['pass_waiting']['minutes'] = $array_pass_wating[2];

        $return_array['test_run']['limit_duration_of_test']['processing_time_enabled'] = $test_run_settings->getProcessingTimeEnabled(
        );
        $return_array['test_run']['limit_duration_of_test']['processing_time'] = $test_run_settings->getProcessingTime(
        );
        $return_array['test_run']['limit_duration_of_test']['resetprocessing_time'] = $test_run_settings->getResetProcessingTime(
        );;

        $return_array['test_run']['exam_view']['kiosk_mode_enabled'] = $test_run_settings->getKioskModeEnabled();
        $return_array['test_run']['exam_view']['title_in_kiosk_mode_enabled'] = $test_run_settings->getShowTitleInKioskMode(
        );
        $return_array['test_run']['exam_view']['participant_name_in_kiosk_mode_enabled'] = $test_run_settings->getShowParticipantNameInKioskMode(
        );

        $behavior_of_the_questions = $main_settings->getQuestionBehaviourSettings();

        $return_array['behavior_of_the_question']['title_output_mode'] = $behavior_of_the_questions->getQuestionTitleOutputMode(
        );
        $return_array['behavior_of_the_question']['automatic_saving']['enabled'] = $behavior_of_the_questions->getAutosaveEnabled(
        );
        $return_array['behavior_of_the_question']['automatic_saving']['interval'] = $behavior_of_the_questions->getAutosaveInterval(
        );
        $return_array['behavior_of_the_question']['shuffle_questions'] = $behavior_of_the_questions->getShuffleQuestions(
        );
        $return_array['behavior_of_the_question']['hints'] = $behavior_of_the_questions->getQuestionHintsEnabled();
        $return_array['behavior_of_the_question']['instant_feedback']['feeback_points'] = $behavior_of_the_questions->getInstantFeedbackPointsEnabled(
        );
        $return_array['behavior_of_the_question']['instant_feedback']['feeback_generic'] = $behavior_of_the_questions->getInstantFeedbackGenericEnabled(
        );
        $return_array['behavior_of_the_question']['instant_feedback']['feeback_specific'] = $behavior_of_the_questions->getInstantFeedbackSpecificEnabled(
        );
        $return_array['behavior_of_the_question']['instant_feedback']['feeback_solution'] = $behavior_of_the_questions->getInstantFeedbackSolutionEnabled(
        );

        if (!$behavior_of_the_questions->getForceInstantFeedbackOnNextQuestion() &&
            !$behavior_of_the_questions->getLockAnswerOnNextQuestionEnabled() &&
            !$behavior_of_the_questions->getLockAnswerOnInstantFeedbackEnabled()
        ) {
            $return_array['behavior_of_the_question']['answer_lock']['not_lock_answer'] = true;
        } else {
            $return_array['behavior_of_the_question']['answer_lock']['not_lock_answer'] = false;
        }
        $return_array['behavior_of_the_question']['answer_lock']['force_instant_feedback_on_next_question'] = $behavior_of_the_questions->getForceInstantFeedbackOnNextQuestion(
        );
        $return_array['behavior_of_the_question']['answer_lock']['lock_answer_on_next_question'] = $behavior_of_the_questions->getLockAnswerOnNextQuestionEnabled(
        );
        $return_array['behavior_of_the_question']['answer_lock']['lock_answer_on_instant_feedback'] = $behavior_of_the_questions->getLockAnswerOnInstantFeedbackEnabled(
        );

        $return_array['behavior_of_the_question']['compulsory_questions'] = $behavior_of_the_questions->getCompulsoryQuestionsEnabled(
        );

        $participation_functionality = $main_settings->getParticipantFunctionalitySettings();

        $return_array['participation_functionality']['use_previous_answers'] = $participation_functionality->getUsePreviousAnswerAllowed(
        );
        $return_array['participation_functionality']['suspend_test_allowed'] = $participation_functionality->getSuspendTestAllowed(
        );
        $return_array['participation_functionality']['postponed_questions_move_to_end'] = $participation_functionality->getPostponedQuestionsMoveToEnd(
        );
        // ToDo überarbeitung des modes
        $return_array['participation_functionality']['usr_pass_overview_mode'] = $participation_functionality->getUsrPassOverviewMode(
        );
        $return_array['participation_functionality']['show_marker'] = $participation_functionality->getQuestionMarkingEnabled(
        );
        $return_array['participation_functionality']['show_questionlist'] = $participation_functionality->getQuestionListEnabled(
        );

        $finish_test = $main_settings->getFinishingSettings();

        $return_array['finish_test']['enable_examview'] = $finish_test->getShowAnswerOverview();
        $return_array['finish_test']['show_final_statement'] = $finish_test->getConcludingRemarksEnabled();
        $return_array['finish_test']['redirection_mode'] = $finish_test->getRedirectionMode();
        // ToDo überarbeitung des modes
        $return_array['finish_test']['redirection_url'] = $finish_test->getRedirectionUrl();
        $return_array['finish_test']['mailnotification'] = $finish_test->getMailNotificationContentType();
        $return_array['finish_test']['mailnottype'] = $finish_test->getAlwaysSendMailNotification();

        $additional_settings = $main_settings->getAdditionalSettings();
        $return_array['additional_features']['skill_service'] = $additional_settings->getSkillsServiceEnabled();
        $return_array['additional_features']['hide_info_tab'] = $additional_settings->getHideInfoTab();

        return $return_array;
    }

    public function updateTestSettingsGeneral(int $ref_id, array $data): void
    {
        if (!$this->utilHandler->testExists($ref_id)) {
            throw new TestNotFoundException();
        }
        $obj_test = new \ilObjTest($ref_id, true);
        $main_settings = $obj_test->getMainSettings();
        //general Settings
        if (array_key_exists('general_settings', $data)) {
            if (array_key_exists('title', $data['general_settings'])) {
                $obj_test->setTitle($data['general_settings']['title']);
            }
            if (array_key_exists('description', $data['general_settings'])) {
                $obj_test->setDescription($data['general_settings']['description']);
            }
            if (array_key_exists('question_set_type', $data['general_settings'])) {
                $main_settings = $main_settings
                    ->withGeneralSettings(
                        $main_settings->getGeneralSettings()
                                      ->withQuestionSetType($data['general_settings']['question_set_type'])
                    );
            }
            if (array_key_exists('question_set_type', $data['general_settings'])) {
                $main_settings = $main_settings
                    ->withGeneralSettings(
                        $main_settings->getGeneralSettings()
                                      ->withAnonymity((bool) $data['general_settings']['anonymity'])
                    );
            }
            if (array_key_exists('availability', $data)) {
                if (array_key_exists('online', $data['availability'])) {
                    $obj_test->setOfflineStatus(!$data['availability']['online']);
                }
            }

            $obj_test->getMainSettingsRepository()->store($main_settings);
            $obj_test->saveToDb();
            $obj_test->update();
        }
    }
}