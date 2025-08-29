<?php

namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: "LimitParameter",
    name: "limit",
    description: "The maximum number of results to return.",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "integer")
)]
final class LimitParameter
{
}
