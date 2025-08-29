<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ImportIdSchema",
    description: "Import Identifier of ILIAS Object",
    type: "integer",
    format: "int64",
    example: 133
)]
final class ImportIdSchema
{
}
