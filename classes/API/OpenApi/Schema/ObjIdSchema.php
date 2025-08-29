<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ObjIdSchema",
    description: "Object Identifier of ILIAS Object",
    type: "integer",
    format: "int64",
    example: 612
)]
final class ObjIdSchema
{
}
