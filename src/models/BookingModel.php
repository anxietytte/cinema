<?php

function createBooking(int $userId, int $movieId, string $seats, string $sessionDate): int
{
    global $pdo;
    $seatList = array_filter(array_map('trim', explode(',', $seats)));
    $seatRow = $seatList ? mb_substr($seatList[0], 0, 1) : '';
    $price = max(count($seatList), 1) * 350;

    $stmt = $pdo->prepare('INSERT INTO bookings (user_id, movie_id, status_id, seats, seat_row, session_date, total_price) VALUES (?, ?, 1, ?, ?, ?, ?)');
    $stmt->execute([$userId, $movieId, implode(', ', $seatList), $seatRow, $sessionDate, $price]);
    return (int)$pdo->lastInsertId();
}

function getUserBookings(int $userId): array
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT b.*, m.title AS movie_title, s.name AS status_name, s.code AS status_code, s.color AS status_color
                           FROM bookings b
                           JOIN movie m ON m.id = b.movie_id
                           JOIN statuses s ON s.id = b.status_id
                           WHERE b.user_id = ?
                           ORDER BY b.created_at DESC');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getAllBookings(): array
{
    global $pdo;
    $stmt = $pdo->query('SELECT b.*, u.name AS user_name, u.email AS user_email, m.title AS movie_title, s.name AS status_name, s.color AS status_color
                         FROM bookings b
                         JOIN users u ON u.id = b.user_id
                         JOIN movie m ON m.id = b.movie_id
                         JOIN statuses s ON s.id = b.status_id
                         ORDER BY b.created_at DESC');
    return $stmt->fetchAll();
}

function getStatuses(): array
{
    global $pdo;
    return $pdo->query('SELECT * FROM statuses ORDER BY sort_order')->fetchAll();
}

function updateBookingStatus(int $bookingId, int $statusId): bool
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE bookings SET status_id = ? WHERE id = ?');
    $stmt->execute([$statusId, $bookingId]);
    return $stmt->rowCount() > 0;
}

function countBookings(): int
{
    global $pdo;
    return (int)$pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
}
