<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/UserModel.php';
require_once ROOT_DIR . '/src/models/BookingModel.php';

requireAuth();
$user = findUserById((int)$_SESSION['user_id']);
$bookings = getUserBookings((int)$_SESSION['user_id']);
$pageTitle = 'Личный кабинет';
$activePage = '';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="profile-container">
    <div class="welcome-section">
        <h1>Личный кабинет</h1>
    </div>
    <div class="profile-grid">
        <div class="profile-left">
            <div class="card">
                <div class="card-header"><h3>Профиль</h3></div>
                <div class="user-info-row">
                    <div class="user-avatar-large"><?= e(mb_strtoupper(mb_substr($user['name'] ?? 'U', 0, 1))) ?></div>
                    <div>
                        <h4><?= e($user['name'] ?? '') ?></h4>
                        <p><?= e($user['email'] ?? '') ?></p>
                    </div>
                </div>
                <div class="info-line"><span>Имя</span><span><?= e($user['name'] ?? '') ?></span></div>
                <div class="info-line"><span>Email</span><span><?= e($user['email'] ?? '') ?></span></div>
                <div class="info-line"><span>Телефон</span><span><?= e($user['phone'] ?: 'не указан') ?></span></div>
                <div class="info-line"><span>Роль</span><span><?= e($user['role'] ?? '') ?></span></div>
                <div class="actions-row" style="margin-top:1rem;">
                    <a class="btn-main" href="<?= e(publicUrl('my-bookings.php')) ?>">Мои бронирования</a>
                    <a class="btn-muted" href="<?= e(publicUrl('movie.php')) ?>">В каталог</a>
                    <a class="btn-muted" href="<?= e(publicUrl('logout.php')) ?>">Выйти</a>
                </div>
            </div>
        </div>
        <div class="profile-right">
            <div class="card">
                <div class="card-header"><h3>Последние бронирования</h3></div>
                <?php if (!$bookings): ?>
                    <div class="empty-state">Бронирований пока нет.</div>
                <?php else: ?>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead><tr><th>Фильм</th><th>Места</th><th>Сеанс</th><th>Статус</th></tr></thead>
                            <tbody>
                            <?php foreach (array_slice($bookings, 0, 5) as $booking): ?>
                                <tr>
                                    <td><?= e($booking['movie_title']) ?></td>
                                    <td><?= e($booking['seats']) ?></td>
                                    <td><?= e(date('d.m.Y H:i', strtotime($booking['session_date']))) ?></td>
                                    <td><span class="status-text"><?= e($booking['status_name']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
