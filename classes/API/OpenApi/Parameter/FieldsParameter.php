<?php
namespace KPG\RestAPI\API\OpenApi\Parameter;

use OpenApi\Attributes as OA;
#[OA\Parameter(
    parameter: "FieldsParameter",
    name: "fields",
    description: "Comma-separated list of keys. Only the specified keys will be included in the response. Example: `name,description,date`.",
    in: "query",
    required: false,
    schema: new OA\Schema(type: "string", example: "name,description,date")
)]
final class FieldsParameter {}