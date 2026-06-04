<?php
$movie = $movie ?? ['title'=>'', 'description'=>'', 'poster_url'=>'', 'year'=>'', 'country'=>'', 'rating'=>'0', 'duration'=>'', 'release_date'=>''];
$selectedGenres = $selectedGenres ?? [];
?>
<div class="form-grid">
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="title" value="<?= e($movie['title']) ?>" required>
    </div>
    <div class="form-group">
        <label>Постер URL</label>
        <input type="url" name="poster_url" value="<?= e($movie['poster_url']) ?>" required>
    </div>
    <div class="form-group">
        <label>Год</label>
        <input type="number" name="year" value="<?= e((string)$movie['year']) ?>" required>
    </div>
    <div class="form-group">
        <label>Страна</label>
        <input type="text" name="country" value="<?= e($movie['country']) ?>" required>
    </div>
    <div class="form-group">
        <label>Рейтинг</label>
        <input type="number" step="0.1" min="0" max="10" name="rating" value="<?= e((string)$movie['rating']) ?>" required>
    </div>
    <div class="form-group">
        <label>Длительность</label>
        <input type="number" name="duration" value="<?= e((string)$movie['duration']) ?>" required>
    </div>
    <div class="form-group">
        <label>Дата выхода</label>
        <input type="date" name="release_date" value="<?= e($movie['release_date'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label>Жанры</label>
        <select name="genres[]" multiple size="5">
            <?php foreach ($genres as $genre): ?>
                <option value="<?= (int)$genre['id'] ?>" <?= in_array((int)$genre['id'], $selectedGenres, true) ? 'selected' : '' ?>><?= e($genre['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label>Описание</label>
    <textarea name="description" required><?= e($movie['description']) ?></textarea>
</div>
<button class="btn-main" type="submit">Сохранить</button>
