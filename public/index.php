<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';

$heroMovie = getMovieById(1);
$movies = getAllMovies(null, null, 3);
$pageTitle = 'Главная страница';
$activePage = 'home';
$bodyClass = '';
require ROOT_DIR . '/src/views/header.php';
?>
<section class="hero">
    <div class="hero-content">
        <div class="movie-badge">СЕЙЧАС В КИНО</div>
        <h1 class="movie-title"><?= e($heroMovie['title'] ?? 'КРИК') ?></h1>
        <div class="movie-number"><?= e($heroMovie ? (($heroMovie['year'] ?? '') . ' | ' . ($heroMovie['rating'] ?? '')) : '7') ?></div>
        <p class="description"><?= e($heroMovie['description'] ?? 'Когда убийца с Призрачным лицом появляется в тихом городке, где Сидни Прескотт построила новую жизнь, сбываются ее самые мрачные опасения.') ?></p>
        <div class="button-group">
            <a class="btn-watch" href="<?= e(publicUrl('movie.php?id=' . (int)($heroMovie['id'] ?? 1))) ?>">СМОТРЕТЬ СЕЙЧАС</a>
            <div class="in-theaters">
                <strong>В кинотеатрах</strong><br>
                <?= e($heroMovie && $heroMovie['release_date'] ? date('d.m.Y', strtotime($heroMovie['release_date'])) : 'с 23 мая') ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <h2 class="section-title">Сейчас в кинотеатрах</h2>
    <div class="movies-grid" id="moviesGrid">
        <?php foreach ($movies as $movie): ?>
            <a class="movie-card" href="<?= e(publicUrl('movie.php?id=' . (int)$movie['id'])) ?>">
                <div class="movie-card-img">
                    <img src="<?= e($movie['poster_url']) ?>" alt="<?= e($movie['title']) ?>">
                </div>
                <div class="movie-card-info">
                    <h4><?= e($movie['title']) ?></h4>
                    <p><?= e(excerpt($movie['description'], 110)) ?></p>
                    <p style="margin-top: 8px; color:#cd3c3c;"><?= e($movie['year']) ?> | <?= e($movie['country']) ?> | <?= e($movie['rating']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <div class="info-row">
        <div class="info-block">
            <h4>о проекте</h4>
            <p>«Cinema Booking» — платформа для выбора фильмов, просмотра афиши и онлайн-бронирования мест.</p>
        </div>
        <div class="info-block">
            <h4>контакты</h4>
            <p>Адрес: ул. Кино, 13<br>Email: support@cinemabooking.com<br>Телефон: +7 (999) 123-45-67</p>
        </div>
        <div class="info-block">
            <h4>бронирование</h4>
            <p>Выбирайте фильм, дату сеанса и места. Все бронирования сохраняются в личном кабинете.</p>
            <a href="<?= e(publicUrl('movie.php')) ?>" style="display: inline-block; margin-top: 8px; color: #cd3c3c;">Забронировать →</a>
        </div>
    </div>
</section>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
