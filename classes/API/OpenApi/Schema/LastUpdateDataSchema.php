<?php
namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "LastUpdateDataSchema",
    description: "Last Update ILIAS object",
    type: "string",
    example: "2025-04-20 16:56:19"
)]
final class LastUpdateDataSchema {}