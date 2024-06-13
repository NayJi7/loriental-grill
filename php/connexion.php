<?php 
    session_start(); // Start session to manage user session
    // session_unset(); // Unset all session variables
    // session_destroy(); // Destroy the current session
    // exit(); // Stop the execution of the PHP script
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

        <link rel="stylesheet" href="../style/connexion.css">
        <link rel="stylesheet" href="../style/header.css">
        <link rel="stylesheet" href="../style/footer.css">

        <script type="text/javascript" src="script/wheel.js"></script>

        <!-- Site conçu pour être utilisé sur mobile -->
    </head>
    <body>
        <?php require_once(__DIR__."/header.php") ?>
        <main>
            <video autoplay loop muted id="bgvideo">
                <source src="../source/video.mp4"> <!-- Background video -->
            </video>

                <div class="container avis">
                    
                    <?php if(!isset($_SESSION['user'])): ?>
                    <h1>Donne ton avis pour pouvoir tourner la roue !</h1>
                        <a id="avis3" target="_blank" href="https://search.google.com/local/writereview?placeid=ChIJ7wuFy3pp5kcR_E_MT96550Q"><img src="../source/avis.png" alt="avis"></a>
                    <?php else: ?>
                    <h1>Encore merci pour l'avis que <br> tu as posté !</h1>
                    <form id="avis2" action="connexion.php" method="get">
                            <button type="submit"><img src="../source/avis.png" alt="avis"></button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="container wait">
                    <h1>Avis en cours de vérification ...</h1>
                    <h2>(On vous voit les tricheurs, allez mettre un avis.)</h2>
                    <?php if(!isset($_SESSION['user'])): ?>
                        <a id="avis" target="_blank" href="https://search.google.com/local/writereview?placeid=ChIJ7wuFy3pp5kcR_E_MT96550Q"><img src="../source/avis.png" alt="avis"></a>
                    <?php else: ?>
                        <form id="avis2" action="connexion.php" method="get">
                            <button type="submit"><img src="../source/avis.png" alt="avis"></button>
                        </form>
                    <?php endif; ?>
                </div>

                <script>

                    const containeravis = document.querySelector(".container.avis")
                    const containerwait = document.querySelector(".container.wait")
                    const containerlogin = document.querySelector(".container.login")
                    const avis = document.querySelector("#avis3")

                    avis.addEventListener("click", (event)=> {
                        containeravis.style.transform = "translateX(-150%)"
                        setTimeout(function(){
                            containerwait.style.transform = "translateX(150%)"
                        },10000)
                    })
                </script>

                <?php if(isset($_GET['log'])): ?>
                    <div style="z-index: 4;" class="container login">
                        <h1>Merci ! Entre tes informations <br>pour tourner la roue</h1>

                        <?php if (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6b") :?>
                            <h2 class="bad">N'oublie pas de renseigner tes informations :)</h2>
                        <?php elseif (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6x") :?>
                            <h2 class="bad">Ce compte a déjà joué</h2>
                        <?php elseif (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6a") :?>
                            <h2 class="bad">Ce mail est déjà utilisé avec un autre nom</h2>
                        <?php else :?>
                            <h2 class="basic">Renseigne le bon pseudo google pour <br> pouvoir récupérer ta récompense</h2>
                        <?php endif ;?>
                        <form class="loginform" action="login.php" method="post">
                            <input type="text" name="name" placeholder="Pseudo google">
                            <input type="email" name="email" placeholder="Email google">
                            <button type="submit">Je valide</button>
                        </form> 
                    </div>

                    <?php else :?>
                    <div class="container login">
                        <h1>Merci ! Entre tes informations <br>pour tourner la roue</h1>

                        <?php if (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6b") :?>
                            <h2 class="bad">N'oublie pas de renseigner tes informations :)</h2>
                        <?php elseif (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6x") :?>
                            <h2 class="bad">Ce compte a déjà joué</h2>
                        <?php elseif (isset($_GET['log']) && $_GET['log'] == "zxfvwll22_6a") :?>
                            <h2 class="bad">Ce mail est déjà utilisé avec un autre nom</h2>
                        <?php else :?>
                            <h2 class="basic">Renseigne le bon pseudo google pour <br> pouvoir récupérer ta récompense</h2>
                        <?php endif ;?>
                        <form class="loginform" action="login.php" method="post">
                            <input type="text" name="name" placeholder="Pseudo google">
                            <input type="email" name="email" placeholder="Email google">
                            <button type="submit">Je valide</button>
                        </form> 
                    </div>

                <?php endif; ?>
                


        </main>
        <?php require_once(__DIR__."/footer.php") ?>
    </body>
</html>