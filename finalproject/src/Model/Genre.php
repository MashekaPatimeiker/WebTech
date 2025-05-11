<?php
declare(strict_types=1);

namespace MyGameSite\Model;

class Genre
{
    private ?int $id;
    private string $name;
    private ?string $description;

    public function __construct(?int $id, string $name, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    // Геттеры
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }

    // Сеттеры
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(?string $description): void { $this->description = $description; }
}