<?php
declare(strict_types=1);
namespace MyGameSite\Services;

use RuntimeException;

class TemplateEngine
{
    private string $templatesPath;
    private string $assetsPath;

    public function __construct(string $templatesPath, string $assetsPath)
    {
        $this->templatesPath = rtrim($templatesPath, '/') . '/';
        $this->assetsPath = rtrim($assetsPath, '/') . '/';
    }

    public function render(string $templateName, array $data = []): string
    {
        extract($data, EXTR_SKIP);

        $templateFile = $this->templatesPath . $templateName . '.php';
        if (!file_exists($templateFile)) {
            throw new RuntimeException("Template file not found: {$templateFile}");
        }

        ob_start();
        include $templateFile;
        $content = ob_get_clean();

        // Проверка существования layout
        $layoutFile = $this->templatesPath . 'layout.php';
        if (!file_exists($layoutFile)) {
            throw new RuntimeException("Layout file not found: {$layoutFile}");
        }
        ob_start();
        include $layoutFile;
        $output = ob_get_clean();

        return $this->injectAssets($output, $templateName);
    }

    private function injectAssets(string $content, string $templateName): string
    {
        $baseName = basename($templateName);
        $cssFile = $this->assetsPath . 'css/' . $baseName . '.css';
        $jsFile = $this->assetsPath . 'js/' . $baseName . '.js';

        if (file_exists($cssFile)) {
            $css = '<link rel="stylesheet" href="' . $this->getAssetUrl('css/' . $baseName . '.css') . '">';
            $content = str_replace('</head>', $css . '</head>', $content);
        }

        if (file_exists($jsFile)) {
            $js = '<script src="' . $this->getAssetUrl('js/' . $baseName . '.js') . '"></script>';
            $content = str_replace('</body>', $js . '</body>', $content);
        }

        return $content;
    }

    private function getAssetUrl(string $path): string
    {
        $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->assetsPath . $path);
        return str_replace('//', '/', $relativePath);
    }
}