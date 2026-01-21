<?php
include("sessioneq.php");



if (isset($_POST['supprimer_notif'])) {
    $notif_id = $_POST['notif_id'];
    $delete_notif = $con->prepare("DELETE FROM t_notifications WHERE id = :id AND id_client = :id_client");
    $delete_notif->bindParam(":id", $notif_id, PDO::PARAM_INT);
    $delete_notif->bindParam(":id_client", $id_client, PDO::PARAM_INT);
    $delete_notif->execute();
}

// Récupérer le nombre de notifications non lues pour le badge
$count_notif = $con->prepare("SELECT COUNT(*) FROM t_notifications WHERE id_client = :id_client AND est_lue = 0");
$count_notif->bindParam(":id_client", $id_client);
$count_notif->execute();
$num_notif = $count_notif->fetchColumn();

// Récupérer toutes les notifications du client
$select_notif = $con->prepare("SELECT * FROM t_notifications WHERE id_client = :id_client ORDER BY date_envoi DESC");
$select_notif->bindParam(":id_client", $id_client);
$select_notif->execute();
$notifications = $select_notif->fetchAll(PDO::FETCH_ASSOC);

// Optionnel : marquer toutes comme lues
$update_lue = $con->prepare("UPDATE t_notifications SET est_lue = 1 WHERE id_client = :id_client");
$update_lue->bindParam(":id_client", $id_client);
$update_lue->execute();
?>

<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<meta http-equiv="X-UA-Compatible" content="IE=chrome">
<title>H2SI HUB - Notifications</title>
<link rel="icon" href="Images/icone.png">
<style>
    .boxis {
    display: flex;
    flex-direction: column; /* aligne les notifications verticalement */
    gap: 10px; /* espace entre chaque notification */
}

.notif-box {
    width: 100%;           /* occupe toute la largeur disponible */
    border: 1px solid #007BFF;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.un-supprimer {
    background-color: #dc3545; /* rouge */
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 0.9em;
}

.un-supprimer:hover {
    background-color: #c82333;
}

</style>
<link rel="stylesheet" href="styl.css">
</head>
<body>
<!-- Barre de navigation -->
<div class="navbar-container">
  <div class="navbar-top">
    <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img"  alt="H2SI Logo" /></a>
    <div class="nav-icons">
      <i class="bi bi-search" id="search-icon"></i>
      <a href="panier.php" class="panier"><i class="bi bi-cart-fill"></i>
          <sup><?= $num_panier ?></sup>
      </a>
      <a href="wishlist.php" class="wishlist"><i class="bi bi-suit-heart-fill"></i>
          <sup><?= $num_wishlist ?></sup>
      </a>
      <a href="notif.php" class="wishlist active"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
      <i class="bi bi-person-fill" id="person-icon"></i>
    </div>
  </div>

  <nav class="sidebar">
    <ul class="nav-links">
    <li><a href="moncompte.php" class="nav-link">Mon compte</a></li>
      <li><a href="eqconnect.php" class="nav-link">Produits</a></li>
      <li><a href="presentation.php" class="nav-link">Catégories</a></li>
      <li><a href="commande.php" class="nav-link">Commandes</a></li>
      <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
      <li><a href="service_client.php" class="nav-link">Service client</a></li>
      <li><a href="faq.php" class="nav-link">À propos</a></li>
    </ul>
  </nav>
</div>

<div class="search-box">
  <form action="rechercheproduit.php" method="post">
    <input type="search" name="search" placeholder="Rechercher..">
  </form>
</div>

<div class="user-box">
    <p>Nom : <span><?= htmlspecialchars($nom_client . ' ' . $prenom_client) ?></span></p>
    <p>Email : <span><?= htmlspecialchars($mail_client) ?></span></p>
    <a href="moncompte.php" class="compte">Mon compte</a>
    <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
</div>

<section class="voir_page">
<h1 class="title">Notifications</h1>
<div class="boxis">
    <?php if (count($notifications) > 0): ?>
        <?php foreach ($notifications as $notif): ?>
           <div class="box notif-box">
    <p><b><?= htmlspecialchars($notif['titre']); ?></b></p>
    <p><?= htmlspecialchars($notif['message']); ?></p>
    <p style="font-size:0.8em; color:gray;">Envoyé le : <?= $notif['date_envoi']; ?></p>
   <form method="post" onsubmit="return confirm('Voulez-vous supprimer cette notification ?');">
        <input type="hidden" name="notif_id" value="<?= $notif['id']; ?>">
        <button type="submit" name="supprimer_notif" class="un-supprimer">Supprimer</button>
    </form>
</div>

        <?php endforeach; ?>
    <?php else: ?>
        <p class="vide">Aucune notification disponible !</p>
    <?php endif; ?>
</div>
<a href="eqconnect.php"><i class="bi bi-box-arrow-right"></i></a>
</section>

<script>
    let navLinks = document.querySelector('.nav-links');
    document.querySelector('#menu-icon').onclick = () => {
        navLinks.classList.toggle('active');
    }
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
