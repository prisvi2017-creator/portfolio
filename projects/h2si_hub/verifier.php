<?php
include("sessioneq.php");

if (!isset($_SESSION['id_client'])) {
    // Redirection vers la page de connexion avec un message (facultatif)
    header('Location: connexion_client.php?erreur=connectez-vous-pour-commander');
    exit();
}

$id_client = $_SESSION['id_client'];


if (isset($_POST['commander'])) {
    $nom_client = $_POST["nom_client"];
    $prenom_client = $_POST["prenom_client"];
    $mail_client = $_POST["mail_client"];
    $numero = $_POST["numero"];
    $addresse = $_POST["addresse"];
    $methode = $_POST["methode"];
    $produit = $_POST['produit'];
    $pid = $_POST['pid'];
    $grand_total = $_POST['grand_total'];

    if ($methode === "par carte") {
        $_SESSION['paiement'] = [
            'grand_total' => $grand_total,
            'nom_client' => $nom_client,
            'prenom_client' => $prenom_client,
            'mail_client' => $mail_client,
            'numero' => $numero,
            'addresse' => $addresse,
            'produit' => $produit,
            'pid' => $pid
        ];

        header('Location: paiement_carte.php');
        exit();
    }

    // Le reste du traitement (paiement à la livraison)
    $verify_panier = $con->prepare("SELECT * FROM t_panier WHERE id_client = :id_client");
    $verify_panier->bindParam(":id_client", $id_client);
    $verify_panier->execute();

    if ($verify_panier->rowCount() > 0) {
        $insert_commande = $con->prepare("INSERT INTO t_commande(id, id_client, nom_client, prenom_client, mail_client, numero, addresse, methode, pid, produit, prix ) VALUES(:id, :id_client, :nom_client, :prenom_client, :mail_client, :numero, :addresse, :methode, :pid, :produit, :prix)");
        $insert_commande->bindParam(":id", $id);
        $insert_commande->bindParam(":id_client", $id_client);
        $insert_commande->bindParam(":nom_client", $nom_client);
        $insert_commande->bindParam(":prenom_client", $prenom_client);
        $insert_commande->bindParam(":mail_client", $mail_client);
        $insert_commande->bindParam(":numero", $numero);
        $insert_commande->bindParam(":addresse", $addresse);
        $insert_commande->bindParam(":methode", $methode);
        $insert_commande->bindParam(":pid", $pid);
        $insert_commande->bindParam(":produit", $produit);
        $insert_commande->bindParam(":prix",  $grand_total); 
        $insert_commande->execute();

        $supprimer_panier_id = $con->prepare("DELETE FROM t_panier WHERE id_client = :id_client");
        $supprimer_panier_id->bindParam(":id_client", $id_client);
        $supprimer_panier_id->execute();

        header('location: commande.php');
        exit();
    } else {
        $warning_msg[] = 'Erreur';
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
      <a href="panier.php" class="panier active">
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
  <p>Nom : <span><?php echo $nom_client . ' ' . $prenom_client; ?></span></p>
  <p>Email : <span><?php echo $mail_client; ?></span></p>
  <a href="moncompte.php" class="compte">Mon compte</a>
  <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
</div>

<!--Fin Barre de navigation -->

  
<!--Section produits -->
<section class="checkout">
    <h1 class="title">Passer votre commande</h1>
    <div class="pre_row">
        <?php
        $grand_total = 0;
        $cart_items[] = '';
        // Select cart items for the logged-in client
        $select_panier = $con->prepare("SELECT * FROM t_panier WHERE id_client = :id_client");
        $select_panier->bindParam(":id_client", $id_client);
        $select_panier->execute();  
        if($select_panier->rowCount() > 0){
            while($fetch_panier = $select_panier->fetch(PDO::FETCH_ASSOC)){
                $cart_items[] = $fetch_panier['nom'].' ('.$fetch_panier['prix'].'Fcfa x '. $fetch_panier['quantite'].') - ';
                $produit = implode($cart_items);
                $pid = $fetch_panier['id_pdt'];  
                $total = ($fetch_panier['quantite'] * $fetch_panier['prix']);
                $grand_total += $total;
            }
        }
        ?>
        <div class="row">
            <form method="post">
                <h2>Details Facture</h2>
                <div class="input-bos">
                    <input type="hidden" name="pid" value="<?= $pid; ?>">
                    <input type="hidden" name="produit" value="<?= $produit; ?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">

                    <div class="input-bos">
                        <input type="text" name="nom_client" value="<?= $_SESSION['nom_client']; ?>" style="background-color:#61c0dfbd; color: azure;">
                    </div>

                    <div class="input-bos">
                        <input type="text" name="prenom_client" value="<?= $_SESSION['prenom_client']; ?>" style="background-color:#61c0dfbd; color: azure;">
                    </div>

                    <div class="input-bos">
                        <input type="email" name="mail_client" value="<?= $_SESSION['mail_client']; ?>" style="background-color:#61c0dfbd; color: azure;">
                    </div>

                    <div class="input-bos">
                        <input type="tel" name="numero" placeholder="Entrer un numero de telephone..." required>
                    </div>

                    <div class="input-bos">
                        <input type="text" name="addresse" placeholder="Entrer votre addresse..." required>
                    </div>

                    <div class="input-bose">
                        <p>Mode de paiement</p>
                        <select name="methode" class="input">
                            <option value="à la livraison">à la livraison</option>
                            <option value="par carte">par carte</option>
                        </select>
                    </div>

                    <div class="btn">
                        <input type="submit" name="commander" value="Commander">
                    </div>
                </form>
            </div>
        </div>
  

      </form>
      <div class="summary">
           <h3 class="title">RÉSUMÉ DU PANIER</h3> 
           <div class="box-container">
            <?php 
            $grand_total = 0;
           if (isset($_GET['get_id'])) {
            $select_get = $con->prepare("SELECT * FROM t_produit WHERE id = :id");
            $select_get->bindParam(":id", $get_id);
            $select_get->execute();  
            while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                $total = $fetch_get['prix'];
                $grand_total+=$total;
         
            ?>
            <div class="flex">
                <img src="admin/image/<?=$fetch_get['image']; ?>" width="100"  class="images" >
                <div>
                    <h3 class="nom"><?=$fetch_get['nom_pdt']; ?></h3>
                    <p class="prix"><?=$fetch_get['prix']; ?></p>
                </div>
            </div>
            <?php 
               }
        
              }else{
                $select_panier = $con->prepare("SELECT * FROM t_panier WHERE id_client = :id_client");
                $select_panier->bindParam(":id_client", $id_client);
                $select_panier->execute();  
                  if ($select_panier->rowCount() > 0) {
                    while($fetch_panier = $select_panier->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $con->prepare("SELECT * FROM t_produit WHERE id = :product_id");
                        $select_products->bindParam(':product_id', $fetch_panier['id_pdt']);
                $select_products->execute();  
                $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                $total= ($fetch_panier['quantite']* $fetch_products['prix']);
                $grand_total+= $total;
                  
            ?>
             <div class="flex">
                <img src="admin/image/<?=$fetch_products['image']; ?>" width="100"  class="images" >
                <div>
                    <h3 class="nom"><?=$fetch_products['nom_pdt']; ?></h3>
                    <p class="prix"><?=$fetch_products['prix']; ?>Fcfa X <?=$fetch_panier['quantite']; ?> </p>
                </div>
            <?php 
              }
             }else{
                echo '<p class ="vide">Aucun produit ajouté !';
            }
      }
            ?>
           </div>
           <div class="grand-total"><span>Total à payer: </span><?= $grand_total ?>Fcfa</div>
      </div>
 
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
