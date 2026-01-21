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
        <a href="notif.php" class="wishlist"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
      <i class="bi bi-person-fill" id="person-icon"></i>
    </div>
  </div>

  <!-- Sidebar verticale -->
 <nav class="sidebar">
    <ul class="nav-links">
      <li><a href="moncompte.php" class="nav-link">Mon compte</a></li>
      <li><a href="eqconnect.php" class="nav-link">Produits</a></li>
      <li><a href="presentation.php" class="nav-link active">Catégories</a></li>
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
<section class="categories">
  <h2 style="text-align:center; margin-bottom:5rem; margin-top:2rem;">Nos Catégories</h2>

  <!-- Liste des catégories -->
  <div class="categorie-liste" style="text-align:center; margin-bottom: 30px;">
    <?php
    $categories = $con->query("SELECT DISTINCT categorie FROM t_produit WHERE categorie IS NOT NULL AND categorie != ''");
    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
      $cat_name = htmlspecialchars($cat['categorie']);
      $active = (isset($_GET['categorie']) && $_GET['categorie'] == $cat_name) ? "active" : "";
      echo '<a href="presentation.php?categorie=' . urlencode($cat_name) . '" class="categorie-btn ' . $active . '">' . $cat_name . '</a>';
    }
    ?>
  </div>

  <div class="loader" id="loader"></div>

  <!-- Section des produits -->
  <section class="produits">
    <div class="contenu_box" id="produitsGrid">
      <?php
      if (isset($_GET['categorie'])) {
        $categorie = htmlspecialchars($_GET['categorie']);
        $stmt = $con->prepare("SELECT * FROM t_produit WHERE categorie = ?");
        $stmt->execute([$categorie]);
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($produits) > 0) {
          foreach ($produits as $pdt) {
            ?>
            <div class="box_eq">
              <div class="image_eq">
                <form method="post">
                  <img src="admin/image/<?= $pdt['image']; ?>" width="100%" class="images">
              </div>
              <div class="info_eq">
                <div class="button">
                  <button type="submit" name="ajouter_au_panier"><i class="bi bi-bag-check-fill"></i></button>
                  <button type="submit" name="ajouter_a_wishlist"><i class="bi bi-heart-fill"></i></button>
                  <a href="pageproduit.php?pid=<?= $pdt['id']; ?>" class="bi bi-eye-fill"></a>
                </div>
                <h3 class="nom"><?= $pdt['nom_pdt']; ?></h3>
                <input type="hidden" name="id_pdt" value="<?= $pdt['id']; ?>">
                <div class="flex" style="display:flex; justify-content:space-between;">
                  <p class="prix"><?= $pdt['prix']; ?> Fcfa</p>
                  <input type="number" name="quantite" required min="1" value="1" class="quantite" style="width:50px;">
                </div>
              </div>
              <a href="verifier.php?get_id=<?= $pdt['id']; ?>" class="btn_buy">Commander</a>
              </form>
            </div>
            <?php
          }
        } else {
          echo "<p style='text-align:center;'>Aucun produit trouvé pour cette catégorie.</p>";
        }
      } else {
        echo "<p style='text-align:center;'>Veuillez sélectionner une catégorie ci-dessus.</p>";
      }
      ?>
    </div>
    </section>
   <a href="eqconnect.php"><i class="bi bi-box-arrow-right"></i></a>
</section>
<!--Fin section produits -->

<script>
  window.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loader");
    const produits = document.querySelectorAll(".box_eq");

    // Afficher loader
    loader.style.display = "block";

    // Masquer après 600ms + afficher les produits
    setTimeout(() => {
      loader.style.display = "none";
      produits.forEach((box, i) => {
        setTimeout(() => {
          box.classList.add("show");
        }, i * 100);
      });
    }, 600);

    // Surbrillance catégorie active (optionnel en JS si besoin dynamique)
    const btns = document.querySelectorAll(".categorie-btn");
    btns.forEach(btn => {
      btn.addEventListener("click", () => {
        btns.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
      });
    });
  });
</script>

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
