<?php
namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;
#[OA\Parameter(
    parameter: "RefIDParamater",
    name: "ref_id",
    description: "Reference ID of ILIAS Object",
    in: "path",
    required: false,
    schema: new OA\Schema(
        type: "integer",
        example: 122
    )
)]
final class RefIDParamater {}