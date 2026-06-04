<?php
require_once __DIR__ . '/../../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/MovieModel.php';
requireAdmin();
$movies = getAllMovies();
$pageTitle = 'Фильмы';
$activePage = 'admin';
$bodyClass = 'admin-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="admin-container">
    <div class="admin-header">
        <h1>Фильмы</h1>
        <div class="actions-row">
            <a class="btn-muted" href="<?= e(adminUrl('index.php')) ?>">Назад</a>
            <a class="btn-main" href="<?= e(adminUrl('movies/create.php')) ?>">Добавить фильм</a>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>ID</th><th>Постер</th><th>Название</th><th>Год</th><th>Страна</th><th>Рейтинг</th><th>Действия</th></tr></thead>
            <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= (int)$movie['id'] ?></td>
                    <td><img src="<?= e($movie['poster_url']) ?>" alt="" style="width:55px;height:75px;object-fit:cover;border-radius:8px;"></td>
                    <td><?= e($movie['title']) ?></td>
                    <td><?= e($movie['year']) ?></td>
                    <td><?= e($movie['country']) ?></td>
                    <td><?= e($movie['rating']) ?></td>
                    <td>
                        <div class="actions-row">
                            <a class="btn-muted" href="<?= e(adminUrl('movies/edit.php?id=' . (int)$movie['id'])) ?>">Редактировать</a>
                            <form class="inline-form" method="post" action="<?= e(adminUrl('movies/delete.php')) ?>" onsubmit="return confirm('Удалить фильм?');">
                                <input type="hidden" name="id" value="<?= (int)$movie['id'] ?>">
                                <button class="btn-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
