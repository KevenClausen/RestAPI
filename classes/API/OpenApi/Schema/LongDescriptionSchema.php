<?php
namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "LongDescriptionSchema",
    description: "Detailed description of the ILIAS object",
    type: "string",
    example: "This Module provides comprehensive resources and assessments for mathematics beginners."
)]
final class LongDescriptionSchema {}