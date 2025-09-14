<?php

namespace KPG\RestAPI\ILIAS\Setting\Enum;

enum MessageType: string
{
    case MESSAGE_TYPE_FAILURE = 'failure';
    case MESSAGE_TYPE_SUCCESS = "success";
    case MESSAGE_TYPE_QUESTION = "question";
    case MESSAGE_TYPE_INFO = "info";
}
