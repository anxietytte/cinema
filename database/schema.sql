-- БАЗА ДАННЫХ "CINEMA BOOKING"

-- Создание бд
CREATE DATABASE IF NOT EXISTS cinema_booking
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cinema_booking;

-- 1. Таблица пользователей (users)

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID пользователя',
    email VARCHAR(100) NOT NULL UNIQUE COMMENT 'Email для входа',
    password VARCHAR(255) NOT NULL COMMENT 'Хэш пароля',
    name VARCHAR(100) NOT NULL COMMENT 'Имя пользователя',
    phone VARCHAR(20) COMMENT 'Номер телефона',
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации',
    avatar TEXT COMMENT 'URL аватара',
    is_active BOOLEAN DEFAULT TRUE COMMENT 'Активен ли аккаунт',
    
    INDEX idx_email (email),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Таблица жанров (genres) - категории

DROP TABLE IF EXISTS genres;
CREATE TABLE genres (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID жанра',
    name VARCHAR(50) NOT NULL UNIQUE COMMENT 'Название жанра',
    description TEXT COMMENT 'Описание жанра',
    icon VARCHAR(10) COMMENT 'Emoji иконка',
    color VARCHAR(20) COMMENT 'Цвет для оформления',
    
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Таблица фильмов (movie) - основная сущность

DROP TABLE IF EXISTS movie;
CREATE TABLE movie (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID фильма',
    title VARCHAR(200) NOT NULL COMMENT 'Название фильма',
    description TEXT COMMENT 'Описание сюжета',
    poster_url TEXT COMMENT 'Ссылка на постер',
    year INT COMMENT 'Год выпуска',
    country VARCHAR(100) COMMENT 'Страна-производитель',
    rating DECIMAL(3,1) DEFAULT 0 COMMENT 'Рейтинг от 0 до 10',
    duration INT COMMENT 'Длительность в минутах',
    release_date DATE COMMENT 'Дата выхода в прокат',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_title (title),
    INDEX idx_year (year),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Таблица связи фильмов и жанров (movie_genres)

DROP TABLE IF EXISTS movie_genres;
CREATE TABLE movie_genres (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID связи',
    movie_id INT NOT NULL COMMENT 'ID фильма',
    genre_id INT NOT NULL COMMENT 'ID жанра',
    
    FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_movie_genre (movie_id, genre_id),
    INDEX idx_movie_id (movie_id),
    INDEX idx_genre_id (genre_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Таблица статусов (statuses)

DROP TABLE IF EXISTS statuses;
CREATE TABLE statuses (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID статуса',
    name VARCHAR(50) NOT NULL UNIQUE COMMENT 'Название статуса',
    code VARCHAR(30) NOT NULL UNIQUE COMMENT 'Код статуса для системы',
    description TEXT COMMENT 'Описание статуса',
    sort_order INT DEFAULT 0 COMMENT 'Порядок сортировки',
    color VARCHAR(20) COMMENT 'Цвет для оформления',
    
    INDEX idx_code (code),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Таблица бронирований (bookings) - операционная сущность

DROP TABLE IF EXISTS bookings;
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT 'Уникальный ID брони',
    user_id INT NOT NULL COMMENT 'ID пользователя',
    movie_id INT NOT NULL COMMENT 'ID фильма',
    status_id INT NOT NULL COMMENT 'ID статуса бронирования',
    seats VARCHAR(100) NOT NULL COMMENT 'Номера мест (A5,A6)',
    seat_row VARCHAR(10) COMMENT 'Ряд',
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата бронирования',
    session_date DATETIME NOT NULL COMMENT 'Дата и время сеанса',
    total_price DECIMAL(10,2) DEFAULT 0 COMMENT 'Общая стоимость',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES statuses(id) ON DELETE RESTRICT,
    
    INDEX idx_user_id (user_id),
    INDEX idx_movie_id (movie_id),
    INDEX idx_status_id (status_id),
    INDEX idx_session_date (session_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SHOW TABLES;
