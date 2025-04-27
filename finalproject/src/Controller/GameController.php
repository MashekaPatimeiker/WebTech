<?php
namespace MyGameSite\Controller;

use MyGameSite\Services\TemplateEngine;

class GameController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function showGames(): void
    {
        $data = [
            'title' => 'Лучшие игры',
            'games' => $this->getGamesList(),
            'css' => '/finalproject/public/assets/css/games.css',
            'js' => '/finalproject/public/assets/js/games.js'
        ];

        echo $this->templateEngine->render('games', $data);
    }

    private function getGamesList(): array
    {
        return [
            [
                'name' => "The Legend of Zelda: Breath of the Wild",
                'description' => "Приключенческая игра в открытом мире, где вы исследуете королевство Хайрул.",
                'releaseYear' => 2017,
                'rating' => "10/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/9/9d/The_Legend_of_Zelda_Breath_of_the_Wild.jpg"
            ],
            [
                'name' => "Super Mario Odyssey",
                'description' => "Платформер, где Марио путешествует по разным королевствам, чтобы спасти принцессу Пич.",
                'releaseYear' => 2017,
                'rating' => "9.7/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/e/ec/Super_Mario_Odyssey.jpg"
            ],
            [
                'name' => "Minecraft",
                'description' => "Песочница, где вы можете строить и исследовать мир, созданный из блоков.",
                'releaseYear' => 2011,
                'rating' => "9.5/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png"
            ],
            [
                'name' => "The Witcher 3: Wild Hunt",
                'description' => "Ролевой экшен с открытым миром, основанный на книгах Анджея Сапковского.",
                'releaseYear' => 2015,
                'rating' => "10/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/0/0f/The_Witcher_3_Wild_Hunt.jpg"
            ],
            [
                'name' => "Dark Souls III",
                'description' => "Экшен-RPG с высокой сложностью и глубоким миром.",
                'releaseYear' => 2016,
                'rating' => "9.8/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/3/3e/Dark_Souls_III_cover.jpg"
            ],
            [
                'name' => "Prototype 2",
                'description' => "Экшен-игра с открытым миром, где вы играете за человека с суперспособностями.",
                'releaseYear' => 2012,
                'rating' => "8.5/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/5/5e/Prototype_2_cover.jpg"
            ],
            [
                'name' => "God of War",
                'description' => "Приключенческая игра, основанная на мифах Древней Греции и Скандинавии.",
                'releaseYear' => 2018,
                'rating' => "9.9/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/c/c7/God_of_War_2018_cover.jpg"
            ],
            [
                'name' => "Horizon Zero Dawn",
                'description' => "Экшен-RPG в открытом мире, где вы сражаетесь с механическими существами.",
                'releaseYear' => 2017,
                'rating' => "9.5/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/3/3f/Horizon_Zero_Dawn_cover.jpg"
            ],
            [
                'name' => "Bloodborne",
                'description' => "Экшен-RPG с элементами хоррора, действие которой происходит в мрачном мире.",
                'releaseYear' => 2015,
                'rating' => "9.6/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/1/1e/Bloodborne_cover.jpg"
            ],
            [
                'name' => "Final Fantasy VII Remake",
                'description' => "Переработанная версия классической JRPG с современными графикой и механикой.",
                'releaseYear' => 2020,
                'rating' => "9.4/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/1/1e/Final_Fantasy_VII_Remake_cover.jpg"
            ],
            [
                'name' => "Resident Evil 2 Remake",
                'description' => "Переработанная версия классического хоррора, с улучшенной графикой и механикой.",
                'releaseYear' => 2019,
                'rating' => "9.5/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/2/2f/Resident_Evil_2_Remake_cover.jpg"
            ],
            [
                'name' => "Sekiro: Shadows Die Twice",
                'description' => "Экшен-игра с элементами RPG, действие которой происходит в феодальной Японии.",
                'releaseYear' => 2019,
                'rating' => "9.8/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/3/3f/Sekiro_Shadows_Die_Twice_cover.jpg"
            ],
            [
                'name' => "Assassin's Creed Valhalla",
                'description' => "Приключенческая игра с открытым миром, основанная на викингах.",
                'releaseYear' => 2020,
                'rating' => "9.0/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/0/0c/Assassin%27s_Creed_Valhalla_cover.jpg"
            ],
            [
                'name' => "Cyberpunk 2077",
                'description' => "Ролевой экшен в открытом мире, действие которого происходит в будущем.",
                'releaseYear' => 2020,
                'rating' => "7.5/10", // Note: This rating reflects the initial reception.
                'image' => "https://upload.wikimedia.org/wikipedia/en/0/0e/Cyberpunk_2077_cover.jpg"
            ],
            [
                'name' => "Ghost of Tsushima",
                'description' => "Приключенческая игра с открытым миром, действие которой происходит в Японии во время монгольского вторжения.",
                'releaseYear' => 2020,
                'rating' => "9.7/10",
                'image' => "https://upload.wikimedia.org/wikipedia/en/3/3e/Ghost_of_Tsushima_cover.jpg"
            ]
        ];
    }

}
