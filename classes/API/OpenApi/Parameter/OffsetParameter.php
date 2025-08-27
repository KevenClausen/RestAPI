<?php
namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;
#[OA\Parameter(
    parameter: "OffsetParameter",
    name: "offset",
    description: "The starting index of the results for pagination.",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "integer")
)]
final class OffsetParameter {}