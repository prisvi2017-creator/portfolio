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
            <a href="produit1.php">
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
            <a href="#">
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
   <form action="recherche_et1.php" method="post">
     <label>
        <input type="text" name="search" placeholder="Que recherchez-vous?">
        <ion-icon name="search-outline"  name="search_btn"></ion-icon>
     </label>
     </form>
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
  
   <a href="#"><button class="btn-aj">Scolarite etudiant</a></button>

   <a href="archives.php"><button class="btn-ac">Archive etudiant</a></button>


   <?php



if(isset($_POST['modifier'])){

   $et_id = $_POST['et_id'];
   $nouveau_statut = $_POST['statut'];

   // Récupérer l'ancien statut de l'étudiant
   $stmt = $con->prepare("SELECT statut FROM t_etudiant WHERE id = :etudiant_id");
   $stmt->bindParam(":etudiant_id", $et_id);
   $stmt->execute();
   $ancien_statut_row = $stmt->fetch(PDO::FETCH_ASSOC);
   $ancien_statut = $ancien_statut_row['statut'];

   // Mettre à jour le statut de l'étudiant
   $update_statut = $con->prepare("UPDATE t_etudiant SET statut = :nouveau_statut WHERE id = :id");
   $update_statut->bindParam(":nouveau_statut", $nouveau_statut);
   $update_statut->bindParam(":id", $et_id);
   $update_statut->execute();

   $stmt = $con->prepare("SELECT * FROM t_etudiant WHERE id = :etudiant_id");
   $stmt->bindParam(":etudiant_id", $et_id);
   $stmt->execute();
   $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

   // Archiver l'ancien statut
   $stmt = $con->prepare("INSERT INTO t_archives (id_etudiant, nom_et, prenom_et, image, formation, statut_precedent, nouveau_statut, date) VALUES (:id_etudiant, :nom_et, :prenom_et, :image, :formation, :ancien_statut, :nouveau_statut, NOW())");
   $stmt->bindParam(":id_etudiant", $et_id);
   $stmt->bindParam(":nom_et", $fetch['nom_et']);
   $stmt->bindParam(":prenom_et", $fetch['prenom_et']);
   $stmt->bindParam(":image", $fetch['image']);
   $stmt->bindParam(":formation",  $fetch['nom_form']);
   $stmt->bindParam(":ancien_statut", $ancien_statut);
   $stmt->bindParam(":nouveau_statut", $nouveau_statut);
   $stmt->execute();

   $success_msg[] = 'Statut modifié avec succès!';
}

?>




<?php
if(isset($_POST['search']) or isset($_POST['search_btn'])){
    $search = $_POST['search'];
    $select_etudiant = $con->prepare("SELECT * FROM t_etudiant WHERE nom_et LIKE :search OR prenom_et LIKE :search ORDER BY date DESC");
    $select_etudiant->execute(['search' => "%$search%"]);
      $select_etudiant->execute();
    
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
        <td>Email</td>
        <td>Sexe</td>
        <td>Formation</td>
        <td>tel</td>
        <td>Statut</td>
        <td>Action</td>
     </tr>

     <?php
        if($select_etudiant->rowCount() > 0){
            while($fetch = $select_etudiant->fetch(PDO::FETCH_ASSOC)){ 
               $id_etudiant = $fetch['id'];
      ?>

     <tr>
        <td class='tab1'><?=$id_etudiant; ?></td>
        <td class='tab2'><?=$fetch['nom_et'] . ' ' . $fetch['prenom_et']; ?></td>
        <td style="  display: flex;
   justify-content: center;
   padding: 3px;
   background-color: #fff;">
            <img class="image_etudiant" src="../etudiant/<?= $fetch['image']; ?>  "height="80" width="90" style="border-radius:50%;" alt="">
        </td>
        <td><?=$fetch['mail_et']; ?></td>
        <td class='tab1'><?=$fetch['sexe']; ?></td>
        <td><?=$fetch['nom_form']; ?></td>
        <td class='tab2'>0<?=$fetch['tel_et']; ?></td>
        <td> <form action="" method="POST">
        <input type="hidden" name="et_id" value="<?=  $id_etudiant; ?>">
        <select name="statut" class="drop-down">
            <option value="" selected disabled><?= $fetch['statut']; ?></option>
            <option value="initie">initié</option>
            <option value="Validerpourpaiement">valider pour paiement</option>
            <option value="verification">vérification</option>
            <option value="encours">en cours</option>
            <option value="rejete">rejété</option>
            <option value="inscris">inscris</option>
         </select></td>
        <td class='btn-mod' style="background-color: darkorange;" ><input style=" background: transparent;
  border: none;
  outline: none;
  cursor: pointer;" type="submit" value="MàJ" class="btn"  onclick="return confirm('confirmer?')" name="modifier"></td>

</form> 
 </tr>
 <?php
         }
        }else{
           echo '<p class="empty">Aucun etudiant trouvé!</p>';
        }
     }else{
        echo '<p class="empty">Chercher quelque chose!</p>';
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