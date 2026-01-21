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

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>H2SI HUB</title>
    <link rel="icon" href="Images/icone.png" />
    <link rel="stylesheet" href="styl.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body style="margin-left: .8rem; margin-right: .8rem;">

<!-- Barre de navigation -->
<div class="navbar-container">
  <div class="navbar-top">
    <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img" alt="H2SI Logo" /></a>
    <div class="nav-icons">
      <i class="bi bi-search" id="search-icon"></i>

      <a href="panier.php" class="panier">
        <i class="bi bi-cart-fill"></i>
        <sup><?= $num_panier ?></sup>
      </a>

      <a href="wishlist.php" class="wishlist">
        <i class="bi bi-suit-heart-fill"></i>
        <sup><?= $num_wishlist ?></sup>
      </a>


       <a href="notif.php" class="wishlist">
       <i class="bi bi-bell-fill"></i>
        <sup><?= $num_notif ?></sup>
      </a>

      <i class="bi bi-person-fill" id="person-icon"></i>
    </div>
  </div>

  <!-- Sidebar verticale -->
  <nav class="sidebar">
    <ul class="nav-links">
    <li><a href="moncompte.php" class="nav-link">Mon compte</a></li>
      <li><a href="#" class="nav-link active">Produits</a></li>
      <li><a href="presentation.php" class="nav-link">Catégories</a></li>
      <li><a href="commande.php" class="nav-link">Commandes</a></li>
      <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
      <li><a href="service_client.php" class="nav-link">Service client</a></li>
      <li><a href="faq.php" class="nav-link">À propos</a></li>
    </ul>
  </nav>
</div>

<!-- Search & User Box -->
<div class="search-box">
  <form action="rechercheproduit.php" method="post">
    <input type="search" name="search" placeholder="Rechercher.." />
  </form>
</div>

<div class="user-box">
    <?php if (isset($_SESSION['id_client'])): ?>
        <p>Nom : <span><?= htmlspecialchars($nom_client . ' ' . $prenom_client) ?></span></p>
        <p>Email : <span><?= htmlspecialchars($mail_client) ?></span></p>
        <a href="moncompte.php" class="compte">Mon compte</a>
        <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
    <?php else: ?>
        <a href="connexion_client.php" class="compte">Se connecter / S'inscrire</a>
    <?php endif; ?>
</div>

<!-- Fin Barre de navigation -->

<!-- Section Pub -->
<section class="Pub">
    <div class="content">
       <span>Simplifiez vos achats</span>
       <h3>Tout le matériel de laboratoire dont vous avez besoin <br> à portée de clic !</h3>
       <a href="presentation.php" id="btn-lien" class="btne">Commander</a>
    </div>
    <div class="image">
       <img src="Images/eq.png" alt="" />
    </div>
</section>

<!-- Section produits -->
<section class="produits">
    <div class="contenu_box">
        <?php
        $select_products = $con->query("SELECT * FROM `t_produit` LIMIT 4");
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="box_eq">
            <div class="image_eq">
                <form action="" method="post">
                    <img src="admin/image/<?= htmlspecialchars($fetch_products['image']); ?>" width="270" class="images" />
            </div>

            <div class="info_eq">
                <div class="button">
                    <button type="submit" name="ajouter_au_panier"><i class="bi bi-bag-check-fill"></i></button>
                    <button type="submit" name="ajouter_a_wishlist"><i class="bi bi-heart-fill"></i></button>
                    <a href="pageproduit.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bi bi-eye-fill"></a>
                </div>
                <h3 class="nom"><?= htmlspecialchars($fetch_products['nom_pdt']); ?></h3>
                <input type="hidden" name="id_pdt" value="<?= htmlspecialchars($fetch_products['id']); ?>" />

                <div class="flex">
                    <p class="prix"><?= htmlspecialchars($fetch_products['prix']); ?> Fcfa</p>
                    <input type="number" name="quantite" required min="1" value="1" max="99" maxlength="2" class="quantite" />
                </div>
            </div>
            <a href="verifier.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn_buy">Commander</a>
                </form>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<script>
  let navLinks = document.querySelector('.nav-links');
  document.querySelector('#menu-icon')?.addEventListener('click', () => {
    navLinks.classList.toggle('active');
  });
</script>
<script src="box.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>

<script>
function checkNotifications() {
    fetch('check_notif.php') // fichier qui renvoie les notifications non lues
        .then(response => response.json())
        .then(data => {
            if(data.length > 0) {
                data.forEach(notif => {
                    Swal.fire({
                        title: notif.titre,
                        text: notif.message,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Voir',
                        cancelButtonText: 'Fermer'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'notif.php';
                        }
                    });
                });
            }
        })
        .catch(err => console.error(err));
}

// Vérifie toutes les 10 secondes
setInterval(checkNotifications, 10000);
</script>
</body>
</html>
