<?php

use ILIAS\Config\Documentation\DocumentationController;

/**
 * @ilCtrl_IsCalledBy ilRestAPIDocumentationGUI: ilUIPluginRouterGUI
 */
class ilRestAPIDocumentationGUI implements \KPG\RestAPI\ILIAS\Config\Constant\LangConstant
{
    use \KPG\RestAPI\ILIAS\Util\Language;
    public const CMD_GET_DOCU = 'getDocu';
    public const CMD_SHOW_DOCU = 'showDocu';
    protected ilGlobalTemplateInterface $tpl;

    private \ILIAS\DI\Container $DIC;
    private \ILIAS\Config\Documentation\DocumentationModel $documentation_model;

    public function __construct()
    {
        global $DIC;
        $this->DIC = $DIC;
        $this->tpl = $DIC->ui()->mainTemplate();
        $this->documentation_model = new \ILIAS\Config\Documentation\DocumentationModel();
    }

    public function executeCommand(): void
    {
        if ($this->DIC->user()->isAnonymous()) {
            exit();
        }
        $cmd = $this->DIC->ctrl()->getCmd();
        $this->$cmd();
        $this->tpl->printToStdout();
    }

    public function getDocu(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        exit($this->documentation_model->getDocumentationData(false));
    }

    public function showDocu(): void
    {
        $this->DIC->ui()->mainTemplate()->setTitle(self::getLang(self::LANG_TITLE_ILIAS_API_DOCUMENTATION));
        $panel = $this->DIC->ui()->factory()->panel()->standard(self::getLang(self::LANG_TAB_API_DOCUMENTATION), $this->DIC->ui()->factory()->legacy(file_get_contents(__DIR__ . '/templates/swagger-template.php')));

        $this->DIC->ui()->mainTemplate()->setContent(
            $this->DIC->ui()->renderer()->render(
                [$panel]
            )
        );
        $doc_api_link = ilRestAPIDocumentationGUI::getAPILink();

        $this->DIC->ui()->mainTemplate()->addOnLoadCode(
            <<<JS
                (async function () {
                    const response = await fetch("$doc_api_link", { method: 'GET' });
                    const data = await response.json();
                    if (!data) {
                        console.log("No data");
                    }
                    const swaggerJson = data;
                    const ui = SwaggerUIBundle({
                        spec: swaggerJson,
                        dom_id: '#swagger-ui',
                        tryItOutEnabled: false, 
                        deepLinking: false,
                        presets: [
                            SwaggerUIBundle.presets.apis,
                            SwaggerUIStandalonePreset
                        ],
                        plugins: [
                            SwaggerUIBundle.plugins.DownloadUrl
                        ],
                        layout: "BaseLayout",
                    });
                    window.ui = ui;
                    document.querySelectorAll('.url').forEach((element) => {
                        element.style.display = 'none';
                    });
                })();
            JS
        );
    }

    public static function getAPILink(): string
    {
        global $DIC;
        $ctrl = $DIC->ctrl();

        $url = ILIAS_HTTP_PATH . "/" . $ctrl->getLinkTargetByClass(
            [\ilUIPluginRouterGUI::class, ilRestAPIDocumentationGUI::class],
            ilRestAPIDocumentationGUI::CMD_GET_DOCU
        );

        $ctrl->clearParametersByClass(ilRestAPIDocumentationGUI::class);
        return $url;
    }

    public static function getGUILink(): string
    {
        global $DIC;
        $ctrl = $DIC->ctrl();

        $url = ILIAS_HTTP_PATH . "/" . $ctrl->getLinkTargetByClass(
            [\ilUIPluginRouterGUI::class, ilRestAPIDocumentationGUI::class],
            ilRestAPIDocumentationGUI::CMD_SHOW_DOCU
        );

        $ctrl->clearParametersByClass(ilRestAPIDocumentationGUI::class);
        return $url;
    }
}
