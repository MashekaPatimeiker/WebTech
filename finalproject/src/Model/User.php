<?php
declare(strict_types=1);

namespace MyGameSite\Model;

class User
{
    private ?int $id;
    private string $username;
    private string $email;
    private string $passwordHash;
    private string $role;
    private string $createdAt;

    public function __construct(
        ?int $id,
        string $username,
        string $email,
        string $passwordHash,
        string $role = 'user',
        string $createdAt = ''
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->createdAt = $createdAt;
    }

    // Геттеры
    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function getRole(): string { return $this->role; }
}