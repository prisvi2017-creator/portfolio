<?php
session_start();

if (!isset($_SESSION['id_enseignant'])) {
    header("Location: enseigne.php");
    exit(); // Assure que le script s'arrête après la redirection
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_prof']) && isset($_POST['mdp_prof']) && !empty($_POST['mail_prof']) && !empty($_POST['mdp_prof'])) {
        $mail_prof = $_POST['mail_prof'];
        $mdp_prof = $_POST['mdp_prof'];

        include("connexion.php");

        $sql = "SELECT * FROM t_enseignant WHERE mail_prof = :mail_prof";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_prof", $mail_prof);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       
                // Connexion réussie
                $_SESSION['id_enseignant'] = $user['id'];
                $_SESSION['mail_prof'] = $user['mail_prof'];
                $_SESSION['nom_prof'] = $user['nom_prof']; 
                $_SESSION['prenom_prof'] = $user['prenom_prof']; 

                // Redirection vers la page protégée ou autre traitement
                echo "";
        
      
    }

   }
   
$id_enseignant = $_SESSION['id_enseignant'];
$nom_prof = $_SESSION['nom_prof'];
$prenom_prof = $_SESSION['prenom_prof'];
$mail_prof = $_SESSION['mail_prof'];
 

?>