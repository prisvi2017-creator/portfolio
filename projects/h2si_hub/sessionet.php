<?php
session_start();

if (!isset($_SESSION['id_etudiant'])) {
    header("Location: cfe.php");
    exit(); // Assure que le script s'arrête après la redirection
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_et']) && isset($_POST['mdp_et']) && !empty($_POST['mail_et']) && !empty($_POST['mdp_et'])) {
        $mail_et = $_POST['mail_et'];
        $mdp_et = $_POST['mdp_et'];


    include("admin/connexion.php");

    $sql = "SELECT * FROM t_etudiant WHERE mail_et = :mail_et";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":mail_et", $mail_et);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
   
            $_SESSION['id_etudiant'] = $user['id'];
            $_SESSION['mail_et'] = $user['mail_et'];
            $_SESSION['nom_et'] = $user['nom_et']; 
            $_SESSION['prenom_et'] = $user['prenom_et'];
            $_SESSION['nom_form'] = $user['nom_form'];
            $_SESSION['formation_id_etudiant'] = $user['id_formation'];
            // Redirection vers la page protégée ou autre traitement
            echo "";
        }

}


$id_etudiant = $_SESSION['id_etudiant'];
$nom_et = $_SESSION['nom_et'];
$prenom_et = $_SESSION['prenom_et'];
$mail_et = $_SESSION['mail_et'];
$nom_form = $_SESSION['nom_form'];
 $formation_id_etudiant = $_SESSION["formation_id_etudiant"];

 include("admin/connexion.php");
 $count_notif = $con->prepare("SELECT COUNT(*) FROM t_notifications WHERE id_etudiant = :id_etudiant AND est_lue = 0");
$count_notif->bindParam(":id_etudiant", $id_etudiant);
$count_notif->execute();
$num_notif = $count_notif->fetchColumn();



?>