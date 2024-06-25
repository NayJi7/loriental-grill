<?php 
    session_start(); // Start session to manage user session
    // session_unset(); // Unset all session variables
    // session_destroy(); // Destroy the current session
    // exit(); // Stop the execution of the PHP script

    require_once(__DIR__."/sqlconfig.php"); // Include the database configuration file

    // Fetch all users from the database
    $userstatement = $mysqlClient->prepare('SELECT * FROM users');
    $userstatement->execute();
    $users = $userstatement->fetchAll();

    // Prepare and execute SQL statement to fetch likes of the current user
    $avisstatement = $mysqlClient->prepare('SELECT * FROM avis');
    $avisstatement->execute();
    $avis = $avisstatement->fetchAll();

    // Change the récupéré field to one if button clicked
    if (isset($_POST['id'])) {
        $updatestatement = $mysqlClient->prepare('UPDATE avis SET récupéré = 1 WHERE id = :id');
        $updatestatement->execute([
            'id' => $_POST['id'],
        ]);

        foreach ($avis as $avi) {
            if ($avi['id'] === $_POST['id']) {
                $userstatement = $mysqlClient->prepare('UPDATE users SET récupéré = 1 WHERE id = :id');
                $userstatement->execute([
                    'id' => $avi['user_id'],
                ]);
                break;
            }
        }
        header("Location: ../index.php"); // Account connexion 
    }

    $found = false;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>L'oriental Grill</title>
        <link rel="icon" href="../source/iconsite.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../style/getprize.css">
        <link rel="stylesheet" href="../style/header.css">
        <link rel="stylesheet" href="../style/footer.css">

        <!-- Site conçu pour être utilisé sur mobile -->
    </head>
    <body>
        <div class="error">
            <h1>Ce site ne fonctionne que sur mobile en orientation portrait, <br>changez de support ou tournez votre téléphone pour continuer</h1>
        </div>

        <?php require_once(__DIR__."/header.php") ?>
        <main>
            <video autoplay loop muted id="bgvideo">
                <source src="../source/video.mp4"> <!-- Background video -->
            </video>

                <div class="container">
                    <?php if(isset($_GET['id'])) :
                        foreach ($avis as $avi) :
                            $today = new DateTime();
                            $date = DateTime::createFromFormat('j/m/Y', $avi['recup']);
                            $expired = false;

                            if ($date <= $today) {
                                $expired = true;
                            } else {
                                $expired = false;
                            }

                            if($_GET['id'] === $avi['id'] && $expired): $found = true;?>
                                <h1><?php echo $avi['user_name'].', '.$avi['user_email'];?><br><?php echo'n\'a pas pu récupérer : '.$avi['prize'];?></h1>
                                <h2><?php echo 'id de commande : '.$avi['id'];?></h2>
                                <h2><mark><?php echo 'date limite dépassée : '.$avi['recup'];?></mark></h2>
                                <img src="../source/<?php echo $avi['prize'].'.png';?>" alt="prize">

                            <?php elseif($_GET['id'] === $avi['id'] && $avi['prize'] === "perdu"): $found = true;?>
                                <h1><?php echo $avi['user_name'].', '.$avi['user_email'];?><br><?php echo'a perdu';?></h1>
                                <h2><?php echo 'id de commande : '.$avi['id'];?></h2>
                                <img src="../source/<?php echo $avi['prize'].'.png';?>" alt="prize">

                            <?php elseif($_GET['id'] === $avi['id'] && $avi['récupéré'] === 0): $found = true;?>
                                <h1><?php echo $avi['user_name'].', '.$avi['user_email'];?><br><?php echo'a gagné : '.$avi['prize'];?></h1>
                                <h2><?php echo 'id de commande : '.$avi['id'];?></h2>
                                <h2><?php echo 'date limite : '.$avi['recup'];?></h2>
                                <img src="../source/<?php echo $avi['prize'].'.png';?>" alt="prize">
                                <form action="getprize.php" method="post">
                                    <button type="submit" name="id" value="<?php echo $avi['id'];?>">Valider</button>
                                </form>

                            <?php elseif($_GET['id'] === $avi['id'] && $avi['récupéré'] === 1): $found = true;?>
                                <h1><?php echo $avi['user_name'].', '.$avi['user_email'];?><br><?php echo'a déjà récupéré : '.$avi['prize'];?></h1>
                                <h2><?php echo 'id de commande : '.$avi['id'];?></h2>
                                <h2><?php echo 'date limite : '.$avi['recup'];?></h2>
                                <img src="../source/<?php echo $avi['prize'].'.png';?>" alt="prize">

                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>

                    <?php if(!isset($_GET['id']) || $found == false) :?>
                        <h1>Oups ... <br>Ce lien n'a pas l'air valide</h1>
                    <?php endif;?>
                </div>

        </main>
        <?php require_once(__DIR__."/footer.php") ?>

    </body>
</html>