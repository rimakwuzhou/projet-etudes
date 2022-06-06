<?php

// A utiliser dans un 1er temps avant de passer en POO PHP

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=user_m;charset=utf8',
        'root',
        'root',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    echo json_encode(['error' => "Un problème est survenu lors de la connexion"]);
}
