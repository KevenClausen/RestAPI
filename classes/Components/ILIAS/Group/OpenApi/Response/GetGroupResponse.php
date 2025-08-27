<?php
namespace KPG\RestAPI\Components\ILIAS\Group\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'GetGroupResponse',
    description: "OK",
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(ref: "#/components/schemas/ResponseDefaultSchema"),
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: "response_data",
                        allOf: [
                            new OA\Schema(ref: "#/components/schemas/GetGroupResponseDataSchema")
                        ]
                    )
                ]
            )
        ]
    )
)]
final class GetGroupResponse {}