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
      <li><a href="presentation.php" class="nav-link">Catégories</a></li>
      <li><a href="commande.php" class="nav-link">Commandes</a></li>
     <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
     <li><a href="service_client.php" class="nav-link ">Service client</a></li>
      <li><a href="faq.php" class="nav-link active">À propos</a></li>

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
<section class="faq-section">
  <h1 class="faq-title">À propos – Questions Fréquentes (FAQ)</h1>

  <div class="accordion">
    <div class="accordion-item">
      <button class="accordion-header">Comment passer une commande ?</button>
      <div class="accordion-body">
        <p>Pour passer une commande, sélectionnez vos produits, ajoutez-les au panier, puis cliquez sur "Commander". Remplissez vos informations et choisissez un mode de paiement.</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Quels sont les délais de livraison ?</button>
      <div class="accordion-body">
        <p>Les délais de livraison varient de 2 à 7 jours ouvrés selon votre localisation et la disponibilité des produits.</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Puis-je retourner un produit ?</button>
      <div class="accordion-body">
        <p>Oui, vous disposez de 7 jours après réception pour retourner un produit s’il est défectueux ou non conforme.</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Quels modes de paiement acceptez-vous ?</button>
      <div class="accordion-body">
        <p>Nous acceptons les paiements à la livraison, par carte bancaire.</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Comment contacter le service client ?</button>
      <div class="accordion-body">
        <p>Vous pouvez nous contacter via notre formulaire Service Client, par téléphone ou par e-mail à tout moment.</p>
      </div>
    </div>
  </div>
  
   <a href="eqconnect.php"><i class="bi bi-box-arrow-right"></i></a>
</section>

<script>
  // Accordéon JavaScript
  const headers = document.querySelectorAll('.accordion-header');
  headers.forEach(header => {
    header.addEventListener('click', () => {
      const openItem = document.querySelector('.accordion-item.active');
      if (openItem && openItem !== header.parentElement) {
        openItem.classList.remove('active');
        openItem.querySelector('.accordion-body').style.maxHeight = null;
      }

      header.parentElement.classList.toggle('active');
      const body = header.nextElementSibling;
      body.style.maxHeight = header.parentElement.classList.contains('active') ? body.scrollHeight + 'px' : null;
    });
  });
</script>


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
