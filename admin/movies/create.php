<?php
require_once __DIR__ . '/../../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
require_once ROOT_DIR . '/src/models/GenreModel.php';
requireAdmin();
$genres = getAllGenres();
$errors = [];
$movie = ['title'=>'', 'description'=>'', 'poster_url'=>'', 'year'=>date('Y'), 'country'=>'', 'rating'=>'0', 'duration'=>'90', 'release_date'=>''];
$selectedGenres = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'poster_url' => trim($_POST['poster_url'] ?? ''),
        'year' => (int)($_POST['year'] ?? 0),
        'country' => trim($_POST['country'] ?? ''),
        'rating' => (float)($_POST['rating'] ?? 0),
        'duration' => (int)($_POST['duration'] ?? 0),
        'release_date' => $_POST['release_date'] ?? null,
    ];
    $selectedGenres = array_map('intval', $_POST['genres'] ?? []);

    if ($movie['title'] === '' || $movie['description'] === '' || $movie['poster_url'] === '') {
        $errors[] = 'Заполните обязательные поля.';
    }

    if (!$errors) {
        createMovie($movie, $selectedGenres);
        setFlash('success', 'Фильм добавлен.');
        redirect(adminUrl('movies/index.php'));
    }
}

$pageTitle = 'Добавить фильм';
$activePage = 'admin';
$bodyClass = 'admin-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="admin-container">
    <div class="admin-header">
        <h1>Добавить фильм</h1>
        <a class="btn-muted" href="<?= e(adminUrl('movies/index.php')) ?>">Назад</a>
    </div>
    <div class="admin-card">
        <?php foreach ($errors as $error): ?><div class="form-error"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post">
            <?php require __DIR__ . '/form.php'; ?>
        </form>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
