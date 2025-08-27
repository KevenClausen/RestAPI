<?php
namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "RoleNameSchema",
    description: "The Role name",
    type: "string",
    example: "Guest"
)]
final class RoleNameSchema {}