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
 

    if(isset($_POST['submit'])){

       
      $id = $_POST['id'];
	$nom_prof = $_POST['nom_prof'];
    $prenom_prof = $_POST['prenom_prof'];
    $mail_prof = $_POST['mail_prof'];
	
	
    include("connexion.php");

    $select_enseignant = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id");
    $select_enseignant ->bindParam(":id", $id);
    $select_enseignant ->execute();
    $fetch_enseignant  = $select_enseignant ->fetch(PDO::FETCH_ASSOC); 
    $prev_pass = $fetch_enseignant ['mdp_prof'];

    if(!empty($nom_prof)){
        $update_nom = $con->prepare("UPDATE t_enseignant SET nom_prof =:nom_prof WHERE id = :id");
        $update_nom ->bindParam(":nom_prof", $nom_prof);
        $update_nom ->bindParam(":id", $id);
        $update_nom ->execute();
       $success_msg[] = 'nom modifié avec succès!';
     }
	
     if(!empty($prenom_prof)){
        $update_prenom = $con->prepare("UPDATE t_enseignant SET prenom_prof =:prenom_prof WHERE id = :id");
        $update_prenom ->bindParam(":prenom_prof", $prenom_prof);
        $update_prenom ->bindParam(":id", $id);
        $update_prenom->execute();
       $success_msg[] = 'prenom modifié avec succès!';
     }
     $ancien_image = $_POST['ancien_image'];
     $image = $_FILES['image']['name'];
     $image_size = $_FILES['image']['size'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_folder = 'imgprof/'.$image;

     if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'image trop large!';
        }else{
           $update_image = $con->prepare("UPDATE t_enseignant SET image = :image  WHERE id = :id");
           $update_image->bindParam(":image", $image);
           $update_image->bindParam(":id", $id);
           $update_image->execute();
           move_uploaded_file($image_tmp_name, $image_folder);
           if($ancien_image != '' AND $ancien_image != $image){
              unlink('imgprof/'.$ancien_image);
            }
            $success_msg[] = 'image modifié avec succès!';
         }
      }

      if(!empty($mail_prof)){
        $select_email = $con->prepare("SELECT mail_prof FROM t_enseignant WHERE id =:id AND mail_prof = :mail_prof");
        $select_email ->bindParam(":id", $id);
        $select_email ->bindParam(":mail_prof", $mail_prof);
        $select_email ->execute();
        if($select_email->rowCount() > 0){
            $warning_msg[] = 'Ce mail existe déjà!';
        }else{
           $update_email = $con->prepare("UPDATE t_enseignant SET mail_prof = :mail_prof WHERE id =:id ");
           $update_email->bindParam(":mail_prof", $mail_prof);
           $update_email ->bindParam(":id", $id);
           $update_email ->execute();
           $success_msg[] = 'mail modifié avec succès!';
        }
     }

     $ancien_pass = $_POST["ancien_pass"];
     $nouveau_pass = $_POST["nouveau_pass"];
     $cpass = $_POST["cpass"];
 
     if (isset($_POST["changer_mdp"])) {
     if (password_verify($ancien_pass, $prev_pass)) {
         if ($nouveau_pass === $cpass) {
         
             $hashedNewPassword = password_hash($nouveau_pass, PASSWORD_DEFAULT);
           
             $sql = "UPDATE t_enseignant SET mdp_prof = :mdp_prof WHERE id = :id";
             $stmt = $con->prepare($sql);
             $stmt->bindParam(":mdp_prof", $hashedNewPassword);
             $stmt->bindParam(":id", $id);
             $stmt->execute();
             $success_msg[] = 'Mot de passe modifié avec succès!';
         } else {
             $warning_msg[] = 'Les mots de passe ne correspondent pas.';
         }
     } else {
         $warning_msg[] = 'Mot de passe actuel incorrect.';
     }
    }

}
	?>
  
  <a href="ajouterprof.php"><button class="btn-aj">Ajouter enseignant</a></button>

<?php

$select = $con->prepare("SELECT * FROM t_enseignant ");
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
       <td>Nom</td>
       <td>Prenom</td>
       <td>Photo</td>
       <td>Email</td>
       <td style="background-color: #fff;"></td>
    </tr>

    <?php
      if ($select->rowCount() > 0) {
       while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
           $prof_id = $fetch['id'];
     ?>
    
    
    <tr>
       <td class='tab1'><?=$prof_id; ?></td>
       <td class='tab2'><?=$fetch['nom_prof']; ?></td>
       <td><?=$fetch['prenom_prof']; ?></td>
       <td style="  display: flex;
  justify-content: center;
  padding: 3px;
  background-color:#11e84ea5;">
           <img src="imgprof/<?= $fetch['image']; ?>"height="80" style="border-radius:50%;" alt="">
       </td>
       <td><?=$fetch['mail_prof']; ?></td>
       <td class='btn-sup'><a href="supprimerprof.php?supprime=<?= $prof_id; ?>">Supprimer</a></td>
       <td class='btn-mod'><a href="modifierprof.php?modifie=<?= $prof_id; ?>"> Modifier</a></td>

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