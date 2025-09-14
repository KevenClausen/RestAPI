<?php

namespace KPG\RestAPI\ILIAS\Setting\Base;

use KPG\RestAPI\ILIAS\Setting\Enum\MessageType;
use KPG\RestAPI\ILIAS\Setting\Enum\CMD;

class BaseSettingModifiyResult
{
    public function __construct(
        private readonly MessageType $type,
        private readonly string $message,
        private readonly CMD $redirect_cmd,
    ) {
    }

    public function getType(): MessageType
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRedirectCmd(): CMD
    {
        return $this->redirect_cmd;
    }
}
