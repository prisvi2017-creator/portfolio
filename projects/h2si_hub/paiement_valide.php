<?php
include("sessioneq.php");

if (!isset($_SESSION['id_client'])) {
    header('Location: connexion_client.php');
    exit();
}

if (isset($_POST['payer'])) {
    $id_client = $_SESSION['id_client'];
    $nom_client = $_POST["nom_client"];
    $prenom_client = $_POST["prenom_client"];
    $mail_client = $_POST["mail_client"];
    $numero = $_POST["numero"];
    $addresse = $_POST["addresse"];
    $methode = $_POST["methode"];
    $produit = $_POST['produit'];
    $pid = $_POST['pid'];
    $grand_total = $_POST['grand_total'];

    $verify_panier = $con->prepare("SELECT * FROM t_panier WHERE id_client = :id_client");
    $verify_panier->bindParam(":id_client", $id_client);
    $verify_panier->execute();

    if ($verify_panier->rowCount() > 0) {
        $insert_commande = $con->prepare("INSERT INTO t_commande(id_client, nom_client, prenom_client, mail_client, numero, addresse, methode, pid, produit, prix ) VALUES(:id_client, :nom_client, :prenom_client, :mail_client, :numero, :addresse, :methode, :pid, :produit, :prix)");
        $insert_commande->bindParam(":id_client", $id_client);
        $insert_commande->bindParam(":nom_client", $nom_client);
        $insert_commande->bindParam(":prenom_client", $prenom_client);
        $insert_commande->bindParam(":mail_client", $mail_client);
        $insert_commande->bindParam(":numero", $numero);
        $insert_commande->bindParam(":addresse", $addresse);
        $insert_commande->bindParam(":methode", $methode);
        $insert_commande->bindParam(":pid", $pid);
        $insert_commande->bindParam(":produit", $produit);
        $insert_commande->bindParam(":prix", $grand_total);
        $insert_commande->execute();

        $supprimer_panier = $con->prepare("DELETE FROM t_panier WHERE id_client = :id_client");
        $supprimer_panier->bindParam(":id_client", $id_client);
        $supprimer_panier->execute();

        header('Location: commande.php?paiement=ok');
    } else {
        echo "Erreur : panier vide.";
    }
}
?>
