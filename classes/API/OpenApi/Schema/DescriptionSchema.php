<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "DescriptionSchema",
    description: "Short description of the ILIAS object",
    type: "string",
    example: "This Module contains all basic mathematics tests."
)]
final class DescriptionSchema
{
}
