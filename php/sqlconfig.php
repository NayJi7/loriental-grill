<?php 
    try
    {
        $mysqlClient = new PDO('mysql:host=localhost;dbname=loriental-grill;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {    
        die('Erreur : ' . $e->getMessage());
    }
?>