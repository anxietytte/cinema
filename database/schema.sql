CREATE DATABASE IF NOT EXISTS cinema_booking
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cinema_booking;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS movie_genres;
DROP TABLE IF EXISTS movie;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS statuses;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    phone VARCHAR(20) DEFAULT NULL,
    avatar TEXT DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE genres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(10),
    color VARCHAR(20),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE movie (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    poster_url TEXT,
    year INT,
    country VARCHAR(100),
    rating DECIMAL(3,1) DEFAULT 0,
    duration INT,
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_title (title),
    INDEX idx_year (year),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE movie_genres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    movie_id INT NOT NULL,
    genre_id INT NOT NULL,
    CONSTRAINT fk_movie_genres_movie FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE,
    CONSTRAINT fk_movie_genres_genre FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE,
    UNIQUE KEY unique_movie_genre (movie_id, genre_id),
    INDEX idx_movie_id (movie_id),
    INDEX idx_genre_id (genre_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE statuses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    code VARCHAR(30) NOT NULL UNIQUE,
    description TEXT,
    sort_order INT DEFAULT 0,
    color VARCHAR(20),
    INDEX idx_code (code),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    status_id INT NOT NULL,
    seats VARCHAR(100) NOT NULL,
    seat_row VARCHAR(10),
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    session_date DATETIME NOT NULL,
    total_price DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_bookings_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_bookings_movie FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE,
    CONSTRAINT fk_bookings_status FOREIGN KEY (status_id) REFERENCES statuses(id) ON DELETE RESTRICT,
    INDEX idx_user_id (user_id),
    INDEX idx_movie_id (movie_id),
    INDEX idx_status_id (status_id),
    INDEX idx_session_date (session_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO statuses (name, code, description, sort_order, color) VALUES
('Новая', 'new', 'Бронирование создано', 1, '#3498db'),
('В обработке', 'processing', 'Бронирование проверяется', 2, '#f39c12'),
('Подтверждена', 'confirmed', 'Бронирование подтверждено', 3, '#2ecc71'),
('Отклонена', 'cancelled', 'Бронирование отклонено', 4, '#e74c3c'),
('Завершена', 'completed', 'Сеанс прошёл', 5, '#95a5a6');

INSERT INTO genres (name, description, icon, color) VALUES
('Ужасы', 'Захватывающие фильмы, от которых кровь стынет в жилах', '#cd3c3c'),
('Триллер', 'Напряжённые сюжеты и неожиданные развязки', '#ff6b35'),
('Боевик', 'Динамичные сцены, погони и перестрелки', '#e74c3c'),
('Комедия', 'Поднимите себе настроение', '#f1c40f'),
('Драма', 'Глубокие эмоциональные истории', '#9b59b6'),
('Криминал', 'Преступления, расследования и мафия', '#2c3e50'),
('Семейный', 'Кино для всей семьи', '#2ecc71'),
('Фантастика', 'Путешествия во времени и космос', '#3498db'),
('Культовое кино', 'Фильмы, ставшие легендами', '#e67e22');

INSERT INTO users (email, password, name, phone, role, registered_at, created_at, is_active) VALUES
('user@test.ru', '$2y$12$7QBffK4nvZffq1vxRzI/9uJV0Py0MdBNYuOXtki6WMta/yg3prNHS', 'Пользователь', '+7 (999) 123-45-67', 'user', NOW(), NOW(), 1),
('admin@test.ru', '$2y$12$7QBffK4nvZffq1vxRzI/9uJV0Py0MdBNYuOXtki6WMta/yg3prNHS', 'Администратор', '+7 (999) 000-00-01', 'admin', NOW(), NOW(), 1),
('test@mail.ru', '$2y$12$7QBffK4nvZffq1vxRzI/9uJV0Py0MdBNYuOXtki6WMta/yg3prNHS', 'test', '+7 (999) 222-33-44', 'user', NOW(), NOW(), 1);

INSERT INTO movie (title, description, poster_url, year, country, rating, duration, release_date) VALUES
('Крик 7', 'Когда Призрачное лицо появляется в тихом городке, где Сидни Прескотт построила новую жизнь, её самые страшные кошмары становятся реальностью: её дочь становится следующей целью.', 'https://i.pinimg.com/736x/e4/ed/df/e4eddf98d81ae630a431d6d6bd1fef2c.jpg', 2025, 'США', 4.8, 125, '2025-05-23'),
('Готов или нет', 'Свадебная ночь невесты превращается в смертельную игру в прятки с её богатыми родственниками. Комедия ужасов, полная чёрного юмора.', 'https://i.pinimg.com/736x/78/6c/b8/786cb8b688270e0f2fff80da566c064b.jpg', 2019, 'США', 4.5, 95, '2019-10-15'),
('Пацаны', 'Группа простых смертных сражается с коррумпированными супергероями в извращенном мире.', 'https://i.pinimg.com/736x/30/72/6d/30726dd11c0f4411f0e03219b1c0e5d6.jpg', 2019, 'США', 4.7, 60, '2019-07-26'),
('Один дома', 'Восьмилетний проказник должен защитить свой дом от двух грабителей, когда его случайно оставляют одного на время рождественских каникул.', 'https://i.pinimg.com/1200x/4e/27/8d/4e278d8db6710b3735140c5dcf4f3f71.jpg', 1990, 'США', 4.9, 103, '1990-12-16'),
('Паразиты', 'Бедная семья внедряется в жизнь богатой семьи, что приводит к неожиданным и мрачным последствиям.', 'https://i.pinimg.com/1200x/af/b7/bc/afb7bc6fa414a06b09a26cb0d191f3c9.jpg', 2019, 'Южная Корея', 4.8, 132, '2019-06-05'),
('Мистер и миссис Смит', 'Джон и Джейн поженились не так давно, но уже устали от брака. Оба они наёмные убийцы, которые тайно путешествуют по миру.', 'https://i.pinimg.com/736x/88/07/be/8807be4406dfea0f0e4320160ceba823.jpg', 2005, 'США', 4.5, 120, '2005-06-10'),
('Бойцовский клуб', 'Страдающий бессонницей мужчина встречает продавца мыла и попадает в подпольный клуб с опасной философией.', 'https://i.pinimg.com/736x/32/8b/49/328b495bafb788e467c87ebd3fbff05b.jpg', 1999, 'США', 4.9, 139, '1999-10-15');

INSERT INTO movie_genres (movie_id, genre_id) VALUES
(1, 1), (1, 2),
(2, 1), (2, 4),
(3, 3), (3, 6),
(4, 4), (4, 7),
(5, 2), (5, 5),
(6, 3), (6, 4),
(7, 5), (7, 9);

INSERT INTO bookings (user_id, movie_id, status_id, seats, seat_row, booking_date, session_date, total_price) VALUES
(1, 1, 3, 'A5,A6', 'A', NOW(), '2026-06-10 19:00:00', 700.00),
(1, 7, 2, 'C3,C4', 'C', NOW(), '2026-06-11 21:00:00', 700.00),
(3, 4, 1, 'B2', 'B', NOW(), '2026-06-12 15:00:00', 350.00);
