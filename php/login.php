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

    function getIp(): string
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { // Support Cloudflare
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) === true) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if (preg_match('/^(?:127|10)\.0\.0\.[12]?\d{1,2}$/', $ip)) {
                if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                    $ip = $_SERVER['HTTP_X_REAL_IP'];
                } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
        } else {
            $ip = '127.0.0.1';
        }
        if (in_array($ip, ['::1', '0.0.0.0', 'localhost'], true)) {
            $ip = '127.0.0.1';
        }
        $filter = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if ($filter === false) {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    $connected = false;
    $foundemail = false;

    if (isset($_POST['name']) && isset($_POST['email'])) {
        foreach ($users as $user) {
            if ($user['username'] == $_POST['name'] && $user['email'] == $_POST['email']) {
                $_SESSION['user'] = $user;
                $connected = true;
                header("Location: connexion.php?log=zxfvwll22_6x"); // Account already exist
                break;
            }
            else if ($user["email"] == $_POST["email"]) {
                $foundemail = true;
                header("Location: connexion.php?log=zxfvwll22_6a"); // email already in use
                break;
            }
        }

        if (!$connected && !$foundemail) {
            if ($_POST['name'] == '' && $_POST['email'] == '') {
                header("Location: connexion.php?log=zxfvwll22_6b"); // Invalid inputs
            }
            else {
                $createaccount = $mysqlClient->prepare('INSERT INTO users(username, email, ip) VALUES (:username, :email, :ip)');
                $createaccount->execute([
                    'username'=> $_POST['name'],
                    'email'=> $_POST['email'],
                    'ip'=> getIp(),
                ]);

                $_SESSION['user'] = [
                    'username'=> $_POST['name'],
                    'email'=> $_POST['email'],
                    'ip'=> getIp(),
                    'haswon'=> 0,
                ];
                $connected = true;
                header("Location: connexion.php?log=zxfvwll22_6x"); // Account already exist       
                  
                $connected = true;
                header("Location: ../index.php?yes=yes"); // Account creation + connexion 
            }
        }
    }
?>