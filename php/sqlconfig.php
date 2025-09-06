<?php 
    // Configuration pour Docker avec variables d'environnement
    $db_host = $_ENV['DB_HOST'] ?? 'localhost';
    $db_name = $_ENV['DB_NAME'] ?? 'loriental-grill';
    $db_user = $_ENV['DB_USER'] ?? 'root';
    $db_password = $_ENV['DB_PASSWORD'] ?? '';
    
    try
    {
        $mysqlClient = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password);
    }
    catch (Exception $e)
    {    
        die('Erreur : ' . $e->getMessage());
    }
?>