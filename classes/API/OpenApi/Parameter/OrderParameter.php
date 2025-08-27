<?php
namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;
#[OA\Parameter(
    parameter: "OrderParameter",
    name: "order",
    description: "The sorting structure for results in the format field:direction (e.g., 'title:asc' or 'title:desc'). Direction can be omitted, default is 'asc'.",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "string", example: "title:asc")
)]
final class OrderParameter {}