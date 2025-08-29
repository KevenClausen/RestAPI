<?php

namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: "SearchParameter",
    name: "search",
    description: "Search for results. Available formats: (1) `search=element` for substring matching across all records, or (2) `search[field]=element` to search within a specific field.",
    in: "query",
    required: false,
    schema: new OA\Schema(
        type: "string",
        example: "search[title]=example"
    )
)]
final class SearchParameter
{
}
