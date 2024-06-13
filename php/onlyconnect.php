<?php 
    session_start(); // Start session to manage user session

    require_once(__DIR__."/sqlconfig.php"); // Include the database configuration file

    // Fetch all users from the database
    $userstatement = $mysqlClient->prepare('SELECT * FROM users');
    $userstatement->execute();
    $users = $userstatement->fetchAll();

    // Prepare and execute SQL statement to fetch likes of the current user
    $avistatement = $mysqlClient->prepare('SELECT * FROM avis');
    $avistatement->execute();
    $avis = $avistatement->fetchAll();

    $connected = false;
    $foundemail = false;

    if (isset($_POST['name']) && isset($_POST['email'])) {
        foreach ($users as $user) {
            if ($user['username'] == $_POST['name'] && $user['email'] == $_POST['email']) {
                $_SESSION['user'] = $user;
                $connected = true;
                header("Location: ../index.php"); // Account connexion 
                break;
            }
            else if ($user["email"] == $_POST["email"]) {
                $foundemail = true;
                header("Location: connexion.php?log=zxfvwll22_6a"); // email already in use
                break;
            }
        }

        if (!$connected && !$foundemail) {
            header("Location: connexion.php?log=zxfvwll22_6e"); // no  account found
        }
    }
?>