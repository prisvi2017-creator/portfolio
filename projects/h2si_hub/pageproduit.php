<?php
 include("sessioneq.php");

// ===== Traitement ajout d'avis =====
if (isset($_POST['ajouter_avis'])) {
    $id_produit = $_POST['id_produit'];
    $note = intval($_POST['note']);
    $commentaire = htmlspecialchars($_POST['commentaire']);

    $insert_avis = $con->prepare("INSERT INTO t_avis (id_client, id_produit, note, commentaire) 
                                  VALUES (:id_client, :id_produit, :note, :commentaire)");
    $insert_avis->execute([
        ':id_client' => $id_client,
        ':id_produit' => $id_produit,
        ':note' => $note,
        ':commentaire' => $commentaire
    ]);

    echo "<script>alert('Merci pour votre avis !');</script>";
}



?>

<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<meta http-equiv="X-UA-Compatible" content="IE=chrome">
<title>H2SI HUB</title>
<link rel="icon" href="Images/icone.png">
<link rel="stylesheet" href="styl.css">

<style>
/* === Styles produits === */
form .images {
  max-width: 100%;
  width: 270px;
  border-radius: 10px;
  object-fit: cover;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.lesdetails { flex: 1 1 300px; display: flex; flex-direction: column; gap: 10px; }
.leprix { font-size: 1.5rem; font-weight: bold; color: #e81010; }
.lenom { font-size: 1.2rem; font-weight: 600; color: #333; }
.a_propos p { font-size: 1rem; line-height: 1.5; color: #444; background: #f5f5f5; padding: 10px; border-radius: 8px; }
.button { display: flex; gap: 10px; align-items: center; }
.button button { background: #7EBB40; color: white; border: none; padding: 10px 15px; border-radius: 50px; cursor: pointer; font-size: 1.1rem; transition: 0.3s; }
.button button:hover { background: #5a9631; }
.button .quantite { display: none; }
.btn_buy { display: inline-block; margin-top: 20px; padding: 12px 20px; background: #e81010; color: white; font-weight: 600; border-radius: 8px; text-decoration: none; transition: 0.3s; }
.btn_buy:hover { background: #a50d0d; }
@media (max-width: 768px) {
  form { flex-direction: column; align-items: center; padding: 15px; }
  .button { justify-content: center; flex-wrap: wrap; }
  .btn_buy { width: 100%; text-align: center; }
}

.comment{
  resize: none;
  width: 100%;
  height: 200px;
  border: 2px solid #7EBB40;
}

/* === Styles avis === */
.avis-section, .avis-liste {
  margin-top: 30px;
  padding: 15px;
  background: #f9f9f9;
  border-radius: 10px;
}
.avis-section h3, .avis-liste h3 { margin-bottom: 15px; color: #333; }
.un-avis {
  margin-bottom: 15px; padding: 10px;
  background: #fff; border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* === Etoiles interactives === */
.star-rating {
  display: inline-flex;
  font-size: 35px;
  cursor: pointer;
}
.star {
  color: #ccc;
  transition: color 0.2s;
}
.star.filled {
  color: gold;
}

.note-globale h4 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #333;
}
.note-globale .star {
    font-size: 25px;
    margin-right: 2px;
}

</style>
</head>
<body>

<!-- Barre de navigation -->
<div class="navbar-container">
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
      <a href="notif.php" class="wishlist"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
      <i class="bi bi-person-fill" id="person-icon"></i>
    </div>
  </div>
  <nav class="sidebar">
    <ul class="nav-links">
      <li><a href="moncompte.php" class="nav-link">Mon compte</a></li>
      <li><a href="eqconnect.php" class="nav-link active">Produits</a></li>
      <li><a href="presentation.php" class="nav-link">Catégories</a></li>
      <li><a href="commande.php" class="nav-link">Commandes</a></li>
      <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
      <li><a href="service_client.php" class="nav-link">Service client</a></li>
      <li><a href="faq.php" class="nav-link">À propos</a></li>
    </ul>
  </nav>
</div>

<!-- Section produit -->
<section class="voir_page">
   <?php
    if(isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        $select_products = $con->query("SELECT * FROM `t_produit` WHERE id ='$pid'");
        if ($select_products->rowCount()>0) {
          while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

            $note_data = $con->prepare("SELECT AVG(note) AS moyenne, COUNT(*) AS total FROM t_avis WHERE id_produit = :id_produit");
$note_data->execute([':id_produit' => $fetch_products['id']]);
$note_info = $note_data->fetch(PDO::FETCH_ASSOC);

$moyenne = round($note_info['moyenne'], 1); // moyenne arrondie
$total_avis = $note_info['total'];
   ?>
            <form method="post">
                <img src="admin/image/<?php echo $fetch_products['image']; ?>" class="images">
                <div class="lesdetails">
                   <div class="leprix"><?php echo $fetch_products['prix']; ?> FCFA</div>
                   <div class="lenom"><?php echo $fetch_products['nom_pdt']; ?></div>
                   <div class="a_propos"><p><?php echo $fetch_products['detail_pdt']; ?></p></div>
                   <input type="hidden" name="id_pdt" value="<?php echo $fetch_products['id']; ?>">
                   <div class="button">
                     <button type="submit" name="ajouter_au_panier"><i class="bi bi-bag-check-fill"></i></button>
                     <input type="hidden" name="quantite" value="1" class="quantite">
                     <button type="submit" name="ajouter_a_wishlist"><i class="bi bi-heart-fill"></i></button>
                   </div>
                </div>

                <div class="note-globale">
    <h4>Note moyenne : 
        <?php
        for($i=1;$i<=5;$i++){
            if($i <= floor($moyenne)){
                echo '<span class="star filled">&#9733;</span>';
            } elseif($i - $moyenne < 1){
                echo '<span class="star" style="position: relative; display: inline-block;">
                        <span style="width:'.(($moyenne-floor($moyenne))*100).'%; overflow:hidden; display:inline-block; color: gold;">&#9733;</span>
                        <span style="color:#ccc;">&#9733;</span>
                      </span>';
            } else {
                echo '<span class="star">&#9733;</span>';
            }
        }
        ?>
        (<?= $moyenne ?> / 5 - <?= $total_avis ?> avis)
    </h4>
</div>

                <a href="verifier.php?get_id=<?= $fetch_products['id']; ?>" class="btn_buy">Commander</a>
            </form>

            <!-- === Formulaire d'avis === -->
            <div class="avis-section">
              <h3>Laisser un avis</h3>
              <form method="post">
               <div class="star-rating">
  <span class="star select-star" data-value="1">&#9733;</span>
  <span class="star select-star" data-value="2">&#9733;</span>
  <span class="star select-star" data-value="3">&#9733;</span>
  <span class="star select-star" data-value="4">&#9733;</span>
  <span class="star select-star" data-value="5">&#9733;</span>
</div>
<input type="hidden" name="note" id="note" value="0">


                <br><br>
                <label for="commentaire">Votre avis :</label><br>
                <textarea name="commentaire" class="comment" id="commentaire" rows="4" required></textarea><br><br>

                <input type="hidden" name="id_produit" value="<?php echo $fetch_products['id']; ?>">
                <button type="submit" name="ajouter_avis" class="btn_buy">Envoyer</button>
              </form>
            </div>

            <!-- === Liste des avis === -->
            <div class="avis-liste">
              <h3>Avis des clients</h3>
              <?php
              $avis_query = $con->prepare("SELECT a.*, c.nom_client, c.prenom_client 
                                           FROM t_avis a 
                                           JOIN t_client c ON a.id_client = c.id
                                           WHERE a.id_produit = :id_produit 
                                           ORDER BY a.date_avis DESC");
              $avis_query->execute([':id_produit' => $pid]);
              if ($avis_query->rowCount() > 0) {
                  while ($avis = $avis_query->fetch(PDO::FETCH_ASSOC)) {
                      echo "<div class='un-avis'>";
                      echo "<strong>" . htmlspecialchars($avis['nom_client']) . " " . htmlspecialchars($avis['prenom_client']) . "</strong><br>";
                      echo "Note : " . str_repeat("⭐", $avis['note']) . "<br>";
                      echo "<p>" . nl2br(htmlspecialchars($avis['commentaire'])) . "</p>";
                      echo "<small>Posté le " . $avis['date_avis'] . "</small>";
                      echo "</div>";
                  }
              } else {
                  echo "<p>Aucun avis pour ce produit.</p>";
              }
              ?>
            </div>
   <?php
          }
        }
    }
   ?>
   <a href="eqconnect.php"><i class="bi bi-box-arrow-right"></i></a>
</section>

<script>
// Script étoiles cliquables
const stars = document.querySelectorAll('.select-star');
const noteInput = document.getElementById('note');

stars.forEach(star => {
  star.addEventListener('click', function() {
    let value = this.getAttribute('data-value');
    noteInput.value = value;

    // Reset
    stars.forEach(s => s.classList.remove('filled'));

    // Remplir les étoiles jusqu'à la valeur choisie
    for (let i = 0; i < value; i++) {
      stars[i].classList.add('filled');
    }
  });
});

</script>

<script src="box.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
