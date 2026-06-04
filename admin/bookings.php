<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/BookingModel.php';
requireAdmin();
$bookings = getAllBookings();
$statuses = getStatuses();
$pageTitle = 'Бронирования';
$activePage = 'admin';
$bodyClass = 'admin-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="admin-container">
    <div class="admin-header">
        <h1>Бронирования</h1>
        <a class="btn-muted" href="<?= e(adminUrl('index.php')) ?>">Назад</a>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr><th>ID</th><th>Пользователь</th><th>Фильм</th><th>Места</th><th>Сеанс</th><th>Сумма</th><th>Статус</th></tr>
            </thead>
            <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr data-booking-row="<?= (int)$booking['id'] ?>">
                    <td><?= (int)$booking['id'] ?></td>
                    <td><?= e($booking['user_name']) ?><br><small><?= e($booking['user_email']) ?></small></td>
                    <td><?= e($booking['movie_title']) ?></td>
                    <td><?= e($booking['seats']) ?></td>
                    <td><?= e(date('d.m.Y H:i', strtotime($booking['session_date']))) ?></td>
                    <td><?= e(number_format((float)$booking['total_price'], 2, '.', ' ')) ?> ₽</td>
                    <td>
                        <select class="ajax-status-select" data-booking-id="<?= (int)$booking['id'] ?>">
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= (int)$status['id'] ?>" <?= (int)$status['id'] === (int)$booking['status_id'] ? 'selected' : '' ?>><?= e($status['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
