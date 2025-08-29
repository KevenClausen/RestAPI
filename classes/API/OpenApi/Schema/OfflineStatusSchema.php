<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OfflineStatusSchema",
    description: "Indicates whether the object is offline or active",
    type: "boolean",
    example: false
)]
final class OfflineStatusSchema
{
}
