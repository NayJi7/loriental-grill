<?php 
    session_start(); // Start session to manage user session
    //session_unset(); // Unset all session variables
    //session_destroy(); // Destroy the current session
    //exit(); // Stop the execution of the PHP script

    require_once(__DIR__."/php/sqlconfig.php"); // Include the database configuration file

    $avistatement = $mysqlClient->prepare('SELECT * FROM avis');
    $avistatement->execute();
    $avis = $avistatement->fetchAll();

    $useravis = NULL;
    if (isset($_SESSION['user'])) {
        foreach ($avis as $avi) {
            if ($_SESSION['user']['id'] == $avi['user_id']) {
                $useravis = $avi;
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>L'oriental Grill</title>
        <link rel="icon" href="source/iconsite.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="style/wheel.css">
        <link rel="stylesheet" href="style/header.css">
        <link rel="stylesheet" href="style/footer.css">

        <script type="text/javascript" src="script/wheel.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

        <!-- Site conçu pour être utilisé sur mobile -->
    </head>
    <body>
        <?php require_once(__DIR__."/php/headerext.php"); ?>
        <main>

            <?php if(isset($_SESSION['user']) && $_SESSION['user']['haswon'] == 1): ?>
                <div class="layer">
                    <?php if($_SESSION['user']['prize'] == "rien"): ?>
                    <div class="box">
                        <h1>Dommage !</h1>    
                    </div>

                    <?php elseif($_SESSION['user']['prize'] == "frites"): ?>
                    <div class="box">
                        <h1>Bravo ! Tu as gagné une portion de frites</h1> 
                        <h2>Récupère ton cadeau dans ton restaurant préféré avant le</h2>
                        <img src="../source/frites.png" alt="frites">   
                    </div>
                    <img src="../source/confettis.gif" alt="confettis">

                    <?php endif;?>
                </div>
            <?php endif; ?>
            
            <!-- Utilisateur non connecté -->
            <?php if (!isset($_SESSION["user"])): ?>
                <h1>Joue avec 3ami Farid et tente <br> de gagner un cadeau !</h1>

                <div class="wheelcontainer">
                    <img class="wheel" src="source/wheel.png" alt="wheel">
                    <img src="source/3ami.png" alt="pointer">
                </div>
                
                <a href="./php/connexion.php" class="wheelbtn login">Lancer la roue</a>
                <!-- redirect pour se connecter -->

            <!-- Utilisateur connecté n'ayant pas joué -->
            <?php elseif(isset($_SESSION["user"]) && $_SESSION['user']['haswon']==0): ?>

                <h1>Joue avec 3ami Farid et tente <br> de gagner un cadeau !</h1>

                <div class="wheelcontainer">
                    <img class="wheel" src="source/wheel.png" alt="wheel">
                    <img src="source/3ami.png" alt="pointer">
                </div>
                
                <button class="wheelbtn go">Lancer la roue</button>

            <!-- Utilisateur connecté ayant joué-->
            <?php elseif(isset($_SESSION["user"]) && $_SESSION['user']['haswon']==1): ?>
                <h1>Joue avec 3ami Farid et tente <br> de gagner un cadeau !</h1>

                <div class="wheelcontainer">
                    <img class="wheel" src="source/wheel.png" alt="wheel">
                    <img src="source/3ami.png" alt="pointer">
                </div>
                
                <a href="./php/connexion.php" class="wheelbtn login">Lancer la roue</a>
            <?php endif; ?>
        </main>
        <?php require_once(__DIR__."/php/footerext.php"); ?>
    </body>
</html>
