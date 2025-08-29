<?php

namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: "FilterParameter",
    name: "filter",
    description: "Advanced filtering with the format `filter[field.operator]=value`. Supported operators: `eq`, `neq`, `in`, `not`, `gt`, `lt`, `gte`, `lte`, `between`.",
    in: "query",
    required: false,
    schema: new OA\Schema(
        type: "string",
        example: "filter[status.eq]=active&filter[price.between]=10,20"
    )
)]
final class FilterParameter
{
}
