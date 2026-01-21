<?php
session_start();
include("admin/connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_client'], $_POST['mdp_client'])) {
        $mail_client = $_POST['mail_client'];
        $mdp_client = $_POST['mdp_client'];

        $sql = "SELECT * FROM t_client WHERE mail_client = :mail_client LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_client", $mail_client);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp_client, $user['mdp_client'])) {
            // Connexion réussie : création de la session
            $_SESSION['id_client'] = $user['id'];
            $_SESSION['mail_client'] = $user['mail_client'];
            $_SESSION['nom_client'] = $user['nom_client'];
            $_SESSION['prenom_client'] = $user['prenom_client'];

            header("Location: eqconnect.php");
            exit();
        } else {
            // Erreur connexion
            header("Location: connexion_client.php?erreur=Email ou mot de passe incorrect");
            exit();
        }
    }
} else {
    // Accès direct interdit
    header("Location: connexion_client.php");
    exit();
}
?>
