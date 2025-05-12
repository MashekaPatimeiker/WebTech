CREATE DATABASE IF NOT EXISTS game_site;
USE game_site;

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) NOT NULL UNIQUE,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password_hash VARCHAR(255) NOT NULL,
                       role ENUM('user', 'admin') DEFAULT 'user',
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE genres (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(50) NOT NULL UNIQUE,
                        description TEXT
) ENGINE=InnoDB;

CREATE TABLE games (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       description TEXT NOT NULL,
                       release_year INT NOT NULL,
                       rating DECIMAL(3,1),
                       image_url VARCHAR(255),
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE game_genres (
                             game_id INT NOT NULL,
                             genre_id INT NOT NULL,
                             PRIMARY KEY (game_id, genre_id),
                             FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
                             FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_games_name ON games(name);
CREATE INDEX idx_games_rating ON games(rating);
CREATE INDEX idx_games_release_year ON games(release_year);

INSERT INTO genres (name, description) VALUES
                                           ('Action', 'Games focused on physical challenges, including hand-eye coordination and reaction time.'),
                                           ('Adventure', 'Games that emphasize exploration, puzzle-solving, and narrative.'),
                                           ('RPG', 'Role-playing games where players assume the roles of characters in a fictional setting.'),
                                           ('Open World', 'Games that allow players to freely explore a virtual world.'),
                                           ('Horror', 'Games designed to scare and unsettle players.'),
                                           ('Platformer', 'Games that involve guiding a character through obstacles to reach a goal.');

INSERT INTO games (name, description, release_year, rating, image_url) VALUES
                                                                           ('The Legend of Zelda: Breath of the Wild', 'Тестовая фраза для проверки работает ли бд', 2017, 10.0, 'https://upload.wikimedia.org/wikipedia/en/9/9d/The_Legend_of_Zelda_Breath_of_the_Wild.jpg'),
                                                                           ('Super Mario Odyssey', 'Платформер, где Марио путешествует по разным королевствам, чтобы спасти принцессу Пич.', 2017, 9.7, 'https://upload.wikimedia.org/wikipedia/en/e/ec/Super_Mario_Odyssey.jpg'),
                                                                           ('Minecraft', 'Песочница, где вы можете строить и исследовать мир, созданный из блоков.', 2011, 9.5, 'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png'),
                                                                           ('The Witcher 3: Wild Hunt', 'Ролевой экшен с открытым миром, основанный на книгах Анджея Сапковского.', 2015, 10.0, 'https://upload.wikimedia.org/wikipedia/en/0/0f/The_Witcher_3_Wild_Hunt.jpg'),
                                                                           ('Dark Souls III', 'Экшен-RPG с высокой сложностью и глубоким миром.', 2016, 9.8, 'https://upload.wikimedia.org/wikipedia/en/3/3e/Dark_Souls_III_cover.jpg'),
                                                                           ('Prototype 2', 'Экшен-игра с открытым миром, где вы играете за человека с суперспособностями.', 2012, 8.5, 'https://upload.wikimedia.org/wikipedia/en/5/5e/Prototype_2_cover.jpg'),
                                                                           ('God of War', 'Приключенческая игра, основанная на мифах Древней Греции и Скандинавии.', 2018, 9.9, 'https://upload.wikimedia.org/wikipedia/en/c/c7/God_of_War_2018_cover.jpg'),
                                                                           ('Horizon Zero Dawn', 'Экшен-RPG в открытом мире, где вы сражаетесь с механическими существами.', 2017, 9.5, 'https://upload.wikimedia.org/wikipedia/en/3/3f/Horizon_Zero_Dawn_cover.jpg'),
                                                                           ('Bloodborne', 'Экшен-RPG с элементами хоррора, действие которой происходит в мрачном мире.', 2015, 9.6, 'https://upload.wikimedia.org/wikipedia/en/1/1e/Bloodborne_cover.jpg'),
                                                                           ('Final Fantasy VII Remake', 'Переработанная версия классической JRPG с современными графикой и механикой.', 2020, 9.4, 'https://upload.wikimedia.org/wikipedia/en/1/1e/Final_Fantasy_VII_Remake_cover.jpg'),
                                                                           ('Resident Evil 2 Remake', 'Переработанная версия классического хоррора, с улучшенной графикой и механикой.', 2019, 9.5, 'https://upload.wikimedia.org/wikipedia/en/2/2f/Resident_Evil_2_Remake_cover.jpg'),
                                                                           ('Sekiro: Shadows Die Twice', 'Экшен-игра с элементами RPG, действие которой происходит в феодальной Японии.', 2019, 9.8, 'https://upload.wikimedia.org/wikipedia/en/3/3f/Sekiro_Shadows_Die_Twice_cover.jpg'),
                                                                           ('Assassin''s Creed Valhalla', 'Приключенческая игра с открытым миром, основанная на викингах.', 2020, 9.0, 'https://upload.wikimedia.org/wikipedia/en/0/0c/Assassin%27s_Creed_Valhalla_cover.jpg'),
                                                                           ('Cyberpunk 2077', 'Ролевой экшен в открытом мире, действие которого происходит в будущем.', 2020, 7.5, 'https://upload.wikimedia.org/wikipedia/en/0/0e/Cyberpunk_2077_cover.jpg'),
                                                                           ('Ghost of Tsushima', 'Приключенческая игра с открытым миром, действие которой происходит в Японии во время монгольского вторжения.', 2020, 9.7, 'https://upload.wikimedia.org/wikipedia/en/3/3e/Ghost_of_Tsushima_cover.jpg');

INSERT INTO game_genres (game_id, genre_id) VALUES
                                                (1, 1), (1, 2), (1, 3), (1, 4),
                                                (2, 1), (2, 2), (2, 6),
                                                (3, 4),
                                                (4, 1), (4, 3), (4, 4),
                                                (5, 1), (5, 3),
                                                (6, 1), (6, 4),
                                                (7, 1), (7, 2), (7, 3),
                                                (8, 1), (8, 3), (8, 4),
                                                (9, 1), (9, 3), (9, 5),
                                                (10, 1), (10, 3),
                                                (11, 1), (11, 5),
                                                (12, 1), (12, 3),
                                                (13, 1), (13, 2), (13, 4),
                                                (14, 1), (14, 3), (14, 4),
                                                (15, 1), (15, 2), (15, 4);

INSERT INTO users (username, email, password_hash, role) VALUES
    ('admin', 'admin@gamesite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');