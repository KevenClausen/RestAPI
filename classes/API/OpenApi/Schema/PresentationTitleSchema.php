<?php
namespace KPG\RestAPI\API\OpenApi\Schema;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "PresentationTitleSchema",
    description: "The presentation title of the object",
    type: "string",
    example: "Mathematics – Introduction"
)]
final class PresentationTitleSchema
{
}