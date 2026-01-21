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

   <div class="form-container">

   <?php
$id = $_GET["modifie"];
include("connexion.php");
$select_produit = $con->prepare("SELECT * FROM t_produit WHERE id = :id ");
$select_produit->bindParam(":id", $id);
$select_produit->execute();
if($select_produit->rowCount() > 0){
while($fetch_produit = $select_produit->fetch(PDO::FETCH_ASSOC)){
   $id_produit = $fetch_produit['id'];

	?>

  <form  action="updateproduit.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="ancien_image" value="<?=$fetch_produit['image']; ?>">
  <input type=text name="id" value="<?=$id_produit; ?>" >
  <input  style="margin-top: 30px;" type="text" name="nom_pdt"  placeholder="<?=$fetch_produit['nom_pdt']; ?>" class="box">

  <select name="categorie" class="box" style="margin-top: 30px;">
   <option value="<?= $fetch_produit['categorie']; ?>" selected><?= $fetch_produit['categorie']; ?></option>
   <option value="Dentiste">Dentiste</option>
   <option value="Chirurgien">Chirurgien</option>
   <option value="Gynécologue">Gynécologue</option>
   <option value="Infirmier">Infirmier</option>
   <option value="Technicien de laboratoire">Technicien de laboratoire</option>
   <option value="Toutes specialites">Toutes specialites</option>

</select>

	<input  style="margin-top: 30px;" type="text" name="prix" placeholder=" <?=$fetch_produit['prix']; ?>" class="box">
    <input style="margin-top: 30px;" type="file"  name="image" >
    <img src="image/<?= $fetch_produit['image']; ?>" width="100">
    <textarea style="margin-top: 30px;" name="detail_pdt" placeholder="<?=$fetch_produit['detail_pdt']; ?>"  id="" cols="30" rows="10"></textarea>
   <input style="margin-top: 50px;" type="submit" name="submit"  value="Modifier" class="btn">
   <a href="produit.php"><button class="btn-rt">Retour</a></button>
  </form>
  <?php
      } 
   }else{
      echo '<p class="empty">Aucune playlist disponible!</p>';
   }
   ?>
   
	   </div>
	
   	</div>

       <script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}
</script>

<script src="menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
 </body>
 

 
</html>