<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CreateDateSchema",
    description: "The creation date of the object in ISO 8601 format",
    type: "string",
    format: "date-time",
    example: "2025-08-13T14:35:00Z"
)]
final class CreateDateSchema
{
}
