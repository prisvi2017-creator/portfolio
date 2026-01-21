<?php
session_start();

if (!isset($_SESSION['id_client'])) {
    header("Location: rendezvous.php");
    exit(); // Assure que le script s'arrête après la redirection
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['mdp']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        include("admin/connexion.php");

        $sql = "SELECT * FROM t_client WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


                // Connexion réussie
                $_SESSION['id_client'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom']; // Ajout de la variable nom_client

                // Redirection vers la page protégée ou autre traitement
                echo "";
           
      
    }

   
}


$id_client = $_SESSION['id_client'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];

?>