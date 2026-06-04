<?php
require_once __DIR__ . '/../../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
require_once ROOT_DIR . '/src/models/GenreModel.php';
requireAdmin();
$id = (int)($_GET['id'] ?? 0);
$movie = getMovieById($id);
if (!$movie) {
    setFlash('error', 'Фильм не найден.');
    redirect(adminUrl('movies/index.php'));
}
$genres = getAllGenres();
$selectedGenres = getMovieGenreIds($id);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie = array_merge($movie, [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'poster_url' => trim($_POST['poster_url'] ?? ''),
        'year' => (int)($_POST['year'] ?? 0),
        'country' => trim($_POST['country'] ?? ''),
        'rating' => (float)($_POST['rating'] ?? 0),
        'duration' => (int)($_POST['duration'] ?? 0),
        'release_date' => $_POST['release_date'] ?? null,
    ]);
    $selectedGenres = array_map('intval', $_POST['genres'] ?? []);

    if ($movie['title'] === '' || $movie['description'] === '' || $movie['poster_url'] === '') {
        $errors[] = 'Заполните обязательные поля.';
    }

    if (!$errors) {
        updateMovie($id, $movie, $selectedGenres);
        setFlash('success', 'Фильм обновлён.');
        redirect(adminUrl('movies/index.php'));
    }
}

$pageTitle = 'Редактировать фильм';
$activePage = 'admin';
$bodyClass = 'admin-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="admin-container">
    <div class="admin-header">
        <h1>Редактировать фильм</h1>
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
