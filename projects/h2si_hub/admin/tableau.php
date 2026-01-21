<?php
 include("session.php");
 include("connexion.php");
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>

</head>

<body>

<?php

 $select_admin = $con->prepare("SELECT id FROM t_admin");
 $select_admin->execute();
 $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
 
 $select_admin = $con->prepare("SELECT * FROM t_admin ");
$select_admin ->execute();
$total_admin  = $select_admin ->rowCount();

 $select_clients = $con->prepare("SELECT * FROM t_client ");
$select_clients ->execute();
$total_clients  = $select_clients ->rowCount();

$select_etudiants = $con->prepare("SELECT * FROM t_etudiant ");
$select_etudiants->execute();
$total_etudiants = $select_etudiants->rowCount();

$select_enseignants = $con->prepare("SELECT * FROM t_enseignant ");
$select_enseignants->execute();
$total_enseignants = $select_enseignants->rowCount();

$select_produit = $con->prepare("SELECT * FROM t_produit ");
$select_produit ->execute();
$total_produit  = $select_produit ->rowCount();

$select_commandes = $con->prepare("SELECT * FROM t_commande ");
$select_commandes ->execute();
$total_commandes  = $select_commandes ->rowCount();

$select_messages = $con->prepare("SELECT * FROM t_message ");
$select_messages ->execute();
$total_messages  = $select_messages ->rowCount();
 ?>
<!--barre de Navigation-->
<div class="container">
    <div class="navigation">
       <ul>
         <li>
            <a href="#">
                <span class="icon">
                <ion-icon name="desktop-outline"></ion-icon>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
         </li>

         
         <li>
            <a href="client.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Client</span>
            </a>
         </li>

         <li>
            <a href="produit.php">
                <span class="icon">
                    <ion-icon name="storefront-outline"></ion-icon>
            </span>
                <span class="title">Produits</span>
            </a>
         </li>

         <li>
            <a href="commandes.php">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <span class="title">Commandes</span>
            </a>
         </li>


         
         <li>
            <a href="etudiant.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Etudiants</span>
            </a>
         </li>
         <li>
            <a href="enseignant.php">
                <span class="icon">
                    <ion-icon name="person-sharp"></ion-icon>
                </span>
                <span class="title">Enseignant</span>
            </a>
         </li>
         <li>
            <a href="formation.php">
                <span class="icon">
                    <ion-icon name="document-attach-outline"></ion-icon>
                </span>
                <span class="title">Formations</span>
            </a>
         </li>

         <li>
            <a href="newsletter.php">
                <span class="icon">
                <ion-icon name="newspaper-outline"></ion-icon>              
              </span>
                <span class="title">Newsletter</span>
            </a>
         </li>


         <li>
            <a href="message.php">
                <span class="icon">
                <ion-icon name="mail-unread-outline"></ion-icon>
                </span>
                <span class="title">Messages</span>
            </a>
         </li>


         <li>
            <a href="deconnexion.php">
                <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="title">Deconnexion</span>
            </a>
         </li>
       </ul>
    </div>
</div>

<div class="menu">
   <div class="topbar">


   <div class="toggle">
   <ion-icon name="menu-outline"></ion-icon>
   </div>

   <div class="search">
     <label>
        <input type="text" placeholder="Que recherchez-vous?">
        <ion-icon name="search-outline"></ion-icon>
     </label>
   </div>
   
   <div class="Bienvenue">
   <p>Bienvenue,<span><?php echo "$prenom_ad" ?></span></p>
   </div>

   <div class="user" id="user-btn">

   <?php
        $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {        
         echo '<img  src="id/'.$fetch['image'].'">';  
       }  
      ?>

   </div>
   <div class="profile">

   <?php
        $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {        
         echo '<img class="image"  src="id/'.$fetch['image'].'">';  
       }  
      ?>
         <h3 class="name"><?= "$nom_ad  $prenom_ad"; ?></h3>
         <div class="flex-btn">
            <a href="profil.php" class="option-btn">Modifier profil</a>
            <a href="adminn.php" class="option-btn">Nouvel admin</a>
         </div>

      </div>


   </div>
   <section class="dashboard">

<h1 class="heading">Tableau de bord</h1>

<div class="box-container">

   <div class="box">
      <h3>Bienvenue!</h3>
      <p><?= $prenom_ad; ?></p>
      <a href="profil.php" class="btn">Modifier le profil</a>
   </div>

   <div class="box">
      <h3>Admins</h3>
      <p><?= $total_admin; ?></p>
      <a href="administrateur.php" class="btn">liste admins</a>
   </div>

   <div class="box">
      <h3>total clients</h3>
      <p><?= $total_clients; ?></p>
      <a href="client.php" class="btn">voir liste clients</a>
   </div>

   <div class="box">
      <h3>Total etudiants</h3>
      <p><?= $total_etudiants; ?></p>
      <a href="etudiant.php" class="btn">voir liste etudiants</a>
   </div>

   <div class="box">
      <h3>Total enseignants</h3>
      <p><?= $total_enseignants; ?></p>
      <a href="ajouterprof.php" class="btn">ajouter un enseignant</a>
   </div>

   <div class="box">
      <h3>Total produits</h3>
      <p><?= $total_produit; ?></p>
      <a href="ajouterproduit.php" class="btn">ajouter produit</a>
   </div>

   <div class="box">
      <h3>Commandes</h3>
      <p><?= $total_commandes; ?></p>
      <a href="commandes.php" class="btn">voir commandes</a>
   </div>


   <div class="box">
      <h3>Messages</h3>
      <p><?= $total_messages; ?></p>
      <a href="message.php" class="btn">Voir les messages</a>
   </div>

   
</div>

</section>
</div>

<script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}
</script>

<script src="menu.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>