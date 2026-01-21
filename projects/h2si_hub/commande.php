<?php
 include("sessioneq.php");

?>



<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<meta http-equiv="X-UA-Compatible" content="IE=chrome">
<title>H2SI HUB</title>
<link rel="icon" href="Images/icone.png">
<link rel="stylesheet" href="styl.css">

</head>
<body>

<?php if (isset($_GET['erreur'])) { ?>

<?php echo '
 <div class="erreur form">
 <i class="bi bi-exclamation-triangle-fill"></i>
 <span>'.$_GET['erreur'].'</span>
 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
</div>' ; ?>
<?php } ?>
<!-- Barre de navigation -->
<div class="navbar-container">
  <!-- Haut : Logo + icônes -->
  <div class="navbar-top">
    <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img"  alt="H2SI Logo" /></a>
    <div class="nav-icons">
      <i class="bi bi-search" id="search-icon"></i>
      <a href="panier.php" class="panier">
        <i class="bi bi-cart-fill"></i>
            <sup><?php
             $count_panier = $con->prepare("SELECT COUNT(*) FROM t_panier WHERE id_client = :id_client");
             $count_panier->bindParam(":id_client", $id_client);
             $count_panier->execute();
             $num_panier = $count_panier->fetchColumn();
              echo $num_panier;
          ?>
          </sup>      
        </a>


      <a href="wishlist.php" class="wishlist">
        <i class="bi bi-suit-heart-fill"></i>
     <sup><?php 
            $count_wishlist = $con->prepare("SELECT COUNT(*) FROM t_wishlist WHERE id_client = :id_client");
            $count_wishlist->bindParam(":id_client", $id_client);
            $count_wishlist->execute();
            $num_wishlist = $count_wishlist->fetchColumn();
            echo $num_wishlist;
            ?></sup>
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
      <li><a href="eqconnect.php" class="nav-link">Produits</a></li>
      <li><a href="presentation.php" class="nav-link">Catégories</a></li>
      <li><a href="commande.php" class="nav-link  active">Commandes</a></li>
     <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
     <li><a href="service_client.php" class="nav-link">Service client</a></li>
      <li><a href="faq.php" class="nav-link">À propos</a></li>

    </ul>
  </nav>
</div>

<!-- Search & User Box -->
<div class="search-box">
  <form action="rechercheproduit.php" method="post">
    <input type="search" name="search" placeholder="Rechercher..">
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

<!--Fin Barre de navigation -->


<!--Section produits -->
<section class="voir_page">
<h1 class="title">Mes commandes</h1>
<div class="box-container">
    <?php 
      $select_commande = $con->prepare("SELECT * FROM t_commande WHERE id_client = :id_client AND visible_client = 1 ORDER BY date DESC");
$select_commande->bindParam(":id_client", $id_client);
$select_commande->execute();

       if ($select_commande->rowCount()>0) {
        while ($fetch_commande = $select_commande->fetch(PDO::FETCH_ASSOC)){        
            $select_products = $con->prepare("SELECT * FROM t_produit WHERE id = :id ");
            $select_products->bindParam(":id", $fetch_commande['pid']);
            $select_products->execute();
            if ($select_products->rowCount()>0) {
                $fetch_product= $select_products->fetch(PDO::FETCH_ASSOC);
                  ?>  
<div class="box" 
    <?php 
        if ($fetch_commande['statut_cmde'] == 'Annuler') {
            echo 'style="border:1px solid red;"';
        } elseif ($fetch_commande['statut_cmde'] == 'Livré') {
            echo 'style="border:1px solid blue;"';
        }elseif ($fetch_commande['statut_cmde'] == 'Confirmer') {
            echo 'style="border:1px solid green;"';
        }
          
    ?>
>
    <a href="voir_commande.php?get_id=<?= $fetch_commande['id']; ?>">
        <p class="date"><span></span><?= $fetch_commande['date']; ?></p>
        <img src="admin/image/<?= $fetch_product['image']; ?>" width="180" class="images">
        
        <div class="raw">
            <h3 class="nom"><?= $fetch_commande['produit']; ?></h3>
            <p class="prix">Prix : <?= $fetch_commande['prix']; ?> Fcfa</p>

            <p class="statut" style="color:
                <?php 
                    if ($fetch_commande['statut_cmde'] == 'Confirmer') {
                        echo 'green';
                    } elseif ($fetch_commande['statut_cmde'] == 'Annuler') { 
                        echo 'red';
                    } elseif ($fetch_commande['statut_cmde'] == 'Livré') {
                        echo 'blue';
                    } else {
                        echo 'orange';
                    }
                ?>
            ">
                <?= $fetch_commande['statut_cmde']; ?>
            </p>
        </div>
    </a>
</div>


<?php
                }

            }

        }else{
        echo '<p class ="vide">Aucune commandes disponible !';
       }
    ?>
</div>
   <a href="eqconnect.php"><i class="bi bi-box-arrow-right"></i></a>
</section>
<!--Fin section produits -->

<script>
      let navLinks = document.querySelector('.nav-links');
document.querySelector('#menu-icon').onclick = () =>{
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
