<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/GenreModel.php';
$genres = getGenresWithCounts();
$pageTitle = 'Жанры';
$activePage = 'genres';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="genres-container">
    <div class="genres-header">
        <h1>Жанры</h1>
        <p>Выбирайте фильмы по настроению</p>
    </div>
    <div class="genres-grid">
        <?php foreach ($genres as $genre): ?>
            <a class="genre-card" href="<?= e(publicUrl('movie.php?genre_id=' . (int)$genre['id'])) ?>">
                <h3><?= e($genre['name']) ?></h3>
                <p><?= e($genre['description']) ?></p>
                <span class="movie-count"><?= (int)$genre['movie_count'] ?> фильмов</span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
