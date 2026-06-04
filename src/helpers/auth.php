<?php

function isAuth(): bool
{
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return isAuth() && ($_SESSION['role'] ?? '') === 'admin';
}

function requireAuth(): void
{
    if (!isAuth()) {
        setFlash('error', 'Войдите в аккаунт.');
        redirect(publicUrl('login.php'));
    }
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        setFlash('error', 'Доступ только для администратора.');
        redirect(publicUrl('login.php'));
    }
}

function loginUser(array $user): void
{
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
}

function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
