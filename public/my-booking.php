<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/BookingModel.php';
requireAuth();
$bookings = getUserBookings((int)$_SESSION['user_id']);
$pageTitle = 'Мои бронирования';
$activePage = '';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="content-container">
    <div class="page-header">
        <h1>Мои бронирования</h1>
    </div>
    <?php if (!$bookings): ?>
        <div class="empty-state">Бронирований пока нет.</div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>ID</th><th>Фильм</th><th>Места</th><th>Сеанс</th><th>Сумма</th><th>Статус</th></tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= (int)$booking['id'] ?></td>
                        <td><?= e($booking['movie_title']) ?></td>
                        <td><?= e($booking['seats']) ?></td>
                        <td><?= e(date('d.m.Y H:i', strtotime($booking['session_date']))) ?></td>
                        <td><?= e(number_format((float)$booking['total_price'], 2, '.', ' ')) ?> ₽</td>
                        <td><span class="status-text"><?= e($booking['status_name']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
