<?php

namespace KPG\RestAPI\API\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'RequierdFieldsNotFoundResponse',
    description: "USER REQUIERD FIELD NOT FOUND",
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(ref: "#/components/schemas/ResponseDefaultSchema"),
            new OA\Schema(
                properties: [
                    new OA\Property(property: "error_code", type: "string", example: "USER_REQUIERD_FIELD_NOT_FOUND")
                ]
            )
        ]
    )
)]
final class RequierdFieldsNotFoundResponse
{
}
