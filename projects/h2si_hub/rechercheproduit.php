<?php
include("sessioneq.php");
?>



<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<meta http-equiv="X-UA-Compatible" content="IE=chrome">
<title>H2SI HUB</title>
<link rel="icon" href="Images/icone.png">
<link rel="stylesheet" href="styl.css">

</head>
<body>
<!-- Barre de navigation -->
<div class="navbar-container">
  <!-- Haut : Logo + icônes -->
  <div class="navbar-top">
    <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img"  alt="H2SI Logo" /></a>
    <div class="nav-icons">
      <a href="#" class="rch active"><i class="bi bi-search" id="search-icon"></i></a>
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
        <a href="notif.php" class="wishlist"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
      <i class="bi bi-person-fill" id="person-icon"></i>
    </div>
  </div>

  <!-- Sidebar verticale -->
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
<section class="produits">
    <div class="contenu_box">

    <?php
if(isset($_POST['search'])){
    $search = $_POST['search'];
      $select_produit = $con->prepare("SELECT * FROM t_produit WHERE nom_pdt LIKE '%{$search}%'");
      $select_produit->execute();
      if($select_produit->rowCount() > 0){
         while($fetch_produit = $select_produit->fetch(PDO::FETCH_ASSOC)){ 
            $produit_id = $fetch_produit['id'];
   ?>
       
            <div  class="box_eq">

                <div class="image_eq">
                    <form action="" method="post">
                        <img  src="admin/image/<?=$fetch_produit['image']; ?>" width="270"  class="images">
                </div>

                <div  class="info_eq">
                    <div class="button">
                        <button type="submit" name="ajouter_au_panier" ><i class="bi bi-bag-check-fill"></i></button>
                        <button type="submit" name="ajouter_a_wishlist"><i class="bi bi-heart-fill"></i></button>
                        <a href="pageproduit.php?pid=<?php echo $produit_id; ?>" class="bi bi-eye-fill"></a>
                    </div>
                    <h3 class="nom"><?=$fetch_produit['nom_pdt']; ?></h3>
                    <input type="hidden" name="id_pdt" value="<?=$produit_id; ?>">

                    <div class="flex">
                        <p class="prix"><?= $fetch_produit['prix']; ?>Fcfa</p>
                        <input type="number" name="quantite" required min="1" value="1" max="99" maxlength="2" class="quantite" >
                    </div>
                </div>
                <a href="verifier.php?get_id=<?= $produit_id; ?>" class="btn_buy">Commander </a>
                </form>
            </div>
            <?php
         }
        }else{
           echo '<p class="vide">Aucun produit trouvé!</p>';
        }
     }else{
        echo '<p class="vide">Chercher quelque chose!</p>';
     }
   ?>
    </div>
   
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
</body>
</html>
