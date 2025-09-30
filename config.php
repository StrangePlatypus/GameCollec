<?php

try{
    $dsn = "mysql:host=localhost;dbname=gaming_library;charset=utf8mb4";
    $username = "root";
    $password = "";

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    echo '<p style="display: none">Connexion réussie</p>';
}catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
};

?>