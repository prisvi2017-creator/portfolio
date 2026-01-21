
<?php
session_start();

// Vérifie si la session n'est pas active, puis redirige vers index.php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_ad']) && isset($_POST['mdp_ad']) && !empty($_POST['mail_ad']) && !empty($_POST['mdp_ad'])) {
        $mail_ad = $_POST['mail_ad'];
        $mdp_ad = $_POST['mdp_ad'];

        include("connexion.php");

        $sql = "SELECT * FROM t_admin WHERE mail_ad = :mail_ad";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_ad", $mail_ad);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Connexion réussie
      
        // Redirection vers la page protégée ou autre traitement
        echo "";
    }
}

if (!isset($_SESSION['id_admin'])) {
    header("Location: index1.php");
    exit(); // Assure que le script s'arrête après la redirection
}
?>

