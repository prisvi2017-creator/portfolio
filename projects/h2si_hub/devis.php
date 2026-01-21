<?php
include("sessioneq.php");

// Vérifier que le client est connecté
if (!isset($_SESSION['id_client'])) {
    header("Location: connexion_client.php?erreur=connectez-vous pour demander un devis!");
    exit();
}

$id_client = $_SESSION['id_client'];

// Traitement du formulaire
$devis_info = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_client     = htmlspecialchars(trim($_POST['nom_client']));
    $mail_client    = htmlspecialchars(trim($_POST['mail_client']));
    $numero    = htmlspecialchars(trim($_POST['numero']));
    $societe = htmlspecialchars(trim($_POST['societe']));
    $type_pdt = htmlspecialchars(trim($_POST['type_pdt']));
    $details = htmlspecialchars(trim($_POST['details']));

    

    if (!empty($nom_client) && !empty($mail_client) && !empty($numero) && !empty($societe) && !empty($type_pdt) && !empty($details)) {
        try {
            $sql = "INSERT INTO t_devis (id_client, nom_client, mail_client, numero, societe, type_pdt, details) 
                    VALUES (:id_client, :nom_client, :mail_client, :numero, :societe, :type_pdt, :details)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->bindParam(':nom_client', $nom_client);
            $stmt->bindParam(':mail_client', $mail_client);
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':societe', $societe);
            $stmt->bindParam(':type_pdt', $type_pdt);
            $stmt->bindParam(':details', $details);
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
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
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
      <li><a href="devis.php" class="nav-link active">Demandes de devis</a></li>
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
    <?php if (isset($_SESSION['id_client'])): ?>
        <p>Nom : <span><?= htmlspecialchars($nom_client . ' ' . $prenom_client) ?></span></p>
        <p>Email : <span><?= htmlspecialchars($mail_client) ?></span></p>
        <a href="moncompte.php" class="compte">Mon compte</a>
        <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
    <?php else: ?>
        <a href="connexion_client.php" class="compte">Se connecter / S'inscrire</a>
    <?php endif; ?>
</div>

<!-- Section devis -->
<section class="devis-section">
  <?= $devis_info; ?>

  <h2>Demande de devis</h2>

  
    <p>Remplissez le formulaire ci-dessous pour recevoir une estimation personnalisée.</p>

    <form  method="post" class="devis-form">
      <div class="form-group">
        <label for="nom">Nom complet</label>
        <input type="text" name="nom_client" value="<?= $_SESSION['nom_client'] . ' ' . $_SESSION['prenom_client']; ?>" style="background-color:#61c0dfbd; color: azure;" id="nom" required>
      </div>

      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input type="email" name="mail_client" value="<?= $_SESSION['mail_client']; ?>" style="background-color:#61c0dfbd; color: azure;" id="email" required>
      </div>

      <div class="form-group">
        <label for="telephone">Numéro de téléphone</label>
        <input type="tel" name="numero" id="telephone" required>
      </div>

      <div class="form-group">
        <label for="societe">Nom de la société</label>
        <input type="text" name="societe" id="societe">
      </div>

      <div class="form-group">
        <label for="type">Type de produit souhaité</label>
        <select name="type_pdt" id="type" required>
          <option value="">-- Sélectionnez --</option>
          <option value="tube">Tube</option>
          <option value="microscope">Microscope</option>
          <option value="eprouvettes">Éprouvette</option>
          <option value="gants">Gants</option>
        </select>
      </div>

      <div class="form-group">
        <label for="message">Détaillez votre demande</label>
        <textarea name="details" id="message" rows="5" placeholder="Décrivez vos besoins ici..." required></textarea>
      </div>

      <button type="submit" class="btn-devis">Envoyer la demande</button>
    </form>
  
</section>

<script src="box.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
