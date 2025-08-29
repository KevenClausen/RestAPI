<?php

namespace KPG\RestAPI\API\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'AttributesNotFoundResponse',
    description: "ATTRIBUTES NOT FOUND",
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(ref: "#/components/schemas/ResponseDefaultSchema"),
            new OA\Schema(
                properties: [
                    new OA\Property(property: "error_code", type: "string", example: "ATTRIBUTES_NOT_FOUND")
                ]
            )
        ]
    )
)]
final class AttributesNotFoundResponse
{
}
