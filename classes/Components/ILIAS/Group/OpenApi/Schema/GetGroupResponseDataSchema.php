<?php

namespace KPG\RestAPI\Components\ILIAS\Group\OpenApi\Schema;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "GetGroupResponseDataSchema",
    description: "Group details"
)]
class GetGroupResponseDataSchema
{
    #[OA\Property(ref: "#/components/schemas/RefIdSchema")]
    public int $ref_id;

    #[OA\Property(ref: "#/components/schemas/ObjIdSchema")]
    public int $obj_id;

    #[OA\Property(ref: "#/components/schemas/TitleSchema")]
    public string $title;

    #[OA\Property(ref: "#/components/schemas/DescriptionSchema")]
    public string $description;

    #[OA\Property(ref: "#/components/schemas/LongDescriptionSchema")]
    public string $long_description;

    #[OA\Property(
        description: "Owner details",
        properties: [
            new OA\Property(property: "id", ref: "#/components/schemas/OwnerSchema"),
            new OA\Property(property: "name", ref: "#/components/schemas/OwnerNameSchema")
        ],
        type: "object"
    )]
    public array $owner;

    #[OA\Property(ref: "#/components/schemas/CreateDateSchema")]
    public string $create_date;

    #[OA\Property(
        ref: "#/components/schemas/LastUpdateDataSchema",
        description: "Last update date"
    )]
    public string $last_update;

    #[OA\Property(
        ref: "#/components/schemas/ImportIdSchema",
        description: "Import ID of the group"
    )]
    public ?string $import_id;

    #[OA\Property(
        ref: "#/components/schemas/OfflineStatusSchema",
        description: "Offline status"
    )]
    public bool $offline;

    #[OA\Property(
        description: "Default roles",
        properties: [
            new OA\Property(property: "default_member_role", ref: "#/components/schemas/RoleNameSchema"),
            new OA\Property(property: "default_admin_role", ref: "#/components/schemas/RoleNameSchema")
        ],
        type: "object"
    )]
    public array $default_roles;

    #[OA\Property(
        description: "Custom roles for the group",
        type: "object",
        additionalProperties: new OA\AdditionalProperties(
            ref: "#/components/schemas/RoleNameSchema"
        )
    )]
    public array $roles;

    #[OA\Property(
        description: "Parent information",
        properties: [
            new OA\Property(property: "ref_id", ref: "#/components/schemas/RefIdSchema"),
            new OA\Property(property: "obj_id", ref: "#/components/schemas/ObjIdSchema"),
            new OA\Property(property: "title", ref: "#/components/schemas/TitleSchema"),
            new OA\Property(property: "type", ref: "#/components/schemas/ObjectTypeSchema")
        ],
        type: "object"
    )]
    public array $parent;

    #[OA\Property(
        description: "Child objects",
        type: "array",
        items: new OA\Items(
            properties: [
                new OA\Property(property: "ref_id", ref: "#/components/schemas/RefIdSchema"),
                new OA\Property(property: "obj_id", ref: "#/components/schemas/ObjIdSchema"),
                new OA\Property(property: "title", ref: "#/components/schemas/TitleSchema"),
                new OA\Property(property: "type", ref: "#/components/schemas/ObjectTypeSchema")
            ],
            type: "object"
        )
    )]
    public array $childs;
}
