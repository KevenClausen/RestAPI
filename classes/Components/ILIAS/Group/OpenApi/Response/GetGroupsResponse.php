<?php

namespace KPG\RestAPI\Components\ILIAS\Group\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'GetGroupsResponse',
    description: "OK",
    content: new OA\JsonContent(
        type: "object",
        allOf: [
            new OA\Schema(ref: "#/components/schemas/ResponseDefaultSchema"),
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: "response_data",
                        type: "array",
                        items: new OA\Items(ref: "#/components/schemas/GetGroupsResponseDataSchema"),
                        example: [
                            [
                                "ref_id" => 133,
                                "obj_id" => 612,
                                "title" => "Mathematics Semester 1",
                                "parent_id" => 1245,
                            ],
                            [
                                "ref_id" => 134,
                                "obj_id" => 613,
                                "title" => "Physics Semester 1",
                                "parent_id" => 1145,
                            ],
                            [
                                "ref_id" => 135,
                                "obj_id" => 614,
                                "title" => "Chemistry Semester 1",
                                "parent_id" => 1145,
                            ]
                        ]
                    )
                ],
                type: "object"
            )
        ]
    )
)]
final class GetGroupsResponse
{
}
