<?php
declare(strict_types=1);

namespace Controller;

use FileManager\FileManager;

class AdminController
{
    public function index(): void
    {
        // Аутентификация уже выполнена Apache
        $manager = new FileManager();
        $manager->handleRequest();
    }
}