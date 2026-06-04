<?php

function getAllMovies(?string $search = null, ?int $genreId = null, int $limit = 0): array
{
    global $pdo;
    $params = [];
    $sql = "SELECT m.*, GROUP_CONCAT(g.name ORDER BY g.name SEPARATOR ', ') AS genres
            FROM movie m
            LEFT JOIN movie_genres mg ON mg.movie_id = m.id
            LEFT JOIN genres g ON g.id = mg.genre_id";
    $where = [];

    if ($search !== null && trim($search) !== '') {
        $where[] = "(m.title LIKE :search OR m.country LIKE :search OR m.description LIKE :search OR g.name LIKE :search)";
        $params['search'] = '%' . trim($search) . '%';
    }

    if ($genreId) {
        $where[] = "EXISTS (SELECT 1 FROM movie_genres mg2 WHERE mg2.movie_id = m.id AND mg2.genre_id = :genre_id)";
        $params['genre_id'] = $genreId;
    }

    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $sql .= ' GROUP BY m.id ORDER BY m.rating DESC, m.year DESC';

    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int)$limit;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getMovieById(int $id): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT m.*, GROUP_CONCAT(g.name ORDER BY g.name SEPARATOR ', ') AS genres
                           FROM movie m
                           LEFT JOIN movie_genres mg ON mg.movie_id = m.id
                           LEFT JOIN genres g ON g.id = mg.genre_id
                           WHERE m.id = ?
                           GROUP BY m.id");
    $stmt->execute([$id]);
    $movie = $stmt->fetch();
    return $movie ?: null;
}

function createMovie(array $data, array $genreIds): int
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO movie (title, description, poster_url, year, country, rating, duration, release_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $data['title'],
        $data['description'],
        $data['poster_url'],
        $data['year'],
        $data['country'],
        $data['rating'],
        $data['duration'],
        $data['release_date'] ?: null,
    ]);
    $id = (int)$pdo->lastInsertId();
    syncMovieGenres($id, $genreIds);
    return $id;
}

function updateMovie(int $id, array $data, array $genreIds): void
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE movie SET title = ?, description = ?, poster_url = ?, year = ?, country = ?, rating = ?, duration = ?, release_date = ? WHERE id = ?');
    $stmt->execute([
        $data['title'],
        $data['description'],
        $data['poster_url'],
        $data['year'],
        $data['country'],
        $data['rating'],
        $data['duration'],
        $data['release_date'] ?: null,
        $id,
    ]);
    syncMovieGenres($id, $genreIds);
}

function deleteMovie(int $id): void
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM movie WHERE id = ?');
    $stmt->execute([$id]);
}

function syncMovieGenres(int $movieId, array $genreIds): void
{
    global $pdo;
    $pdo->prepare('DELETE FROM movie_genres WHERE movie_id = ?')->execute([$movieId]);
    if (!$genreIds) {
        return;
    }
    $stmt = $pdo->prepare('INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)');
    foreach ($genreIds as $genreId) {
        $genreId = (int)$genreId;
        if ($genreId > 0) {
            $stmt->execute([$movieId, $genreId]);
        }
    }
}

function getMovieGenreIds(int $movieId): array
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT genre_id FROM movie_genres WHERE movie_id = ?');
    $stmt->execute([$movieId]);
    return array_map('intval', array_column($stmt->fetchAll(), 'genre_id'));
}
