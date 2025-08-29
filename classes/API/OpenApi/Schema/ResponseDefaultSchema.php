<?php

namespace KPG\RestAPI\API\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ResponseDefaultSchema",
    description: "Standard API response structure"
)]
final class ResponseDefaultSchema
{
    #[OA\Property(
        property: "status_code",
        type: "integer",
        example: 200
    )]
    public int $status_code;

    #[OA\Property(
        property: "error_code",
        type: "string",
        example: "",
        nullable: true
    )]
    public ?string $error_code;

    #[OA\Property(
        property: "response_data",
        type: "object"
    )]
    public object $response_data;

    #[OA\Property(
        property: "meta",
        type: "object",
        example: [
            "pagination" => ["limit" => 10, "offset" => 0],
            "sorting" => ["field" => "title", "direction" => "asc"]
        ]
    )]
    public object $meta;
}
