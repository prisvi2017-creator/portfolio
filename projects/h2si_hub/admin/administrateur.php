<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>
<?php
 include("session.php");
 include("connexion.php");
?>

</head>



<body>

<div class="container">
    <div class="navigation">
       <ul>
         <li>
            <a href="tableau.php">
                <span class="icon">
                <ion-icon name="desktop-outline"></ion-icon>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
         </li>

         
         <li>
            <a href="Client.php">
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
  
   <?php

$select = $con->prepare("SELECT * FROM t_admin ");
$select->execute();

if(isset($_POST['modifier'])){

    $ad_id = $_POST['ad_id'];
    $nouveau_statut = $_POST['statut'];
 
    
 
    $update_statut = $con->prepare("UPDATE t_admin SET statut = :nouveau_statut WHERE id = :id");
    $update_statut->bindParam(":nouveau_statut", $nouveau_statut);
    $update_statut->bindParam(":id", $ad_id);
    $update_statut->execute();
    $success_msg[] = 'Statut modifié avec succès!';
 }
?>

   <div style="margin-top: 95px;
                margin-left: 28px;
                height: auto;
    background-color: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,0.25);
    border-radius: 5px;">
<br><br>

<table  border='0' width='98%'>
     <tr class='con'>
     
        <td>N</td>
        <td>Nom et Prénoms</td>
        <td>Photo</td>
        <td>Statut</td>
        <td style="background-color:#fff;"></td>
        <td style="background-color:#fff;"></td>
     </tr>

     <?php
       if ($select->rowCount() > 0) {
        while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
            $admin_id = $fetch['id'];
      ?>

<tr>
        <td class='tab1'><?=$fetch['id']; ?></td>
        <td class='tab2'><?= $fetch['nom_ad']. ' ' . $fetch['prenom_ad']; ?></td>
        <td style="  display: flex;
   justify-content: center;
   padding: 3px;
   background-color: #fff;">
            <img src="id/<?= $fetch['image']; ?>"height="80" style="border-radius:50%;" alt="">
        </td>
        <td> <form action="" method="POST">
        <input type="hidden" name="ad_id" value="<?=$admin_id; ?>">
        <select name="statut" class="drop-down">
            <option value="" selected disabled><?= $fetch['statut']; ?></option>
            <option value="admin">Admin</option>
            <option value="utilisateur">Utilisateur</option>
         </select></td>
         <td class='btn-mod' style="background-color: darkorange;" ><input style=" background: transparent;
  border: none;
  outline: none;
  cursor: pointer;" type="submit" value="MàJ" class="btn"  onclick="return confirm('confirmer?')" name="modifier"></td>

        <td class='btn-sup'><a href="supprimeradmin.php?supprime=<?= $admin_id; ?>" onclick="return confirm('supprimer?');">Supprimer</a></td>
    
 </tr>

 <?php 
 }
}
 ?>

</table>

    </div>
	
   </div>
	
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