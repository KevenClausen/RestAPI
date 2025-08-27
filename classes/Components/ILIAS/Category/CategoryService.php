<?php

namespace KPG\RestAPI\Components\ILIAS\Category;

use OpenApi\Attributes as OA;
use KPG\RestAPI\ILIAS\Category\classes\CategoryHandler;

#[OA\PathItem(
    path: "/kpg/category",
)]
#[OA\Tag(
    name: "Category",
    description: "&nbsp;&nbsp;<b>Sponsor:</b> Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>Author:</b> Keven Clausen, Kröpelin Projekt GmbH<br />
                  &nbsp;&nbsp;<b>E-Mail:</b> info@kroepelin-projekte.de<br />
                  &nbsp;&nbsp;<b>Version:</b> 0.0.1",
)]
class CategoryService extends \KPG\RestAPI\API\BaseService
{

    #[OA\Get(
        path: "/ilias/category",
        operationId: "getCategorys",
        description: "Returns all categories of the ILIAS instance",
        summary: "ILIAS Categorys",
        tags: ["Category"],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/LimitParameter"),
            new OA\Parameter(ref: "#/components/parameters/OffsetParameter"),
            new OA\Parameter(ref: "#/components/parameters/SearchParameter"),
            new OA\Parameter(ref: "#/components/parameters/FieldsParameter"),
            new OA\Parameter(ref: "#/components/parameters/FilterParameter"),
            new OA\Parameter(ref: "#/components/parameters/OrderParameter"),
        ],
        responses: [
            new OA\Response(ref: "#/components/responses/GetCategorysResponse", response: 200),
            new OA\Response(ref: "#/components/responses/InternalServerErrorResponse", response: 500),
            new OA\Response(ref: "#/components/responses/AuthFailedResponse", response: 401),
        ]
    )]
    public function getCategorys()
    {
        $handler = new CategoryHandler();
        $this->response->setResponseData($handler->getCategory());
        $this->response->setResponseCode(200);
        $this->response->send();
    }

    #[OA\GET(
        path: '/ilias/category/{ref_id}',
        operationId: "getCategoryById",
        description: 'Returns a Category of the ILIAS instance',
        summary: 'ILIAS Category',
        tags: ["Category"],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/RefIDParamater"),
            new OA\Parameter(ref: "#/components/parameters/FieldsParameter"),
        ],
        responses: [
            new OA\Response(ref: "#/components/responses/GetCategoryResponse", response: 200),
            new OA\Response(ref: "#/components/responses/CategoryNotFoundResponse", response: 404),
            new OA\Response(ref: "#/components/responses/InternalServerErrorResponse", response: 500),
            new OA\Response(ref: "#/components/responses/AuthFailedResponse", response: 401),
        ]
    )]
    public function getCategoryById(): void
    {
        $this->response->setResponseCode(200);
        $this->response->setResponseData(
            (new CategoryHandler())->getCategory($this->path_params->getValueByKey('ref_id'))
        );
        $this->response->send();
    }
}
