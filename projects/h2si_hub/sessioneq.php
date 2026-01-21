<?php
session_start();



if (!isset($_SESSION['id_client'])) {
    // Utilisateur non connecté : affichage normal mais actions restreintes
    $connecte = false;
} else {
    $connecte = true;
    $id_client = $_SESSION['id_client'];
    // ... récupère infos client, etc.
}


include("admin/connexion.php");



// Gestion ajout au panier (seulement si connecté)
if (isset($_POST['ajouter_au_panier'])) {
    if (!isset($_SESSION['id_client'])) {
        header("Location: connexion_client.php?erreur=Veuillez vous connecter pour ajouter au panier");
        exit();
    }

    $id_client = $_SESSION['id_client'];
    $id_pdt = $_POST['id_pdt'];
    $quantite = $_POST['quantite'];

    $verify_panier = $con->prepare("SELECT * FROM t_panier WHERE id_client = :id_client AND id_pdt = :id_pdt");
    $verify_panier->bindParam(":id_client", $id_client);
    $verify_panier->bindParam(":id_pdt", $id_pdt);
    $verify_panier->execute();

    if ($verify_panier->rowCount() > 0) {
        $warning_msg[] = 'Produit déjà ajouté au panier';
    } else {
        $select_prix = $con->prepare("SELECT prix FROM t_produit WHERE id = :id_pdt LIMIT 1");
        $select_prix->bindParam(":id_pdt", $id_pdt);
        $select_prix->execute();
        $fetch_prix = $select_prix->fetch(PDO::FETCH_ASSOC);

        $select_nom = $con->prepare("SELECT nom_pdt FROM t_produit WHERE id = :id_pdt LIMIT 1");
        $select_nom->bindParam(":id_pdt", $id_pdt);
        $select_nom->execute();
        $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);

        $insert_panier = $con->prepare("INSERT INTO t_panier (id_client, id_pdt, nom, prix, quantite) VALUES (:id_client, :id_pdt, :nom, :prix, :quantite)");
        $insert_panier->bindParam(":id_client", $id_client);
        $insert_panier->bindParam(":id_pdt", $id_pdt);
        $insert_panier->bindParam(":nom", $fetch_nom['nom_pdt']);
        $insert_panier->bindParam(":prix", $fetch_prix['prix']);
        $insert_panier->bindParam(":quantite", $quantite);
        $insert_panier->execute();

        $success_msg[] = 'Produit ajouté au panier avec succès';
    }
}

// Gestion ajout à la wishlist (seulement si connecté)
if (isset($_POST['ajouter_a_wishlist'])) {
    if (!isset($_SESSION['id_client'])) {
        header("Location: connexion_client.php?erreur=Veuillez vous connecter pour ajouter à la wishlist");
        exit();
    }

    $id_client = $_SESSION['id_client'];
    $id_pdt = $_POST['id_pdt'];

    $verify_wishlist = $con->prepare("SELECT * FROM t_wishlist WHERE id_client = :id_client AND id_pdt = :id_pdt");
    $verify_wishlist->bindParam(":id_client", $id_client);
    $verify_wishlist->bindParam(":id_pdt", $id_pdt);
    $verify_wishlist->execute();

    if ($verify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Produit déjà ajouté à la wishlist';
    } else {
        $select_prix = $con->prepare("SELECT prix FROM t_produit WHERE id = :id_pdt LIMIT 1");
        $select_prix->bindParam(":id_pdt", $id_pdt);
        $select_prix->execute();
        $fetch_prix = $select_prix->fetch(PDO::FETCH_ASSOC);

        $select_nom = $con->prepare("SELECT nom_pdt FROM t_produit WHERE id = :id_pdt LIMIT 1");
        $select_nom->bindParam(":id_pdt", $id_pdt);
        $select_nom->execute();
        $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $con->prepare("INSERT INTO t_wishlist (id_client, id_pdt, nom, prix) VALUES (:id_client, :id_pdt, :nom, :prix)");
        $insert_wishlist->bindParam(":id_client", $id_client);
        $insert_wishlist->bindParam(":id_pdt", $id_pdt);
        $insert_wishlist->bindParam(":nom", $fetch_nom['nom_pdt']);
        $insert_wishlist->bindParam(":prix", $fetch_prix['prix']);
        $insert_wishlist->execute();

        $success_msg[] = 'Produit ajouté à la wishlist avec succès';
    }
}

// Si connecté, on récupère les infos client
if (isset($_SESSION['id_client'])) {
    $id_client = $_SESSION['id_client'];
    $nom_client = $_SESSION['nom_client'];
    $prenom_client = $_SESSION['prenom_client'];
    $mail_client = $_SESSION['mail_client'];

    // Récupérer le nombre d'articles dans panier et wishlist
    $count_panier = $con->prepare("SELECT COUNT(*) FROM t_panier WHERE id_client = :id_client");
    $count_panier->bindParam(":id_client", $id_client);
    $count_panier->execute();
    $num_panier = $count_panier->fetchColumn();

    $count_wishlist = $con->prepare("SELECT COUNT(*) FROM t_wishlist WHERE id_client = :id_client");
    $count_wishlist->bindParam(":id_client", $id_client);
    $count_wishlist->execute();
    $num_wishlist = $count_wishlist->fetchColumn();
    
  // Récupérer le nombre de notifications non lues pour le badge
$count_notif = $con->prepare("SELECT COUNT(*) FROM t_notifications WHERE id_client = :id_client AND est_lue = 0");
$count_notif->bindParam(":id_client", $id_client);
$count_notif->execute();
$num_notif = $count_notif->fetchColumn();
} else {
    // Sinon valeurs par défaut
    $num_panier = 0;
    $num_wishlist = 0;
     $num_notif = 0;
}

?>