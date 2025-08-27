<?php
namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "TitleSchema",
    description: "The title of the ILIAS object",
    type: "string",
    example: "Mathematics Semester 1"
)]
final class TitleSchema {}