<?php
namespace KPG\RestAPI\Components\ILIAS\Category\OpenApi\Schema;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "GetCategoryResponseDataSchema",
    description: "Category details"
)]
class GetCategoryResponseDataSchema
{
    #[OA\Property(ref: "#/components/schemas/RefIdSchema")]
    public int $ref_id;

    #[OA\Property(ref: "#/components/schemas/ObjIdSchema")]
    public int $obj_id;

    #[OA\Property(ref: "#/components/schemas/TitleSchema")]
    public string $title;

    #[OA\Property(ref: "#/components/schemas/PresentationTitleSchema")]
    public string $presentation_title;

    #[OA\Property(ref: "#/components/schemas/DescriptionSchema")]
    public string $description;

    #[OA\Property(ref: "#/components/schemas/LongDescriptionSchema")]
    public string $long_description;

    #[OA\Property(ref: "#/components/schemas/OfflineStatusSchema")]
    public bool $offlineStatus;

    #[OA\Property(ref: "#/components/schemas/OwnerSchema")]
    public int $owner;

    #[OA\Property(ref: "#/components/schemas/CreateDateSchema")]
    public string $creation_date;
}