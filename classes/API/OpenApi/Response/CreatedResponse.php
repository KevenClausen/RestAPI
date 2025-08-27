<?php
namespace KPG\RestAPI\API\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'CreatedResponse',
    description: "CREATED",
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(ref: "#/components/schemas/ResponseDefaultSchema"),

        ]
    )
)]
final class CreatedResponse {}