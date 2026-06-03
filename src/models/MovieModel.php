<?php

require_once __DIR__ . '/../config/database.php';

function getAllMovies() {
    global $pdo;
    
    try {
        $sql = "SELECT id, title, description, poster_url, year, country, rating, duration 
                FROM movie 
                ORDER BY rating DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $movies = $stmt->fetchAll();
        
        return $movies;
        
    } catch (PDOException $e) {
        echo "Ошибка запроса: " . $e->getMessage();
        return [];
    }
}

function getMovieById($id) {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM movie WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch();
        
    } catch (PDOException $e) {
        echo "Ошибка запроса: " . $e->getMessage();
        return null;
    }
}
