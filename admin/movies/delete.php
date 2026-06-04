<?php
require_once __DIR__ . '/../../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteMovie((int)($_POST['id'] ?? 0));
    setFlash('success', 'Фильм удалён.');
}
redirect(adminUrl('movies/index.php'));
