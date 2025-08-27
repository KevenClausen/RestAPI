<?php
namespace KPG\RestAPI\API\OpenApi\SecurityScheme;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: "basic",
    type: "http",
    description: "The username and password to authenticate with the API."
)]
final class BasicSecurityScheme{}