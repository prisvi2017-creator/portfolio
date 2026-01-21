<?php
include("sessioneq.php");


$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ancien = trim($_POST['ancien_mdp']);
    $nouveau = trim($_POST['nouveau_mdp']);
    $confirmer = trim($_POST['confirmer_mdp']);

    // Récupérer le mot de passe actuel
    $stmt = $con->prepare("SELECT mdp_client FROM t_client WHERE id = :id_client");
    $stmt->bindParam(":id_client", $id_client, PDO::PARAM_INT);
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client && password_verify($ancien, $client['mdp_client'])) {
        if ($nouveau === $confirmer) {
            $hash = password_hash($nouveau, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE t_client SET mdp_client = :mdp WHERE id = :id_client");
            $update->bindParam(":mdp", $hash);
            $update->bindParam(":id_client", $id_client, PDO::PARAM_INT);
            $update->execute();

            $message = "Mot de passe modifié avec succès.";
            header("refresh:1;url=moncompte.php");
        } else {
            $message = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $message = "Ancien mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<title>Changer mon mot de passe</title>
<link rel="stylesheet" href="styl.css">
<style>
    .form-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-container label {
        font-weight: bold;
    }
    .form-container input {
        width: 100%;
        padding: 8px;
        margin: 8px 0 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .form-container button {
        background: #7EBB40;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        font-size: 1rem;
        cursor: pointer;
        border-radius: 5px;
    }
    .form-container button:hover {
        background: #5a9631;
    }
    .message {
        text-align: center;
        color: red;
        margin-bottom: 10px;
    }
</style>
</head>
<body>


<!-- Topbar -->
<div class="navbar-container">
    <div class="navbar-top">
        <a href="#" class="logo">
            <img src="Images/H2SI Hub.png" class="logo-img" alt="H2SI Logo" />
        </a>
        <div class="nav-icons">
            <i class="bi bi-search" id="search-icon"></i>
            <a href="panier.php" class="panier">
                <i class="bi bi-cart-fill"></i>
                <sup>
                    <?php
                    $count_panier = $con->prepare("SELECT COUNT(*) FROM t_panier WHERE id_client = :id_client");
                    $count_panier->bindParam(":id_client", $id_client);
                    $count_panier->execute();
                    echo $count_panier->fetchColumn();
                    ?>
                </sup>
            </a>
            <a href="wishlist.php" class="wishlist">
                <i class="bi bi-suit-heart-fill"></i>
                <sup>
                    <?php
                    $count_wishlist = $con->prepare("SELECT COUNT(*) FROM t_wishlist WHERE id_client = :id_client");
                    $count_wishlist->bindParam(":id_client", $id_client);
                    $count_wishlist->execute();
                    echo $count_wishlist->fetchColumn();
                    ?>
                </sup>
            </a>
            <a href="notif.php" class="wishlist">
                <i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup>
            </a>
            <i class="bi bi-person-fill" id="person-icon"></i>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="sidebar">
        <ul class="nav-links">
            <li><a href="moncompte.php" class="nav-link active">Mon compte</a></li>
            <li><a href="eqconnect.php" class="nav-link">Produits</a></li>
            <li><a href="presentation.php" class="nav-link">Catégories</a></li>
            <li><a href="commande.php" class="nav-link">Commandes</a></li>
            <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
            <li><a href="service_client.php" class="nav-link">Service client</a></li>
            <li><a href="faq.php" class="nav-link">À propos</a></li>
        </ul>
    </nav>
</div>

<!-- Search Box -->
<div class="search-box">
    <form action="rechercheproduit.php" method="post">
        <input type="search" name="search" placeholder="Rechercher..">
    </form>
</div>

<!-- User Box -->
<div class="user-box">
    <p>Nom : <span><?= htmlspecialchars($nom_client) . ' ' . htmlspecialchars($prenom_client) ?></span></p>
    <p>Email : <span><?= htmlspecialchars($mail_client) ?></span></p>
    <a href="moncompte.php" class="compte">Mon compte</a>
    <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
</div>


<div class="form-container">
    <h2>Changer mon mot de passe</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>
    <form method="post">
        <label>Ancien mot de passe :</label>
        <input type="password" name="ancien_mdp" required>

        <label>Nouveau mot de passe :</label>
        <input type="password" name="nouveau_mdp" required>

        <label>Confirmer le nouveau mot de passe :</label>
        <input type="password" name="confirmer_mdp" required>

        <button type="submit">Changer</button>
    </form>
</div>

</body>
</html>
