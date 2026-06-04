<?php

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function getFlashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function excerpt(?string $text, int $length = 120): string
{
    $text = trim((string)$text);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

function currentScriptInAdmin(): bool
{
    return str_contains(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''), '/admin/');
}

function baseUrl(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    foreach (['/public/', '/admin/'] as $marker) {
        $pos = strpos($script, $marker);
        if ($pos !== false) {
            return substr($script, 0, $pos + 1);
        }
    }
    return rtrim(dirname($script), '/\\') . '/';
}

function publicUrl(string $path = ''): string
{
    return baseUrl() . 'public/' . ltrim($path, '/');
}

function adminUrl(string $path = ''): string
{
    return baseUrl() . 'admin/' . ltrim($path, '/');
}
