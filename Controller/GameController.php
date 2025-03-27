<?php

namespace Controller;

class GameController {
    public function showGames() {
        $games = [
            "The Legend of Zelda: Breath of the Wild",
            "Super Mario Odyssey",
            "Minecraft",
            "The Witcher 3: Wild Hunt",
            "Dark Souls III"
        ];

        include __DIR__ . '/../Views/games.php';
    }
}
