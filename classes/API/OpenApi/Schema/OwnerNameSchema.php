<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OwnerNameSchema",
    description: "The name of the user who owns the ILIAS object",
    type: "string",
    example: "John Doe"
)]
final class OwnerNameSchema
{
}
