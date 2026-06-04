<?php
require_once __DIR__ . '/../src/bootstrap.php';
$pageTitle = 'О проекте';
$activePage = 'about';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="about-container">
    <div class="about-header">
        <h1>О проекте</h1>
        <p>Cinema Booking — онлайн-сервис для выбора фильмов и бронирования мест</p>
    </div>

    <section class="about-section">
        <h2>Идея проекта</h2>
        <p>Сайт помогает быстро найти интересный фильм, посмотреть информацию о нём и оформить бронирование билетов. Пользователь работает с каталогом и личным кабинетом, а администратор управляет фильмами и заявками.</p>
    </section>

    <section class="about-section">
        <h2>Возможности</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Каталог</h3>
                <p>Поиск фильмов, фильтрация по жанрам и просмотр карточек.</p>
            </div>
            <div class="feature-card">
                <h3>Бронирование</h3>
                <p>Выбор даты сеанса и мест с сохранением заявки.</p>
            </div>
            <div class="feature-card">
                <h3>Личный кабинет</h3>
                <p>Профиль пользователя и список его бронирований.</p>
            </div>
            <div class="feature-card">
                <h3>Админ-панель</h3>
                <p>Управление фильмами, заявками и статусами.</p>
            </div>
        </div>
    </section>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
