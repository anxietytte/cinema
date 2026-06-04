<?php

function getAllGenres(): array
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM genres ORDER BY name');
    return $stmt->fetchAll();
}

function getGenresWithCounts(): array
{
    global $pdo;
    $stmt = $pdo->query('SELECT g.*, COUNT(mg.movie_id) AS movie_count
                         FROM genres g
                         LEFT JOIN movie_genres mg ON mg.genre_id = g.id
                         GROUP BY g.id
                         ORDER BY g.name');
    return $stmt->fetchAll();
}
