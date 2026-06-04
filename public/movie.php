<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
require_once ROOT_DIR . '/src/models/GenreModel.php';

$movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$genres = getAllGenres();
$pageTitle = $movieId ? 'Фильм' : 'Фильмы';
$activePage = 'movies';
$bodyClass = 'catalog-page';

if ($movieId) {
    $movie = getMovieById($movieId);
    require ROOT_DIR . '/src/views/header.php';
    if (!$movie): ?>
        <div class="content-container"><div class="empty-state">Фильм не найден.</div></div>
    <?php else: ?>
        <section class="detail-layout">
            <div class="detail-poster">
                <img src="<?= e($movie['poster_url']) ?>" alt="<?= e($movie['title']) ?>">
            </div>
            <div class="detail-card">
                <h1><?= e($movie['title']) ?></h1>
                <div class="meta-line"><?= e($movie['year']) ?> | <?= e($movie['country']) ?> | <?= e($movie['duration']) ?> мин | <?= e($movie['rating']) ?></div>
                <?php if (!empty($movie['genres'])): ?>
                    <div class="genre-list">Жанры: <?= e($movie['genres']) ?></div>
                <?php endif; ?>
                <p class="description"><?= e($movie['description']) ?></p>

                <form class="booking-form ajax-booking-form" method="post" action="<?= e(publicUrl('api/book.php')) ?>">
                    <h2>Бронирование мест</h2>
                    <input type="hidden" name="movie_id" value="<?= (int)$movie['id'] ?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Дата и время сеанса</label>
                            <input type="datetime-local" name="session_date" required>
                        </div>
                        <div class="form-group">
                            <label>Места</label>
                            <input type="text" name="seats" placeholder="Например: A5,A6" required>
                        </div>
                    </div>
                    <button class="btn-book" type="submit">Забронировать</button>
                    <div class="form-message" data-form-message></div>
                </form>
            </div>
        </section>
    <?php endif;
    require ROOT_DIR . '/src/views/footer.php';
    exit;
}

$q = trim($_GET['q'] ?? '');
$genreId = isset($_GET['genre_id']) ? (int)$_GET['genre_id'] : 0;
$movies = getAllMovies($q ?: null, $genreId ?: null);
require ROOT_DIR . '/src/views/header.php';
?>
<section class="movies-header">
    <h1>Movies</h1>
    <p>Выберите фильм и забронируйте места</p>
</section>

<section class="movies-container">
    <form class="catalog-tools" id="catalogFilter" action="movie.php" method="get">
        <input type="text" id="catalogSearch" name="q" value="<?= e($q) ?>" placeholder="Поиск по названию, стране или жанру">
        <select id="genreFilter" name="genre_id">
            <option value="0">Все жанры</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= (int)$genre['id'] ?>" <?= $genreId === (int)$genre['id'] ? 'selected' : '' ?>><?= e($genre['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn-main" type="submit">Найти</button>
    </form>

    <div id="catalogCount" style="margin-bottom: 1rem;">Найдено: <?= count($movies) ?></div>
    <div class="movies-grid-page" id="catalogGrid">
        <?php foreach ($movies as $movie): ?>
            <?php require ROOT_DIR . '/src/views/movie-card.php'; ?>
        <?php endforeach; ?>
        <?php if (!$movies): ?>
            <div class="empty-state">Фильмы не найдены.</div>
        <?php endif; ?>
    </div>
</section>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
