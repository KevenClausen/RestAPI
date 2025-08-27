<?php
namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "ObjectTypeSchema",
    description: "The of ILIAS object",
    type: "string",
    example: "crs"
)]
final class ObjectTypeSchema {}