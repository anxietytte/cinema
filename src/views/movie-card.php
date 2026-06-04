<a class="movie-card-page" href="<?= e(publicUrl('movie.php?id=' . (int)$movie['id'])) ?>">
    <div class="movie-img">
        <img src="<?= e($movie['poster_url']) ?>" alt="<?= e($movie['title']) ?>">
    </div>
    <div class="movie-info-page">
        <h3><?= e($movie['title']) ?></h3>
        <div class="movie-age"><?= e($movie['year']) ?> | <?= e($movie['country']) ?> | <?= e($movie['rating']) ?></div>
        <p class="movie-synopsis"><?= e(excerpt($movie['description'], 115)) ?></p>
        <span class="btn-book">Подробнее</span>
    </div>
</a>
