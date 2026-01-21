<?php
include("sessioneq.php");

// Vérifier que le client est connecté
if (!isset($_SESSION['id_client'])) {
    header("Location: connexion_client.php?erreur=connectez-vous pour accéder au service-client");
    exit();
}

$id_client = $_SESSION['id_client'];

// Traitement du formulaire
$message_info = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom  = htmlspecialchars(trim($_POST['prenom']));
    $nom     = htmlspecialchars(trim($_POST['nom']));
    $mail    = htmlspecialchars(trim($_POST['mail']));
    $tel     = htmlspecialchars(trim($_POST['tel']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!empty($prenom) && !empty($nom) && !empty($mail) && !empty($tel) && !empty($message)) {
        try {
            $sql = "INSERT INTO t_message (id_client, prenom, nom, mail, tel, message, reponse) 
                    VALUES (:id_client, :prenom, :nom, :mail, :tel, :message, '')";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                $success_msg[] = '✅ Message envoyé avec succès !';
            } else {
                $warning_msg[] = '❌ Erreur lors de l\'envoi du message.';
            }
        } catch (PDOException $e) {
            $warning_msg[] = 'Erreur : ' . $e->getMessage();
        }
    } else {
        $warning_msg[] = 'Veuillez remplir tous les champs.';
    }
}
?>

<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <meta http-equiv="X-UA-Compatible" content="IE=chrome">
    <title>H2SI HUB</title>
    <link rel="icon" href="Images/icone.png">
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<?php if (isset($_GET['erreur'])) { ?>
<div class="erreur form">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span><?= $_GET['erreur']; ?></span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
</div>
<?php } ?>

<!-- Barre de navigation -->
<div class="navbar-container">
  <div class="navbar-top">
    <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img" alt="H2SI Logo" /></a>
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
      <a href="notif.php" class="wishlist"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
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
      <li><a href="service_client.php" class="nav-link active">Service client</a></li>
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
  <p>Nom : <span><?= $_SESSION['nom_client'] . ' ' . $_SESSION['prenom_client']; ?></span></p>
  <p>Email : <span><?= $_SESSION['mail_client']; ?></span></p>
  <a href="moncompte.php" class="compte">Mon compte</a>
  <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
</div>

<!-- Section produits -->
<section class="service-client">
  <h2>Service Client</h2>
  <div class="client-container">

    <?= $message_info; ?>

    <form method="post" class="client-form">
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= $_SESSION['nom_client']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="prenom">Prénoms :</label>
        <input type="text" id="prenom" name="prenom" value="<?= $_SESSION['prenom_client']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="email">Adresse Email :</label>
        <input type="email" id="email" name="mail" value="<?= $_SESSION['mail_client']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="tel">Téléphone :</label>
        <input type="tel" id="tel" name="tel" required>
      </div>
      <div class="form-group">
        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="6" placeholder="Décrivez votre demande ici..." required></textarea>
      </div>
      <button type="submit">Envoyer</button>
    </form>

    <div class="contact-infos">
      <h3>Nos coordonnées</h3>
      <p><i class="bi bi-telephone-fill"></i> +225 01 61 04 52 91</p>
      <p><i class="bi bi-telephone-fill"></i> +225 27 23 41 40 33</p>
      <p><i class="bi bi-envelope-fill"></i> <a href="mailto:groupeh2si@gmail.com">groupeh2si@gmail.com</a></p>
      <p><i class="bi bi-geo-alt-fill"></i> Abidjan-Yopougon Sopim, Ancien Bel Air,<br> au-dessus de la pharmacie Nickibel</p>
    </div>
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
</body>
</html>
