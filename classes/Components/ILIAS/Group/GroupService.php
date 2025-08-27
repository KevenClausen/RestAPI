<?php

namespace KPG\RestAPI\Components\ILIAS\Group;

use KPG\RestAPI\API\BaseService;
use OpenApi\Attributes as OA;
use KPG\RestAPI\API\HTTP\Response;
use KPG\RestAPI\ILIAS\Group\classes\GroupHandler;
use KPG\RestAPI\ILIAS\Group\classes\GroupUserHandler;

#[OA\PathItem(
    path: "/ilias/group",
)]

#[OA\Tag(
    name: "Group",
    description: "&nbsp;&nbsp;<b>Sponsor:</b> Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>Author:</b> Keven Clausen, Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>E-Mail:</b> info@kroepelin-projekte.de<br />
                  &nbsp;&nbsp;<b>Version:</b> 1.0.0",
)]
class GroupService extends BaseService
{
    public function __construct(array $request_data, Response $response)
    {
        parent::__construct($request_data, $response);
    }


    #[OA\Get(
        path: "/ilias/group",
        operationId: "getAllGroups",
        description: "Returns all Groups of the ILIAS instance",
        summary: "ILIAS Groups",
        tags: ["Group"],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/LimitParameter"),
            new OA\Parameter(ref: "#/components/parameters/OffsetParameter"),
            new OA\Parameter(ref: "#/components/parameters/SearchParameter"),
            new OA\Parameter(ref: "#/components/parameters/FieldsParameter"),
            new OA\Parameter(ref: "#/components/parameters/FilterParameter"),
            new OA\Parameter(ref: "#/components/parameters/OrderParameter"),
        ],
        responses: [
            new OA\Response(ref: "#/components/responses/GetGroupsResponse", response: 200),
            new OA\Response(ref: "#/components/responses/InternalServerErrorResponse", response: 500),
            new OA\Response(ref: "#/components/responses/AuthFailedResponse", response: 401),
        ]
    )]
    public function getAllGroups(): void
    {
        $handler = new GroupHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData($handler->getGroup());
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}',
        operationId: "getGroupByRefID",
        description: 'Returns a Group of the ILIAS instance',
        summary: 'ILIAS Group',
        tags: ["Group"],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/RefIDParamater"),
            new OA\Parameter(ref: "#/components/parameters/FieldsParameter"),
        ],
        responses: [
            new OA\Response(ref: "#/components/responses/GetGroupResponse", response: 200),
            new OA\Response(ref: "#/components/responses/InternalServerErrorResponse", response: 500),
            new OA\Response(ref: "#/components/responses/AuthFailedResponse", response: 401),
            new OA\Response(ref: "#/components/responses/GroupNotFoundResponse", response: 404),
        ]
    )]
    public function getGroupByRefID(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData((new GroupHandler())->getGroup($this->path_params->getValueByKey('ref_id')));
        $this->response->send();
    }

    #[OA\Patch(
        path: '/ilias/group/{ref_id}',
        operationId: "updateGroupByRefId",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function updateGroupByRefId(): void
    {
        $handler = new GroupHandler();
        $handler->updateGroup($this->path_params->getValueByKey('ref_id'), $this->request_body->getAllData());
        $this->response->setResponseCode(201);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}/property/{property}',
        operationId: "getGroupInformation",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getGroupInformation(): void
    {
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $group_property = $this->path_params->getValueByKey('property');
        $handler = new GroupHandler();
        $property = $handler->getGroupInformation($group_ref_id, $group_property);
        $this->response->setResponseCode(200);
        $this->response->setResponseData([$property]);
        $this->response->send();
    }

    #[OA\Put(
        path: '/ilias/group/{ref_id}/users/{user_id}/{default_role}',
        operationId: "addUser",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function addUser(): void
    {
        $user_id = $this->path_params->getValueByKey('user_id');
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $group_default_role = $this->path_params->getValueByKey('default_role');
        $handler = new GroupUserHandler();
        $handler->addUser($user_id, $group_ref_id, $group_default_role);
        $this->response->setResponseCode(201);
        $this->response->send();
    }
    #[OA\DELETE(
        path: '/ilias/group/{ref_id}/users/{user_id}',
        operationId: "deleteUser",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function deleteUser(): void
    {
        $user_id = $this->path_params->getValueByKey('user_id');
        $group_ref_id = $this->path_params->getValueByKey('ref_id');

        $handler = new GroupUserHandler();
        $handler->deleteUser($user_id, $group_ref_id);
        $this->response->setResponseCode(201);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}/users',
        operationId: "getAllUsers",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAllUsers(): void
    {
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new GroupUserHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData($handler->getAllUsers($group_ref_id));
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}/admins',
        operationId: "getAllAdmins",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAllAdmins(): void
    {
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new GroupUserHandler();
        $this->response->setResponseData($handler->getAllUsers($group_ref_id, 'admin'));
        $this->response->setResponseCode(201);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}/members',
        operationId: "getAllMembers",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAllMembers(): void
    {
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new GroupUserHandler();
        $this->response->setResponseData($handler->getAllUsers($group_ref_id, 'member'));
        $this->response->setResponseCode(201);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/group/{ref_id}/roles',
        operationId: "getGroupRoles",
        description: 'Description',
        summary: 'Description',
        tags: ["Group"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getGroupRoles(): void
    {
        $group_ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new GroupHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData($handler->getGroupRoles($group_ref_id));
        $this->response->send();
    }
}