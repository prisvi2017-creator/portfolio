<?php
include("sessioneq.php");

// Vérifier si le client est connecté
$isConnected = isset($id_client) && !empty($id_client);

$client = null;
if ($isConnected) {
    // Récupérer les infos du client connecté
    $stmt = $con->prepare("
        SELECT nom_client, prenom_client, mail_client
        FROM t_client 
        WHERE id = :id_client
    ");
    $stmt->bindParam(":id_client", $id_client, PDO::PARAM_INT);
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - H2SI HUB</title>
    <meta http-equiv="X-UA-Compatible" content="IE=chrome">
    <link rel="icon" href="Images/icone.png">
    <link rel="stylesheet" href="styl.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        .compte-container {
            margin: 20px auto;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .compte-container h2 { margin-bottom: 20px; color: #333; }
        .compte-info p { margin: 10px 0; font-size: 1rem; }
        .compte-info span { font-weight: bold; color: #555; }
        .actions { margin-top: 20px; }
        .actions a {
            display: inline-block;
            background: #7EBB40;
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            margin: 5px;
        }
        .actions a:hover { background: #5a9631; }
        .btn-inscription { display: inline-block; background: #007bff; color: #fff; padding: 10px 15px; border-radius: 6px; text-decoration: none; margin: 5px; }
        .btn-inscription:hover { background: #0056b3; }
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
            <?php if ($isConnected): ?>
                <a href="panier.php" class="panier">
                    <i class="bi bi-cart-fill"></i>
                    <sup><?php
                        $count_panier = $con->prepare("SELECT COUNT(*) FROM t_panier WHERE id_client = :id_client");
                        $count_panier->bindParam(":id_client", $id_client);
                        $count_panier->execute();
                        echo $count_panier->fetchColumn();
                    ?></sup>
                </a>
                <a href="wishlist.php" class="wishlist">
                    <i class="bi bi-suit-heart-fill"></i>
                    <sup><?php
                        $count_wishlist = $con->prepare("SELECT COUNT(*) FROM t_wishlist WHERE id_client = :id_client");
                        $count_wishlist->bindParam(":id_client", $id_client);
                        $count_wishlist->execute();
                        echo $count_wishlist->fetchColumn();
                    ?></sup>
                </a>
                <a href="notif.php" class="wishlist">
                    <i class="bi bi-bell-fill"></i><sup><?= $num_notif ?? 0 ?></sup>
                </a>
            <?php endif; ?>
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

<!-- Contenu principal -->
<section class="voir_page">
    <?php if ($isConnected && $client): ?>
        <h1 class="title">Informations du compte</h1>
        <div class="compte-info">
            <p><span>Nom :</span> <?= htmlspecialchars($client['nom_client']) ?></p>
            <p><span>Prénom :</span> <?= htmlspecialchars($client['prenom_client']) ?></p>
            <p><span>Email :</span> <?= htmlspecialchars($client['mail_client']) ?></p>
        </div>
        <div class="actions">
            <a href="modifier_compte.php"><i class="bi bi-pencil"></i> Modifier mes informations</a>
            <a href="changer_motdepasse.php"><i class="bi bi-lock-fill"></i> Changer mon mot de passe</a>
            <a href="avis.php"><i class="bi bi-chat-left-text"></i> Mes avis</a>
        </div>
    <?php else: ?>
        <h2>Accès au compte</h2>
        <p>Inscrivez-vous pour avoir accès à votre compte.</p>
        <a href="connexion_client.php" class="btn-inscription">Connexion / Inscription</a>
    <?php endif; ?>
</section>

<!-- Scripts -->
<script src="box.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
