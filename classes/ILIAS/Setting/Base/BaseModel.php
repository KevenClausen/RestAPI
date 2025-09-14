<?php
namespace KPG\RestAPI\ILIAS\Setting\Base;
use KPG\RestAPI\ILIAS\Setting\Enum\Mode;

abstract class BaseModel
{
    public function __construct(
        protected readonly \ILIAS\UI\Factory $factory,
        protected \ilGlobalTemplateInterface $tpl,
        protected readonly \ilPlugin $plugin,
        protected readonly \ilCtrlInterface $ctrl,
        protected readonly string $base_class
    ) {
    }
    abstract public function set(Mode $mode): bool | BaseSettingModifiyResult;
    abstract public function get(string $item): mixed;
}
