<?php
session_start();

require_once(__DIR__."/sqlconfig.php"); // Include the database configuration file

$avistatement = $mysqlClient->prepare('SELECT * FROM avis');
$avistatement->execute();
$avis = $avistatement->fetchAll();

header('Content-Type: application/json');

// Lire les données de la requête POST
$data = json_decode(file_get_contents('php://input'), true);
$angle = $data['angle'] ?? null;

if ($angle !== null) {
    // Enregistrer l'angle dans la session ou dans une base de données
    $_SESSION['last_angle'] = $angle;

    // Vous pouvez ajouter ici du code pour déterminer le prix gagné en fonction de l'angle
    $prize = '';

    switch ($angle % 360) {
        case 0:
            $prize = 'brochettes';
            break;
        case 60:
            $prize = 'perdu';
            break;
        case 120:
            $prize = 'frites';
            break;
        case 180:
            $prize = 'canette';
            break;
        case 240:
            $prize = 'perdu';
            break;
        case 300:
            $prize = 'burger';
            break;
    }

    // Enregistrer le prix gagné
    $updateprize = $mysqlClient->prepare('UPDATE users SET prize = :prize WHERE id = :id');
    $updateprize->execute([
        'prize'=> $prize,
        'id'=>$_SESSION['user']['id']
    ]);

    $date = new DateTime();
    $date->modify('+30 days');
    $datestring = $date->format('d/m/Y');

    $addavis = $mysqlClient->prepare('INSERT INTO avis(user_id, user_email, prize, recup) VALUES (:user_id, :user_email, :prize, :recup)');
    $addavis->execute([
        'user_id'=> $_SESSION['user']['id'],
        'user_email'=> $_SESSION['user']['email'],
        'prize'=> $prize,
        'recup'=> $datestring,
    ]);

    $_SESSION['user']['prize'] = $prize;

    // Mettre à jour l'état de l'utilisateur
    $updateprize = $mysqlClient->prepare('UPDATE users SET haswon = :haswon WHERE id = :id');
    $updateprize->execute([
        'haswon'=> 1,
        'id'=>$_SESSION['user']['id']
    ]);

    $_SESSION['user']['haswon'] = 1;

    // Répondre à la requête AJAX
    echo json_encode(['status' => 'success', 'angle' => $angle, 'prize' => $prize]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Angle non fourni']);
}

?>
