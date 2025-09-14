<?php

namespace KPG\RestAPI\ILIAS\Setting\Enum;

enum Mode: string
{
    case SAVE = "SAVE";
    case CREATE = "CREATE";
    case UPDATE = "UPDATE";
    case DELETE = "DELETE";
}
