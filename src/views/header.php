<?php
$activePage = $activePage ?? '';
$pageTitle = $pageTitle ?? 'Cinema Booking';
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= e($pageTitle) ?> | Cinema Booking</title>
    <link rel="stylesheet" href="<?= e(publicUrl('assets/css/style.css')) ?>">
</head>
<body class="<?= e($bodyClass) ?>">
<div class="page">
<header>
    <div class="navbar">
        <a href="<?= e(publicUrl('index.php')) ?>" class="logo">Cinema Booking</a>
        <nav class="nav-links">
            <a class="<?= $activePage === 'movies' ? 'active' : '' ?>" href="<?= e(publicUrl('movie.php')) ?>">фильмы</a>
            <a class="<?= $activePage === 'genres' ? 'active' : '' ?>" href="<?= e(publicUrl('genres.php')) ?>">жанры</a>
            <a class="<?= $activePage === 'about' ? 'active' : '' ?>" href="<?= e(publicUrl('about.php')) ?>">о проекте</a>
            <a class="<?= $activePage === 'contacts' ? 'active' : '' ?>" href="<?= e(publicUrl('contacts.php')) ?>">контакты</a>
            <?php if (isAdmin()): ?>
                <a class="<?= $activePage === 'admin' ? 'active' : '' ?>" href="<?= e(adminUrl('index.php')) ?>">админ</a>
            <?php endif; ?>
        </nav>
        <form class="search-wrapper" action="<?= e(publicUrl('movie.php')) ?>" method="get">
            <input type="text" class="search-input" name="q" placeholder="Поиск" value="<?= e($_GET['q'] ?? '') ?>">
        </form>
        <?php if (isAuth()): ?>
            <a href="<?= e(publicUrl('profile.php')) ?>" class="account-icon" id="accountBtn">
                <span class="user-name"><?= e($_SESSION['user_name'] ?? 'Аккаунт') ?></span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </a>
        <?php else: ?>
            <a href="<?= e(publicUrl('login.php')) ?>" class="account-icon" id="accountBtn">
                <span class="user-name">Аккаунт</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</header>
<main class="site-main">
    <?php foreach (getFlashes() as $flash): ?>
        <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endforeach; ?>
