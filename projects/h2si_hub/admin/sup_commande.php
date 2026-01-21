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

   <?php

$select = $con->prepare("SELECT * FROM t_commande ");
$select->execute();

if(isset($_GET['supprime'])){
    $id = $_GET['supprime'];
    include("connexion.php");
$sup="DELETE FROM t_commande WHERE id='$id'";
$rep=$con->exec($sup);
if($rep)
$success_msg[] = 'commande supprimé avec succès!';
else
$warning_msg[] = 'Echec !';
};
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
        
        <td>Nom et Prénoms</td>
        <td>Email</td>
        <td>Adresse</td>
        <td>Tel</td>
        <td>Produit(s)</td>
        <td>Montant</td>
        <td>Mode de paiement</td>
        <td>Statut</td>
        <td style='background-color: #fff;'></td>
		<td style='background-color: #fff;'></td>
     </tr>

     <?php
       if ($select->rowCount() > 0) {
        while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
            $client_id = $fetch['id'];
      ?>

     <tr>
       
        <td class='tab2'><?= $fetch['nom_client']. ' ' . $fetch['prenom_client']; ?></td>
        <td><?=$fetch['mail_client']; ?></td>
        <td class='tab1'><?=$fetch['addresse']; ?></td>
        <td>0<?=$fetch['numero']; ?></td>
        <td class='tab2'><?=$fetch['produit']; ?></td>
        <td style="color: red;font-weight:800;" ><?=$fetch['prix']; ?>Fcfa</td>
        <td class='tab1'><?=$fetch['methode']; ?></td>
        <td> <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch['id']; ?>">
         <select name="statut_cmde" class="drop-down">
            <option value="" selected disabled><?= $fetch['statut_cmde']; ?></option>
            <option value="en cours">En cours</option>
            <option value="annuler">Annuler</option>
            <option value="Valider">Valider</option>
         </select></td>
        <td class='btn-sup'><a href='sup_commande.php?supprime=<?=$client_id; ?>'>Supprimer</a></td>
        <td class='btn-mod'><a href=''>Mettre à jour</a></td>
        </form> 
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