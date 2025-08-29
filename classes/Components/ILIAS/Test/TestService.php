<?php

namespace KPG\RestAPI\Components\ILIAS\Test;

use KPG\RestAPI\API\BaseService;
use OpenApi\Attributes as OA;
use KPG\RestAPI\API\HTTP\Response;
use KPG\RestAPI\ILIAS\Test\TestHandler;
use KPG\RestAPI\ILIAS\Test\TestMainSettingHandler;
use KPG\RestAPI\ILIAS\Test\TestGradingSystemSettingHandler;
use KPG\RestAPI\ILIAS\Test\classes\TestParticipants;
use KPG\RestAPI\ILIAS\Test\classes\TestResultHandler;

#[OA\PathItem(
    path: "/ilias/test",
)]

#[OA\Tag(
    name: "Test",
    description: "&nbsp;&nbsp;<b>Sponsor:</b> Heinrich Heine Universität<br />
                  &nbsp;&nbsp;<b>Author:</b> Keven Clausen, Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>E-Mail:</b> info@kroepelin-projekte.de<br />
                  &nbsp;&nbsp;<b>Version:</b> 1.0.0",
)]
class TestService extends BaseService
{
    public function __construct(array $request_data, Response $response)
    {
        parent::__construct($request_data, $response);
    }

    #[OA\GET(
        path: '/ilias/test',
        operationId: "getAllTests",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAllTests(): void
    {
        $handler = new TestHandler();
        $this->response->setResponseData($handler->getTest());
        $this->response->setResponseCode(200);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/test/{ref_id}',
        operationId: "getTestById",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getTestById(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData((new TestHandler())->getTest($this->path_params->getValueByKey('ref_id')));
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/test/{ref_id}/info',
        operationId: "getTestInfoById",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getTestInfoById(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData((new TestHandler())->getTestInfo($this->path_params->getValueByKey('ref_id')));
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/test/{ref_id}/settings/general',
        operationId: "getTestSettingsGeneralById",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getTestSettingsGeneralById(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData((new TestMainSettingHandler())->getTestSettingsGeneral($this->path_params->getValueByKey('ref_id')));
        $this->response->send();
    }

    #[OA\PATCH(
        path: '/ilias/test/{ref_id}/settings/general',
        operationId: "updateTestSettingsGeneralById",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function updateTestSettingsGeneralById(): void
    {
        $this->response->setResponseCode(200);
        $update_data = $this->request_body->getAllData();
        $ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new TestMainSettingHandler();
        $handler->updateTestSettingsGeneral($ref_id, $update_data);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\GET(
        path: '/ilias/test/{ref_id}/settings/grading-system',
        operationId: "getAllGradingByRefid",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAllGradingByRefid(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData((new TestGradingSystemSettingHandler())->getAllGrading($this->path_params->getValueByKey('ref_id')));
        $this->response->send();
    }

    #[OA\POST(
        path: '/ilias/test/{ref_id}/settings/grading-system',
        operationId: "addGrading",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function addGrading(): void
    {
        $this->response->setResponseCode(200);
        $new_grading = $this->request_body->getAllData();
        $ref_id = $this->path_params->getValueByKey('ref_id');
        (new TestGradingSystemSettingHandler())->addGrading($ref_id, $new_grading);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\DELETE(
        path: '/ilias/test/{ref_id}/settings/grading-system/{short_name}',
        operationId: "deleteGrading",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function deleteGrading(): void
    {
        $this->response->setResponseCode(200);
        $short_name = $this->path_params->getValueByKey('short_name');
        $ref_id = $this->path_params->getValueByKey('ref_id');
        (new TestGradingSystemSettingHandler())->deleteGrading($ref_id, $short_name);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\PATCH(
        path: '/ilias/test/{ref_id}/settings/grading-system',
        operationId: "patchGrading",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function patchGrading(): void
    {
        $this->response->setResponseCode(200);
        $update_grading = $this->request_body->getAllData();
        $ref_id = $this->path_params->getValueByKey('ref_id');
        (new TestGradingSystemSettingHandler())->patchGrading($ref_id, $update_grading);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\PATCH(
        path: '/ilias/test/{ref_id}/settings/grading-system/reset',
        operationId: "resetGrading",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function resetGrading(): void
    {
        $ref_id = $this->path_params->getValueByKey('ref_id');
        (new TestGradingSystemSettingHandler())->resetGrading($ref_id);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\GET(
        path: '/ilias/test/{ref_id}/participants',
        operationId: "getParticipants",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getParticipants(): void
    {
        $ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new TestParticipants();
        $participants = $handler->getParticipants($ref_id);
        $this->response->setResponseCode(200);
        $this->response->setResponseData($participants);
        $this->response->send();
    }
    #[OA\GET(
        path: '/ilias/test/{ref_id}/results',
        operationId: "getResults",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getResults(): void
    {
        $ref_id = (int) $this->path_params->getValueByKey('ref_id');
        $handler = new TestResultHandler();
        $participants = $handler->getResultsByRefId($ref_id);
        $this->response->setResponseCode(200);
        $this->response->setResponseData($participants);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/test/{ref_id}/results/{user_id}',
        operationId: "getResultsByUser",
        description: 'Description',
        summary: 'Description',
        tags: ["Test"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getResultsByUser(): void
    {
        $ref_id = (int) $this->path_params->getValueByKey('ref_id');
        $user_id = (int) $this->path_params->getValueByKey('user_id');
        $handler = new TestResultHandler();
        $participant = $handler->getResultsByRefIdAndUserID($ref_id, $user_id);
        $this->response->setResponseCode(200);
        $this->response->setResponseData($participant);
        $this->response->send();
    }

}
