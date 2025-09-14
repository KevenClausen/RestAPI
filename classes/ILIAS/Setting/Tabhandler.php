<?php

namespace KPG\RestAPI\ILIAS\Setting;

use ilRestAPIConfigGUI;
use KPG\RestAPI\ILIAS\Setting\Enum\Tab;
use KPG\RestAPI\ILIAS\Setting\Enum\CMD;

/**
 * Handles the management and initialization of tabs and subtabs within the configuration interface.
 *
 * The `Tabhandler` class provides functionality for defining, initializing, and activating
 * tabs and their respective subtabs. These tabs are configured with commands and linked to
 * corresponding plugin logic based on the application's requirements.
 */
class Tabhandler
{
    /**
     * Configuration for application tabs and their respective commands.
     *
     * The configuration array defines the main tabs and their associated commands, as well as any subtabs
     * and the specific commands linked to them. Each tab points to a corresponding command, with subtabs
     * extending the main tab functionality where necessary.
     */
    private array $config_tabs = [];

    /**
     * Constructor function to initialize the plugin, tabs, and control interface,
     * and to configure the tabs with their respective permissions, commands, and subtabs.
     *
     * @param \ilPlugin        $plugin The plugin instance.
     * @param \ilTabsGUI       $tabs   The tabs GUI instance.
     * @param \ilCtrlInterface $ctrl   The control interface instance.
     */
    public function __construct(
        private readonly \ilPlugin $plugin,
        private readonly \ilTabsGUI $tabs,
        private readonly \ilCtrlInterface $ctrl,
    ) {
        $this->config_tabs = [
            Tab::PERMISSION->value => [
                'cmd' => CMD::SHOW_ROLE_PERMISSION,
                'subtabs' => [
                    Tab::PERMISSION_ROLE->value => [
                        'cmd' => CMD::SHOW_ROLE_PERMISSION
                    ],
                    Tab::PERMISSION_COMPONENT->value => [
                        'cmd' => CMD::SHOW_ROLE_PERMISSION
                    ],
                ]
            ],
            Tab::DOCUMENTATION->value => [
                'cmd' => CMD::SHOW_DOCUMENTATION,
            ],
            Tab::LOG->value => [
                'cmd' => CMD::SHOW_LOG_TABLE,
                'subtabs' => [
                    Tab::LOG_TABLE->value => [
                        'cmd' => CMD::SHOW_LOG_TABLE
                    ],
                    Tab::LOG_SETTING->value => [
                        'cmd' => CMD::SHOW_LOG_SETTING
                    ],
                ]
            ]
        ];

    }

    /**
     * Initializes the tabs and subtabs for the configuration interface.
     *
     * This method processes the `$config_tabs` property to add main tabs and their
     * respective subtabs. Each tab and subtab is linked to a corresponding command
     * if it exists and is valid.
     *
     * A main tab is added first if defined in the configuration, and then any
     * associated subtabs are added recursively based on their definitions.
     *
     * @param Tab $main_tab The main tab to be initialized. Subtabs are initialized
     *                      relative to this main tab.
     */
    public function initTabs(Tab $main_tab): void
    {
        foreach ($this->config_tabs as $tab_id => $tab_config) {
            if (!isset($tab_config['cmd']) || !$tab_config['cmd'] instanceof CMD) {
                continue;
            }

            $tab = Tab::from($tab_id);
            $this->tabs->addTab(
                $tab->value,
                $this->plugin->txt($tab_id),
                $this->ctrl->getLinkTargetByClass(ilRestAPIConfigGUI::class, $tab_config['cmd']->value)
            );

        }
        if (!array_key_exists($main_tab->value, $this->config_tabs)) {
            return;
        }
        $main_tab_config = $this->config_tabs[$main_tab->value];

        $subtabs = [];
        if (isset($main_tab_config['subtabs']) && is_array($main_tab_config['subtabs'])) {
            $subtabs = $main_tab_config['subtabs'];
        } elseif (is_array($main_tab_config)) {
            $subtabs = array_filter($main_tab_config, function ($item) {
                return is_array($item) && isset($item['cmd']) && $item['cmd'] instanceof CMD;
            });
        }

        foreach ($subtabs as $sub_tab_id => $sub_tab_config) {
            if (!isset($sub_tab_config['cmd']) || !$sub_tab_config['cmd'] instanceof CMD) {
                continue;
            }
            $subtab = Tab::from($sub_tab_id);
            $this->tabs->addSubTab(
                $subtab->value,
                $this->plugin->txt($sub_tab_id),
                $this->ctrl->getLinkTargetByClass(ilRestAPIConfigGUI::class, $sub_tab_config['cmd']->value)
            );
        }
    }

    /**
     * Activates a specified main tab and optionally a subtab within the configuration interface.
     *
     * This method sets the given main tab as active. If a subtab is provided, it will also
     * activate the specified subtab under the selected main tab.
     *
     * @param Tab      $main_tab_id The main tab to activate.
     * @param Tab|null $sub_tab_id  Optional subtab to activate under the main tab.
     */
    public function activateTab(Tab $main_tab_id, ?Tab $sub_tab_id = null): void
    {
        $this->tabs->activateTab($main_tab_id->value);
        if ($sub_tab_id != null) {
            $this->tabs->activateSubTab($sub_tab_id->value);
        }
    }
}
