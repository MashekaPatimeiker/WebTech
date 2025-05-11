<?php
declare(strict_types=1);

namespace MyGameSite\Controller;

use MyGameSite\Repository\GameRepository;
use MyGameSite\Services\TemplateEngine;

class GameController
{
    private TemplateEngine $templateEngine;
    private GameRepository $gameRepository;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
        $this->gameRepository = new GameRepository();
    }

    public function showGames(): void
    {
        $games = $this->gameRepository->findAll();

        $gamesData = array_map(function($game) {
            return [
                'name' => $game->getName(),
                'description' => $game->getDescription(),
                'releaseYear' => $game->getReleaseYear(),
                'rating' => $game->getRating() !== null ? number_format($game->getRating(), 1) . '/10' : 'N/A',
                'image' => $game->getImageUrl(),
                'genres' => array_map(function($genre) {
                    return $genre->getName();
                }, $game->getGenres())
            ];
        }, $games);

        $data = [
            'title' => 'Лучшие игры',
            'games' => $gamesData,
            'css' => '/finalproject/public/assets/css/games.css',
            'js' => '/finalproject/public/assets/js/games.js'
        ];

        echo $this->templateEngine->render('games', $data);
    }
}