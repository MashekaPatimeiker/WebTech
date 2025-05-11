<?php
declare(strict_types=1);

namespace MyGameSite\Repository;

use MyGameSite\Database\DatabaseConnection;
use MyGameSite\Model\User;
use PDO;

class UserRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance();
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);

        if ($row = $stmt->fetch()) {
            return new User(
                (int)$row['id'],
                $row['username'],
                $row['email'],
                $row['password_hash'],
                $row['role'],
                $row['created_at']
            );
        }

        return null;
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            $stmt = $this->connection->prepare('
                INSERT INTO users (username, email, password_hash, role)
                VALUES (:username, :email, :password_hash, :role)
            ');

            $stmt->execute([
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password_hash' => $user->getPasswordHash(),
                ':role' => $user->getRole()
            ]);

            $userId = $this->connection->lastInsertId();
            $user->setId((int)$userId);
        } else {
            $stmt = $this->connection->prepare('
                UPDATE users 
                SET username = :username, 
                    email = :email, 
                    password_hash = :password_hash, 
                    role = :role
                WHERE id = :id
            ');

            $stmt->execute([
                ':id' => $user->getId(),
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password_hash' => $user->getPasswordHash(),
                ':role' => $user->getRole()
            ]);
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
}