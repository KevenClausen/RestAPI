<?php
namespace KPG\RestAPI\Components\ILIAS\Group\OpenApi\Schema;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "GetGroupsResponseDataSchema",
    description: "Category details"
)]
class GetGroupsResponseDataSchema
{
    #[OA\Property(ref: "#/components/schemas/RefIdSchema")]
    public int $ref_id;
    #[OA\Property(ref: "#/components/schemas/ObjIdSchema")]
    public int $obj_id;
    #[OA\Property(ref: "#/components/schemas/TitleSchema")]
    public string $title;
    #[OA\Property(ref: "#/components/schemas/ParentIdSchema")]
    public string $presentation_title;
}