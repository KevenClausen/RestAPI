<?php

namespace KPG\RestAPI\Components\ILIAS\Repository;

use KPG\RestAPI\API\BaseService;
use OpenApi\Attributes as OA;
use KPG\RestAPI\ILIAS\Repository\classes\RepositoryHandler;
use ilLPStatus;
use ilObject;
use KPG\RestAPI\ILIAS\Repository\classes\RepositoryAdvanceMetaDataHandler;
use KPG\RestAPI\ILIAS\Repository\classes\RepositoryLPHandler;

#[OA\PathItem(
    path: "/ilias/repository",
)]

#[OA\Tag(
    name: "Repository",
    description: "&nbsp;&nbsp;<b>Sponsor:</b> Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>Author:</b> Keven Clausen, Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>E-Mail:</b> info@kroepelin-projekte.de<br />
                  &nbsp;&nbsp;<b>Version:</b> 1.0.0",
)]
class RepositoryService extends BaseService
{
    #[OA\Get(
        path: '/ilias/repository/{ref_id}',
        operationId: "objectInformation",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function objectInformation(): void
    {
        $object_ref_id = $this->path_params->getValueByKey('ref_id');
        $handler = new RepositoryHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData($handler->getObjectInformations($object_ref_id));
        $this->response->send();
    }

    #[OA\Get(
        path: '/ilias/repository/{ref_id}/exists',
        operationId: "objectExists",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function objectExists(): void
    {
        $handler = new RepositoryHandler();

        if ($handler->objectExist($this->path_params->getValueByKey('ref_id'))) {
            $this->response->setResponseCode(200);
        } else {
            $this->response->setResponseCode(404);
        }
        $this->response->send();
    }

    #[OA\Get(
        path: '/ilias/repository/{ref_id}/type',
        operationId: "getObjectType",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getObjectType(): void
    {
        $handler = new RepositoryHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData(
            ["type" => $handler->getObjectType($object_ref_id = $this->path_params->getValueByKey('ref_id'))]
        );
        $this->response->send();
    }

    # ToDo ab hier
    #[OA\Delete(
        path: '/ilias/repository/{ref_id}',
        operationId: "deleteObject",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function deleteObject(): void
    {
        $handler = new RepositoryHandler();
        $handler->deleteObject($this->path_params->getValueByKey('ref_id'));
        $this->response->setResponseCode(201);
        $this->response->send();
    }

    #[OA\Get(
        path: '/ilias/repository/{ref_id}/parent',
        operationId: "getParent",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getParent(): void
    {
        $handler = new RepositoryHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData(["parent" => $handler->getParent($this->path_params->getValueByKey('ref_id'))]
        );
        $this->response->send();
    }

    #[OA\Get(
        path: '/ilias/repository/{ref_id}/childrens',
        operationId: "getChildren",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getChildren(): void
    {
        $handler = new RepositoryHandler();
        $this->response->setResponseCode(200);
        $this->response->setResponseData(
            ["childrens" => $handler->getChildrens($this->path_params->getValueByKey('ref_id'))]
        );
        $this->response->send();
    }


    #[OA\PUT(
        path: '/ilias/repository/{ref_id}/copy/{target_ref_id}',
        operationId: "copyObject",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function copyObject(): void
    {
        $obj_ref_id = $this->path_params->getValueByKey('ref_id');
        $obj_target_ref_id = $this->path_params->getValueByKey('target_ref_id');
        $object = new \ilObject();
        $object->setRefId($obj_ref_id);
        $object->setType(\ilObject::_lookupType($obj_ref_id, true));
        $object->read();
        $object->cloneObject($obj_target_ref_id);

        $this->response->setResponseCode(201);
        $this->response->send();
    }


    #[OA\GET(
        path: '/ilias/repository/{ref_id}/advancedmetadata',
        operationId: "getAdvancedMetaData",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getAdvancedMetaData(): void
    {
        $ref_id = (int) $this->path_params->getValueByKey('ref_id');
        $meta_data_handler = new RepositoryAdvanceMetaDataHandler();
        $this->response->setResponseData($meta_data_handler->getAdvanceMetaDataByRefID($ref_id));
        $this->response->setResponseCode(200);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/repository/{ref_id}/learninghistory/users',
        operationId: "getLearningHistoryUsers",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getLearningHistoryUsers(): void
    {
        $obj_ref_id = $this->path_params->getValueByKey('ref_id');
        $lp_handler = new RepositoryLPHandler();
        $this->response->setResponseData($lp_handler->getLPByRefID((int) $obj_ref_id));
        $this->response->setResponseCode(200);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/repository/{ref_id}/learninghistory/users/{user_id}',
        operationId: "getLearningHistoryByUserID",
        description: 'Description',
        summary: 'Description',
        tags: ["Repository"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Erfolgreiche Antwort'
            )
        ]
    )]
    public function getLearningHistoryByUserID(): void
    {
        $obj_ref_id = (int) $this->path_params->getValueByKey('ref_id');
        $user_id = (int) $this->path_params->getValueByKey('user_id');

        $lp_handler = new RepositoryLPHandler();

        $this->response->setResponseData(['status' => $lp_handler->getLPByRefIDAndUserID($obj_ref_id, $user_id)]);
        $this->response->setResponseCode(200);
        $this->response->send();
    }
}