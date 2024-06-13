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
    $arecupstatement = $mysqlClient->prepare('SELECT * FROM avis WHERE récupéré = 0');
    $arecupstatement->execute();
    $avisarecup = $arecupstatement->fetchAll();

    $dejarecupstatement = $mysqlClient->prepare('SELECT * FROM avis WHERE récupéré = 1');
    $dejarecupstatement->execute();
    $avisdejarecup = $dejarecupstatement->fetchAll();
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

        <link rel="stylesheet" href="../style/admin.css">
        <link rel="stylesheet" href="../style/header.css">
        <link rel="stylesheet" href="../style/footer.css">

        <!-- Site conçu pour être utilisé sur mobile -->
    </head>
    <body>
        <?php require_once(__DIR__."/header.php") ?>
        <main>
            <video autoplay loop muted id="bgvideo">
                <source src="../source/video.mp4"> <!-- Background video -->
            </video>

                <div class="container admin">
                    <h1>Mode Administrateur</h1>
                    <button class="adminbtn arecup">À récupérer</button>
                    <button class="adminbtn dejarecup">Déjà récupéré</button>
                    <button class="adminbtn users">Utilisateurs</button>
                </div>

                <div class="container arecup">
                    <button class="backbtn arecup"><img src="../source/cross.png" alt="cross"></button>

                    <form action="admin.php" method="get">
                        <input id="search" type="search" name="search" placeholder="Rechercher">
                    </form>

                    <div class="list">
                        <?php foreach( $avisarecup as $avis ): ?>
                            <div class="single">
                                
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>

                <div class="container dejarecup">
                    <button class="backbtn dejarecup"><img src="../source/cross.png" alt="cross"></button>
                </div>

                <div class="container users">
                    <button class="backbtn users"><img src="../source/cross.png" alt="cross"></button>
                </div>

        </main>
        <?php require_once(__DIR__."/footer.php") ?>

        <script>
            const containerarecup = document.querySelector(".container.arecup")
            const containerdejarecup = document.querySelector(".container.dejarecup")
            const containerusers = document.querySelector(".container.users")
            const btnarecup = document.querySelector(".adminbtn.arecup")
            const btndejarecup = document.querySelector(".adminbtn.dejarecup")
            const btnusers = document.querySelector(".adminbtn.users")

            const backbtnarecup = document.querySelector(".backbtn.arecup")
            const backbtndejarecup = document.querySelector(".backbtn.dejarecup")
            const backbtnusers = document.querySelector(".backbtn.users")

            btnarecup.addEventListener("click", ()=>{
                containerarecup.style.transform  = "translateY(0)"
            })

            btndejarecup.addEventListener("click", ()=>{
                containerdejarecup.style.transform  = "translateX(0)"
            })

            btnusers.addEventListener("click", ()=>{
                containerusers.style.transform  = "translateX(0)"
            })


            backbtnarecup.addEventListener("click", ()=>{
                containerarecup.style.transform  = "translateY(-150%)"
            })

            backbtndejarecup.addEventListener("click", ()=>{
                containerdejarecup.style.transform  = "translateX(150%)"
            })

            backbtnusers.addEventListener("click", ()=>{
                containerusers.style.transform  = "translateX(-150%)"
            })
            
        </script>
    </body>
</html>