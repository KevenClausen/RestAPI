<?php
namespace KPG\RestAPI\API\CLI;

error_reporting(0);

use OpenApi\Generator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

if (isset($argv)) {
    if (PHP_SAPI !== 'cli') {
        die("This script must be run from the command line.\n");
    }

    require __DIR__ . '/../../../vendor/autoload.php';

    class OpenApiGenerator
    {
        // ANSI Colors
        private const COLOR_RESET = "\033[0m";
        private const COLOR_GREEN = "\033[32m";
        private const COLOR_YELLOW = "\033[33m";
        private const COLOR_RED = "\033[31m";
        private const COLOR_BLUE = "\033[34m";
        private const COLOR_CYAN = "\033[36m";
        private const COLOR_MAGENTA = "\033[35m";
        private const BOLD = "\033[1m";

        private string $baseDir;
        private string $outputPath;
        private string $globalComponentPath;
        private array $processedComponents = [];
        private int $totalMethods = 0;

        private array $componentTypes = [
            'schema',
            'response',
            'parameter',
            'requestBody',
            'header',
            'securityScheme',
            'link',
            'callback'
        ];
        private string $globalOpenApiDir;

        public function __construct()
        {
            $this->baseDir = __DIR__ . '/../../Components';
            $this->outputPath = __DIR__ . '/../../ILIAS/Config/Documentation/structure/openapi.json';
            $this->globalOpenApiDir = __DIR__ . '/../../API/OpenApi';
            $this->globalComponentPath = $this->globalOpenApiDir . '/Component.php';
        }

        public function run(): void
        {
            $this->logTitle("Starting OpenAPI CLI Generator");

            $this->checkBaseDirectory();

            // Build global OpenAPI component
            $this->logStep("Scanning and grouping components...");
            $allComponents = $this->groupClassesByType($this->scanComponents());

            $this->logStep("Writing global Component.php...");
            $this->writeGlobalComponent($allComponents);

            // Generate OpenAPI JSON
            $this->logStep("Generating OpenAPI JSON...");
            $openApi = Generator::scan([
                __DIR__ . "/../../Components",
                __DIR__ . "/../../API"
            ]);

            $json = $openApi->toJson();
            if(file_exists($this->outputPath)){
                unlink($this->outputPath);
            }
            $this->writeFile($this->outputPath, $json);

            $openApiArray = $this->parseOpenApiJson($json);

            // Generate component routes
            $this->logStep("Processing component routes...");
            foreach (new \DirectoryIterator($this->baseDir) as $folder) {
                if ($folder->isDot() || !$folder->isDir()) continue;

                $folderName = $folder->getFilename();
                foreach (new \DirectoryIterator($folder->getPathname()) as $dir) {
                    if ($dir->isDot() || !$dir->isDir()) continue;

                    $componentName = $dir->getFilename();
                    if (isset($openApiArray[$componentName])) {
                        $this->handleComponent($dir, $folderName, $openApiArray[$componentName]);
                    } else {
                        $this->logWarn("No OpenAPI data found for component: {$componentName} — skipped.");
                    }
                }
            }

            $this->printResults();
        }

        private function checkBaseDirectory(): void
        {
            if (!is_dir($this->baseDir)) {
                $this->logError("Base directory '{$this->baseDir}' does not exist.");
                exit(1);
            }
        }

        private function writeFile(string $path, string $content): void
        {
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            file_put_contents($path, $content);
            $this->logSuccess("Documentation file written");
        }

        private function parseOpenApiJson(string $json): array
        {
            $data = json_decode($json, true);
            $result = [];
            if (isset($data['paths'])) {
                foreach ($data['paths'] as $path => $methods) {
                    foreach ($methods as $httpMethod => $methodDetails) {
                        if (!isset($methodDetails['tags'])) continue;
                        foreach ($methodDetails['tags'] as $tag) {
                            $result[$tag][] = [
                                'route' => $path,
                                'http_method' => strtoupper($httpMethod),
                                'method' => $methodDetails['operationId'] ?? null,
                            ];
                        }
                    }
                }
            }
            return $result;
        }

        private function convertRoutePlaceholdersToRegex(string $route): string
        {
            $regex = preg_replace('/\{([\w-]+)\}/', '(?P<$1>[^/]+)', $route);
            return '/^' . str_replace('/', '\/', $regex) . '$/';
        }

        private function handleComponent(\DirectoryIterator $dir, string $parentFolder, array $openApiArray): void
        {
            $componentName = $dir->getFilename();
            $serviceFile = "{$dir->getPathname()}/{$componentName}Service.php";

            if (!file_exists($serviceFile)) {
                $this->logWarn("Missing service file for component: {$componentName}");
                return;
            }

            require_once $serviceFile;

            $className = "KPG\\RestAPI\\Components\\{$parentFolder}\\{$componentName}\\{$componentName}Service";

            if (!class_exists($className)) {
                $this->logWarn("Class '{$className}' does not exist. Component skipped.");
                return;
            }

            try {
                $methodCount = count($openApiArray);
                $this->totalMethods += $methodCount;
                $this->writeComponentFiles($dir, $componentName, $openApiArray);
                $this->processedComponents["{$parentFolder}\\{$componentName}"] = $methodCount;
            } catch (\Exception $e) {
                $this->logError("Error processing component {$componentName}: {$e->getMessage()}");
            }
        }

        private function writeComponentFiles(\DirectoryIterator $dir, string $componentName, array $routes): void
        {
            $structureFolder = "{$dir->getPathname()}/structure";
            if (is_dir($structureFolder)) {
                array_map('unlink', glob("{$structureFolder}/*"));
            } else {
                mkdir($structureFolder, 0777, true);
            }

            foreach ($routes as &$route) {
                $route['route'] = $this->convertRoutePlaceholdersToRegex($route['route']);
            }

            $filePath = "{$structureFolder}/{$componentName}Routes.php";
            $fileContent = "<?php\n\n\$routes = " . var_export($routes, true) . ";\n\nreturn [\n    'routes' => \$routes,\n];\n";

            file_put_contents($filePath, $fileContent);
            chmod($filePath, 0777);
        }

        private function printResults(): void
        {
            $this->logTitle("Processing Summary");
            foreach ($this->processedComponents as $component => $methodCount) {
                echo self::COLOR_CYAN . "- {$component}" . self::COLOR_RESET . " — Routes processed: " . self::COLOR_YELLOW . "{$methodCount}" . self::COLOR_RESET . "\n";
            }
            echo self::COLOR_MAGENTA . "----------------------------------------\n" . self::COLOR_RESET;
            echo self::BOLD . "Total routes processed: " . self::COLOR_GREEN . "{$this->totalMethods}" . self::COLOR_RESET . "\n";
        }

        private function writeGlobalComponent(array $allComponents): void
        {
            if (!is_dir($this->globalOpenApiDir)) {
                mkdir($this->globalOpenApiDir, 0777, true);
            }

            $content = "<?php\nnamespace KPG\\RestAPI\\Components\\KPG\\OpenApi;\n\nuse OpenApi\\Attributes as OA;\n\n";
            $content .= "#[OA\\Components(\n";

            $lines = [];
            $swaggerKeys = [
                'schemas',
                'responses',
                'parameters',
                'securitySchemes',
                'headers',
                'links',
                'callbacks',
                'examples'
            ];

            $oaClassMap = [
                'schemas' => 'Schema',
                'responses' => 'Response',
                'parameters' => 'Parameter',
                'securitySchemes' => 'SecurityScheme',
                'headers' => 'Header',
                'links' => 'Link',
                'callbacks' => 'Callback',
                'examples' => 'Example'
            ];

            foreach ($swaggerKeys as $key) {
                if (!empty($allComponents[$key])) {
                    $line = "    $key: [\n";
                    foreach ($allComponents[$key] as $className) {
                        if (class_exists($className)) {
                            $oaClass = $oaClassMap[$key] ?? 'Schema';
                            $line .= "        new OA\\$oaClass(ref: \\$className::class),\n";
                        } else {
                            $this->logWarn("Class '{$className}' not found — skipped in Component.");
                        }
                    }
                    $line .= "    ],";
                    $lines[] = $line;
                }
            }

            $content .= implode("\n", $lines) . "\n";
            $content .= ")]\nfinal class Component {}\n";

            file_put_contents($this->globalComponentPath, $content);
            chmod($this->globalComponentPath, 0777);

            $this->logSuccess("Component.php written successfully");
        }

        private function scanComponents(): array
        {
            $classes = [];

            $scanDir = function (string $dir) use (&$classes) {
                if (!is_dir($dir)) return;

                $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

                foreach ($rii as $file) {
                    if (!$file->isFile() || $file->getExtension() !== 'php') continue;

                    $content = file_get_contents($file->getPathname());

                    if (preg_match('/namespace\s+(.+?);/', $content, $nsMatch) &&
                        preg_match('/class\s+(\w+)/', $content, $classMatch)) {
                        $fullClass = $nsMatch[1] . '\\' . $classMatch[1];

                        foreach ($this->componentTypes as $type) {
                            if (stripos($fullClass, "\\$type\\") !== false) {
                                $classes[$type][] = $fullClass;
                                break;
                            }
                        }
                    }
                }
            };

            $scanDir($this->baseDir);
            $scanDir($this->globalOpenApiDir);

            return $classes;
        }

        private function groupClassesByType(array $classes): array
        {
            $grouped = [];
            foreach ($this->componentTypes as $type) {
                $key = $type === 'schema' ? 'schemas' : $type . 's';
                $grouped[$key] = $classes[$type] ?? [];
            }
            return $grouped;
        }

        // Logging helpers
        private function logTitle(string $message): void
        {
            echo "\n" . self::BOLD . self::COLOR_BLUE . "=== {$message} ===" . self::COLOR_RESET . "\n";
        }
        private function logStep(string $message): void
        {
            echo self::COLOR_CYAN . "[*] {$message}" . self::COLOR_RESET . "\n";
        }
        private function logSuccess(string $message): void
        {
            echo self::COLOR_GREEN . "[✓] {$message}" . self::COLOR_RESET . "\n";
        }
        private function logWarn(string $message): void
        {
            echo self::COLOR_YELLOW . "[!] {$message}" . self::COLOR_RESET . "\n";
        }
        private function logError(string $message): void
        {
            echo self::COLOR_RED . "[✗] {$message}" . self::COLOR_RESET . "\n";
        }
    }

    $generator = new OpenApiGenerator();
    $generator->run();
}
