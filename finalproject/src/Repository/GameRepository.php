<?php
declare(strict_types=1);

namespace MyGameSite\Repository;

use MyGameSite\Database\DatabaseConnection;
use MyGameSite\Model\Game;
use MyGameSite\Model\Genre;
use PDO;

class GameRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query('SELECT * FROM games ORDER BY rating DESC');
        $games = [];

        while ($row = $stmt->fetch()) {
            $game = $this->getGame($row);

            $games[] = $game;
        }

        return $games;
    }

    private function findGenresForGame(int $gameId): array
    {
        $stmt = $this->connection->prepare('
            SELECT g.id, g.name, g.description 
            FROM genres g
            JOIN game_genres gg ON g.id = gg.genre_id
            WHERE gg.game_id = ?
        ');
        $stmt->execute([$gameId]);

        $genres = [];
        while ($row = $stmt->fetch()) {
            $genres[] = new Genre(
                (int)$row['id'],
                $row['name'],
                $row['description']
            );
        }

        return $genres;
    }

    /**
     * @param mixed $row
     * @return Game
     */
    public function getGame(mixed $row): Game
    {
        $game = new Game(
            (int)$row['id'],
            $row['name'],
            $row['description'],
            (int)$row['release_year'],
            $row['rating'] !== null ? (float)$row['rating'] : null,
            $row['image_url']
        );

        // Получаем жанры для игры
        $genres = $this->findGenresForGame($game->getId());
        $game->setGenres($genres);
        return $game;
    }

}