<?php

namespace KPG\RestAPI\Components\ILIAS\Course\OpenApi\Response;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'GetCourseResponse',
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
                        items: new OA\Items(ref: "#/components/schemas/GetCourseResponseDataSchema"),
                        example: [
                            [
                                "ref_id" => 133,
                                "obj_id" => 612,
                                "title" => "Mathematics Semester 1",
                                "presentation_title" => "Math Sem 1",
                                "description" => "Basic math category",
                                "long_description" => "Detailed description for Mathematics Semester 1",
                                "offlineStatus" => false,
                                "owner" => 134,
                                "creation_date" => "2025-08-15T12:00:00Z"
                            ],
                            [
                                "ref_id" => 134,
                                "obj_id" => 613,
                                "title" => "Physics Semester 1",
                                "presentation_title" => "Physics Sem 1",
                                "description" => "Basic physics category",
                                "long_description" => "Detailed description for Physics Semester 1",
                                "offlineStatus" => true,
                                "owner" => 135,
                                "creation_date" => "2025-08-10T12:00:00Z"
                            ],
                            [
                                "ref_id" => 135,
                                "obj_id" => 614,
                                "title" => "Chemistry Semester 1",
                                "presentation_title" => "Chem Sem 1",
                                "description" => "Basic chemistry category",
                                "long_description" => "Detailed description for Chemistry Semester 1",
                                "offlineStatus" => false,
                                "owner" => 155,
                                "creation_date" => "2025-08-12T12:00:00Z"
                            ]
                        ]
                    )
                ],
                type: "object"
            )
        ]
    )
)]
final class GetCourseResponse
{
}
