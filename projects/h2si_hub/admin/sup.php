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
   <a href="ajouterformation.php"><button class="btn-aj">Ajouter une formation</a></button>

   <section style="display: grid;
   grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
   gap:1rem;">
   
   <?php

$select = $con->prepare("SELECT * FROM t_formation ");
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
        <td>Formation</td>
        <td style='background-color: #fff;'></td>
		<td style='background-color: #fff;'></td>
     </tr>

     <?php
       if ($select->rowCount() > 0) {
        while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
            $formation_id = $fetch['id'];
      ?>
   
<tr>
       
        <td><?= $formation_id; ?></td>
        <td class='tab2'><?=$fetch['nom_form']; ?></td>
        <td class='btn-sup'><a href='supprimform.php?supprime=<?= $formation_id; ?>'>supprimer</a></td>
        <td class='btn-mod'><a href='modiform.php?modifie=<?= $formation_id; ?>'>Modifier</a></td>
       
 </tr>
 <?php 
 }
}
 ?>

</table>

<?php

$select = $con->prepare("SELECT * FROM t_playlist  ");
$select->execute();

if(isset($_GET['supprime'])){
    $id = $_GET['supprime'];
    include("connexion.php");
$sup="DELETE FROM t_playlist WHERE id='$id'";
$rep=$con->exec($sup);
if($rep)
$success_msg[] = 'playlist supprimé avec succès!';
else
$warning_msg[] = 'Echec !';
};

?>

    </div>

   <div style="margin-top: 60px;
                margin-left: 28px;
                height: auto;
    background-color: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,0.25);
    border-radius: 5px;">
   <table  border='0' width='98%'>
     <tr class='con'>    
        <td>Id Enseignant </td>
        <td>Playlist</td>
        <td>Formation</td>
        <td>Publication</td>
		<td style='background-color: #fff;'></td>
        <td style='background-color: #fff;'></td>
     </tr>
     <?php
       if ($select->rowCount() > 0) {
        while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
            $id_playlist = $fetch['id'];
            $id_enseignant = $fetch['id_enseignant'];

            $select_enseignant = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id_enseignant");
            $select_enseignant->bindParam(":id_enseignant", $id_enseignant);
            $select_enseignant->execute();
            $fetch_enseignant = $select_enseignant->fetch(PDO::FETCH_ASSOC);
      ?>

     <tr>
       
       <td ><img src="imgprof/<?php echo $fetch_enseignant['image']; ?>"height="40" style="padding:7px;border-radius:50%;">
       <p style=" font-size: 10px;
   font-weight: 600;
   color: #000;
   display: flex;
   justify-content: right;
   margin-top: -30px;
   
   "><?php echo $fetch_enseignant['nom_prof']. ' ' . $fetch_enseignant['prenom_prof']; ?></p></td>
       <td class='tab1'><?=$fetch['titre']; ?></td>
       <td ><?=$fetch['nom_form']; ?></td>
       <td class='tab2'><?=$fetch['date']; ?></td>
       <td class='btn-mod'><a href="voirplaylist.php?id_playlist=<?= $id_playlist; ?>" class="btn">Voir playlist</a></td>
       <td class='btn-sup'><a href="sup.php?supprime=<?= $id_playlist; ?>" class="btn">Supprimer</a></td>
      
</tr>

<?php 
 }
}
 ?>

</table>



   </div>


    </section>
	
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