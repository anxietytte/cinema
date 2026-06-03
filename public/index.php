<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/MovieModel.php';

$movies = getAllMovies();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог фильмов | Cinema Booking</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #0c0c0c;
            color: #ffffff;
            line-height: 1.4;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff, #cd3c3c);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .subtitle {
            color: #aaa;
            margin-bottom: 2rem;
        }
        
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .movie-card {
            background: #111111;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
            border: 1px solid #262626;
        }
        
        .movie-card:hover {
            transform: translateY(-5px);
            border-color: #cd3c3c;
        }
        
        .movie-poster {
            height: 350px;
            overflow: hidden;
        }
        
        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s;
        }
        
        .movie-card:hover .movie-poster img {
            transform: scale(1.05);
        }
        
        .movie-info {
            padding: 1.2rem;
        }
        
        .movie-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        
        .movie-year {
            font-size: 0.8rem;
            color: #cd3c3c;
            margin-bottom: 0.5rem;
        }
        
        .movie-rating {
            color: #ffb347;
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
        }
        
        .movie-description {
            font-size: 0.8rem;
            color: #aaa;
            line-height: 1.4;
        }
        
        footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid #1e1e1e;
            margin-top: 2rem;
            color: #666;
            font-size: 0.8rem;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            .movies-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Каталог фильмов</h1>
        <p class="subtitle">Выберите фильм для просмотра или бронирования</p>
        
        <div class="movies-grid">
            <?php if (empty($movies)): ?>
                <p>Фильмы не найдены. Проверьте базу данных.</p>
            <?php else: ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-card">
                        <div class="movie-poster">
                            <img src="<?php echo $movie['poster_url']; ?>" 
                                 alt="<?php echo $movie['title']; ?>"
                                 onerror="this.src='https://via.placeholder.com/300x400?text=No+Poster'">
                        </div>
                        <div class="movie-info">
                            <div class="movie-title"><?php echo $movie['title']; ?></div>
                            <div class="movie-year"><?php echo $movie['year']; ?> · <?php echo $movie['country']; ?></div>
                            <div class="movie-rating"> <?php echo $movie['rating']; ?></div>
                            <div class="movie-description">
                                <?php echo mb_substr($movie['description'], 0, 100); ?>...
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <footer>
        <p>2025 Cinema Booking - Все права защищены</p>
    </footer>
</body>
</html>
