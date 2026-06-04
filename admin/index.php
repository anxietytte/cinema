<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
require_once ROOT_DIR . '/src/models/BookingModel.php';
requireAdmin();
$moviesCount = count(getAllMovies());
$bookingsCount = countBookings();
$pageTitle = 'Админ-панель';
$activePage = 'admin';
$bodyClass = 'admin-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ-панель</h1>
        <a class="btn-muted" href="<?= e(publicUrl('logout.php')) ?>">Выйти</a>
    </div>
    <div class="admin-grid">
        <a class="admin-tile" href="<?= e(adminUrl('movies/index.php')) ?>">
            <h3>Управление каталогом</h3>
            <p>Фильмов: <?= (int)$moviesCount ?></p>
        </a>
        <a class="admin-tile" href="<?= e(publicUrl('genres.php')) ?>">
            <h3>Категории</h3>
            <p>Просмотр жанров каталога</p>
        </a>
        <a class="admin-tile" href="<?= e(adminUrl('bookings.php')) ?>">
            <h3>Действия пользователей</h3>
            <p>Бронирований: <?= (int)$bookingsCount ?></p>
        </a>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
