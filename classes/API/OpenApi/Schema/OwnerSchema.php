<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OwnerSchema",
    description: "The ID of the user who owns the ILIAS object",
    type: "integer",
    format: "int64",
    example: 45
)]
final class OwnerSchema
{
}
