<?php
declare(strict_types=1);

namespace MyGameSite\Model;

class Game
{
    private ?int $id;
    private string $name;
    private string $description;
    private int $releaseYear;
    private ?float $rating;
    private ?string $imageUrl;
    private array $genres = [];

    public function __construct(
        ?int $id,
        string $name,
        string $description,
        int $releaseYear,
        ?float $rating = null,
        ?string $imageUrl = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->releaseYear = $releaseYear;
        $this->rating = $rating;
        $this->imageUrl = $imageUrl;
    }

    // Геттеры
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getReleaseYear(): int { return $this->releaseYear; }
    public function getRating(): ?float { return $this->rating; }
    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function getGenres(): array { return $this->genres; }

    // Сеттеры
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setReleaseYear(int $releaseYear): void { $this->releaseYear = $releaseYear; }
    public function setRating(?float $rating): void { $this->rating = $rating; }
    public function setImageUrl(?string $imageUrl): void { $this->imageUrl = $imageUrl; }
    public function setGenres(array $genres): void { $this->genres = $genres; }

    public function addGenre(Genre $genre): void
    {
        $this->genres[] = $genre;
    }
}