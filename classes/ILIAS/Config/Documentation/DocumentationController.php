<?php

namespace ILIAS\Config\Documentation;

use ilRestAPIDocumentationGUI;
use KPG\RestAPI\ILIAS\Config\Constant\LangConstant;

class DocumentationController implements LangConstant
{
    use \KPG\RestAPI\ILIAS\Util\Language;
    private DocumentationModel $model;
    private $DIC;

    public function __construct()
    {
        $this->model = new DocumentationModel();
        global $DIC;
        $this->DIC = $DIC;
    }

    public function init()
    {
        $input_link = $this->DIC->ui()->factory()->input()->field()->text(
            self::getLang(self::LANG_LINK_TO_DOCUMENTATION),
            self::getLang(self::LANG_LINK_TO_DOCUMENTATION_BYLINE),
        )->withValue(ilRestAPIDocumentationGUI::getGUILink());
        $panel_link = $this->DIC->ui()->factory()->panel()->standard(
            self::getLang(self::LANG_DEVELOPER_DOCUMENTATION),
            [$input_link]
        );
        $panel = $this->DIC->ui()->factory()->panel()->standard(self::getLang(self::LANG_TAB_API_DOCUMENTATION), $this->DIC->ui()->factory()->legacy(file_get_contents(__DIR__ . '/templates/swagger-template.php')));


        $this->DIC->ui()->mainTemplate()->setContent(
            $this->DIC->ui()->renderer()->render([$panel_link,$panel])
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
}
