<?php

namespace MyGameSite\Controller;

use MyGameSite\Services\TemplateEngine;

class NewsController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function index(): void
    {
        $data = ['title' => 'Новости игр'];
        echo $this->templateEngine->render('news/index', $data);
    }
}