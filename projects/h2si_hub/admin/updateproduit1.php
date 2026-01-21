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
            <a href="tableau1.php">
                <span class="icon">
                <ion-icon name="desktop-outline"></ion-icon>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
         </li>

         

         <li>
            <a href="#">
                <span class="icon">
                    <ion-icon name="storefront-outline"></ion-icon>
            </span>
                <span class="title">Produits</span>
            </a>
         </li>

         <li>
            <a href="commande.php">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <span class="title">Commandes</span>
            </a>
         </li>

       
         <li>
            <a href="etudiant1.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Etudiants</span>
            </a>
         </li>
         

         <li>
            <a href="newsletter1.php">
                <span class="icon">
                <ion-icon name="newspaper-outline"></ion-icon>              
              </span>
                <span class="title">Newsletter</span>
            </a>
         </li>


         <li>
            <a href="message1.php">
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
            <a href="profil1.php" class="option-btn">Modifier profil</a>
         </div>

      </div>

   </div>
  
  
  
  <a href="ajouterproduit1.php"><button class="btn-aj">Ajouter un produit</a></button>


  <?php  
 

    if(isset($_POST['submit'])){
      $id = $_POST['id'];
	$nom_pdt = $_POST['nom_pdt'];
	$prix = $_POST['prix'];
	$detail_pdt = $_POST['detail_pdt'];
	
    include("connexion.php");

    if(!empty($nom_pdt)){
        $update_nom = $con->prepare("UPDATE t_produit SET nom_pdt =:nom_pdt WHERE id = :id");
        $update_nom ->bindParam(":nom_pdt", $nom_pdt);
        $update_nom ->bindParam(":id", $id);
        $update_nom ->execute();
       $success_msg[] = 'nom modifié avec succès!';
     }
	
     if(!empty($prix)){
        $update_prix = $con->prepare("UPDATE t_produit SET prix =:prix WHERE id = :id");
        $update_prix ->bindParam(":prix", $prix);
        $update_prix ->bindParam(":id", $id);
        $update_prix->execute();
       $success_msg[] = 'prix modifié avec succès!';
     }
     $ancien_image = $_POST['ancien_image'];
     $image = $_FILES['image']['name'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_folder = 'image/'.$image;

     if(!empty($image)){
           $update_image = $con->prepare("UPDATE t_produit SET image = :image  WHERE id = :id");
           $update_image->bindParam(":image", $image);
           $update_image->bindParam(":id", $id);
           $update_image->execute();
           move_uploaded_file($image_tmp_name, $image_folder);
           if($ancien_image != '' AND $ancien_image != $image){
              unlink('image/'.$ancien_image);
           }
        $success_msg[] = 'image modifié avec succès!';  
    }

    if(!empty($detail_pdt)){
        $update_detail = $con->prepare("UPDATE t_produit SET detail_pdt =:detail_pdt WHERE id = :id");
        $update_detail ->bindParam(":detail_pdt", $detail_pdt);
        $update_detail ->bindParam(":id", $id);
        $update_detail->execute();
       $success_msg[] = 'details modifié avec succès!';
     } 

}
	?>
  
<?php

$select = $con->prepare("SELECT * FROM t_produit ");
$select->execute();
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
        <td>Nom Produit</td>
        <td>Prix</td>
        <td>Image</td>
        <td>Details</td>
        <td></td>
		<td></td>

     </tr>
     <?php
       if ($select->rowCount() > 0) {
        while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
            $produit_id = $fetch['id'];
      ?>
     
     <tr>
        <td class='tab1'><?=$produit_id; ?></td>
        <td class='tab2'><?=$fetch['nom_pdt']; ?></td>
        <td><?=$fetch['prix']; ?>Fcfa</td>
        <td >
            <img src="image/<?= $fetch['image']; ?>"height="80" style="border-radius:5%;" alt="">
        </td>
        <td class='tab1'><?=$fetch['detail_pdt']; ?></td>
        <td class='btn-sup'><a href="supprimerproduit1.php?supprime=<?= $produit_id; ?>">Supprimer</a></td>
        <td class='btn-mod'><a href="modifierproduit1.php?modifie=<?= $produit_id; ?>"> Modifier</a></td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
 </body>
 

 
</html>