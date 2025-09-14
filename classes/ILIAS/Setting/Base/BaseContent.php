<?php

namespace KPG\RestAPI\ILIAS\Setting\Base;

use ILIAS\UI\Factory;
use KPG\RestAPI\ILIAS\Setting\Enum\MessageType;
use KPG\RestAPI\ILIAS\Setting\Enum\CMD;
use ILIAS\UI\Implementation\Component\Input\Input;
use ILIAS\UI\Component\Input\Container\Container;
use Psr\Http\Message\RequestInterface;

abstract class BaseContent
{
    public function __construct(
        protected readonly \ILIAS\UI\Factory $factory,
        protected \ilGlobalTemplateInterface $tpl,
        protected readonly \ilPlugin $plugin,
        protected readonly \ilCtrlInterface $ctrl,
        protected readonly RequestInterface $request,
        protected readonly string $base_class
    ) {
    }
    abstract public function getContent(): Factory | Input | Container;
}
