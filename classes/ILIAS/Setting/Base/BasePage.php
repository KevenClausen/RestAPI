<?php

namespace KPG\RestAPI\ILIAS\Setting\Base;

use KPG\RestAPI\ILIAS\Setting\Enum\Tab;
use Psr\Http\Message\RequestInterface;

abstract class BasePage
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
    abstract public function getMainTab(): Tab;
    abstract public function getSubTab(): ?Tab;
    abstract public function getContent(): array;
}
