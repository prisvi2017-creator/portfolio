<?php
 include("sessioneq.php");

if (isset($_POST['supprimer'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_EMAIL);

    $verify_supprimer = $con->prepare("SELECT * FROM t_wishlist WHERE id = :id");
    $verify_supprimer->bindParam(":id", $wishlist_id);
    $verify_supprimer->execute();

    if ($verify_supprimer->rowCount()>0) {
        $supprimer_wishlist_id = $con->prepare("DELETE FROM t_wishlist WHERE id = :id");
        $supprimer_wishlist_id->bindParam(":id", $wishlist_id);
        $supprimer_wishlist_id->execute();
        $success_msg[] = "produit supprimer de la wishlist";
    }
}
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


      <a href="wishlist.php" class="wishlist active">
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
<section class="voir_page">
   <h1 class="title">Ma liste de souhaits</h1>
   <div class="contenu_box">

   <?php
$grand_total = 0;
$select_wishlist = $con->prepare("SELECT * FROM t_wishlist WHERE id_client = :id_client");
$select_wishlist->bindParam(':id_client', $id_client); 
$select_wishlist->execute();

if ($select_wishlist->rowCount() > 0) {
    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
        $select_products = $con->prepare("SELECT * FROM t_produit WHERE id = :product_id");
        $select_products->bindParam(':product_id', $fetch_wishlist['id_pdt']);
        $select_products->execute();

        if ($select_products->rowCount() > 0) {
            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
?>

      <form  method="post" class="box">
        <input type="hidden" name="wishlist_id" value="<?=$fetch_wishlist['id']; ?>">
        <img src="admin/image/<?=$fetch_products['image']; ?>"width="270"  class="images">
        <h3 class="nom"><?php echo $fetch_products['nom_pdt']; ?></h3>
        <input type="hidden" name="id_pdt" value="<?=$fetch_products['id']; ?>">
        <div class="flex">
          <p class="prix"><?= $fetch_products['prix']; ?>Fcfa</p>
        </div>
        <a href="verifier.php?get_id=<?= $fetch_products['id']; ?>" class="btn_buy">Commander </a>
        <div class="button">
        <button type="submit" name="ajouter_au_panier" ><i class="bi bi-bag-check-fill"></i></button>
          <a href="pageproduit.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
          <button type="submit" name="supprimer" onclick="return confirm('supprimer ce produit?');">
          <i class="bi bi-x-lg"></i>
        </button>
        </div>
       
       
      </form>
      <?php
          $grand_total+=$fetch_wishlist['prix'];
        }
    }
   }else{
    echo '<p class="vide"> Aucun produit ajouté!</p>';
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
</body>
</html>
