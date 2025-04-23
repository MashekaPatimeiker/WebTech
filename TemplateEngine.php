<?php
declare(strict_types=1);


class TemplateEngine
{
    private string $templateDir;
    private array $data = [];
    private array $blocks = [];
    private string $currentBlock;

    public function __construct(string $templateDir = __DIR__ . '/../Public/templates')
    {
        $this->templateDir = rtrim($templateDir, '/');
    }

    public function render(string $view, array $data = []): string
    {
        $this->data = array_merge($this->data, $data);
        $templatePath = $this->resolvePath($view);

        ob_start();
        extract($this->data);
        include $templatePath;
        $content = ob_get_clean();

        return $this->renderLayout($content);
    }

    private function resolvePath(string $view): string
    {
        $path = $this->templateDir . '/' . ltrim($view, '/');
        if (!file_exists($path)) {
            throw new \RuntimeException("Template {$view} not found");
        }
        return $path;
    }

    public function extend(string $layout): void
    {
        $this->layout = $layout;
    }

    public function block(string $name): void
    {
        $this->currentBlock = $name;
        ob_start();
    }

    public function endblock(): void
    {
        $this->blocks[$this->currentBlock] = ob_get_clean();
    }

    private function renderLayout(string $content): string
    {
        if (!isset($this->layout)) {
            return $content;
        }

        $layoutPath = $this->resolvePath($this->layout);
        ob_start();
        extract($this->data);
        include $layoutPath;
        return ob_get_clean();
    }

    public function insert(string $view, array $data = []): string
    {
        $template = new self($this->templateDir);
        return $template->render($view, array_merge($this->data, $data));
    }

    public function e(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    public function js(string $path): string
    {
        return '<script src="' . $this->e($path) . '"></script>';
    }

    public function css(string $path): string
    {
        return '<link rel="stylesheet" href="' . $this->e($path) . '">';
    }
}
