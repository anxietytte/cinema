<?php

function findUserByEmail(string $email): ?array
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function findUserById(int $id): ?array
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function emailExists(string $email): bool
{
    return findUserByEmail($email) !== null;
}

function createUser(string $name, string $email, string $password, string $phone = ''): int
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, phone, role, created_at, registered_at, is_active) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 1)');
    $stmt->execute([
        $name,
        $email,
        password_hash($password, PASSWORD_DEFAULT),
        $phone,
        'user',
    ]);
    return (int)$pdo->lastInsertId();
}
