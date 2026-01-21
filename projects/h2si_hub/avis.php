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


// Suppression d'un avis
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $con->prepare("DELETE FROM t_avis WHERE id = :id AND id_client = :id_client");
    $stmt->execute([':id' => $delete_id, ':id_client' => $id_client]);
    header("Location: avis.php");
    exit;
}

// Modification d'un avis
if (isset($_POST['update_avis'])) {
    $id_avis = intval($_POST['id_avis']);
    $note = intval($_POST['note']);
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $stmt = $con->prepare("UPDATE t_avis SET note = :note, commentaire = :commentaire WHERE id = :id AND id_client = :id_client");
    $stmt->execute([':note'=>$note, ':commentaire'=>$commentaire, ':id'=>$id_avis, ':id_client'=>$id_client]);
    header("Location: avis.php");
    exit;
}

// Récupérer les avis du client
$avis_query = $con->prepare("
    SELECT a.*, p.nom_pdt 
    FROM t_avis a
    JOIN t_produit p ON a.id_produit = p.id
    WHERE a.id_client = :id_client
    ORDER BY a.date_avis DESC
");
$avis_query->execute([':id_client'=>$id_client]);
$avis_list = $avis_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Mes avis - H2SI HUB</title>
<link rel="stylesheet" href="styl.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<style>
.container { max-width: 800px; margin: 30px auto; }
.un-avis { background:#fff; padding:15px; margin-bottom:15px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
.un-avis h4 { margin-bottom:5px; }
.star { font-size:18px; color:#ccc; cursor:pointer; }
.star.filled { color:#f5a623; }
textarea { width:100%; padding:8px; margin-top:5px; margin-bottom:10px; }
button { padding:6px 12px; background:#7EBB40; color:#fff; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:#5a9631; }
a.delete { color:red; text-decoration:none; margin-left:10px; }
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

<div class="voir_page">
    <h1 class="title">Mes avis</h1>
    <?php if(count($avis_list) > 0): ?>
        <?php foreach($avis_list as $avis): ?>
            <div class="un-avis">
                <h4><?= htmlspecialchars($avis['nom_pdt']) ?></h4>
                <div class="note">
                    <?php for($i=1;$i<=5;$i++): ?>
                        <span class="star <?= $i <= $avis['note'] ? 'filled' : '' ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
                <p><?= nl2br(htmlspecialchars($avis['commentaire'])) ?></p>

                <form method="post">
                    <input type="hidden" name="id_avis" value="<?= $avis['id'] ?>">
                    <label>Modifier la note :</label>
                    <select name="note" required>
                        <?php for($i=1;$i<=5;$i++): ?>
                            <option value="<?= $i ?>" <?= $avis['note']==$i ? 'selected' : '' ?>><?= $i ?> &#9733;<i class="bi bi-star-fill"></i></option>
                        <?php endfor; ?>
                    </select><br>
                    <label>Modifier le commentaire :</label>
                    <textarea name="commentaire" required><?= htmlspecialchars($avis['commentaire']) ?></textarea><br>
                    <button type="submit" name="update_avis">Mettre à jour</button>
                    <a class="delete" href="avis.php?delete=<?= $avis['id'] ?>" onclick="return confirm('Supprimer cet avis ?')">Supprimer</a>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Vous n'avez laissé aucun avis pour le moment.</p>
    <?php endif; ?>
</div>
</body>
</html>
