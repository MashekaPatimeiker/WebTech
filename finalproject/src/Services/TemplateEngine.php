<?php
declare(strict_types=1);

namespace MyGameSite\Services;

use RuntimeException;

class TemplateEngine
{
    private string $templatesPath;
    private string $assetsPath;
    private string $baseUrl;

    public function __construct(string $templatesPath, string $assetsPath, string $baseUrl = '')
    {
        $this->templatesPath = rtrim($templatesPath, '/') . '/';
        $this->assetsPath = rtrim($assetsPath, '/') . '/';
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function render(string $templateName, array $data = []): string
    {
        $data['baseUrl'] = $this->baseUrl;

        $content = $this->renderTemplate($templateName, $data);

        return $this->renderLayout($content, $data);
    }

    private function renderTemplate(string $templateName, array $data): string
    {
        $templateFile = $this->templatesPath . $templateName . '.php';

        if (!file_exists($templateFile)) {
            throw new RuntimeException("Template file not found: {$templateFile}");
        }

        return $this->captureOutput($templateFile, $data);
    }

    private function renderLayout(string $content, array $data): string
    {
        $layoutFile = $this->templatesPath . 'layout.php';

        if (!file_exists($layoutFile)) {
            throw new RuntimeException("Layout file not found: {$layoutFile}");
        }

        $data['content'] = $content;
        $output = $this->captureOutput($layoutFile, $data);

        return $this->injectAssets($output, basename($data['_template'] ?? ''));
    }

    private function captureOutput(string $file, array $data): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return ob_get_clean();
    }

    private function injectAssets(string $content, string $templateName): string
    {
        $cssPath = "css/{$templateName}.css";
        $jsPath = "js/{$templateName}.js";

        if (file_exists($this->assetsPath . $cssPath)) {
            $cssTag = '<link rel="stylesheet" href="' . $this->getAssetUrl($cssPath) . '">';
            $content = str_replace('</head>', $cssTag . '</head>', $content);
        }

        if (file_exists($this->assetsPath . $jsPath)) {
            $jsTag = '<script src="' . $this->getAssetUrl($jsPath) . '"></script>';
            $content = str_replace('</body>', $jsTag . '</body>', $content);
        }

        return $content;
    }

    private function getAssetUrl(string $path): string
    {
        return $this->baseUrl . '/assets/' . ltrim($path, '/');
    }
}