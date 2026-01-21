<?php
include("session.php");
include("connexion.php");

if(isset($_POST['submit'])){

   $select_admin = $con->prepare("SELECT * FROM t_admin WHERE id = :id");
    $select_admin->bindParam(":id", $id_admin);
    $select_admin->execute();
    $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC); 
    // Vérification des modifications d'informations personnelles

    $prev_image = $fetch_admin['image'];
    $prev_pass = $fetch_admin['mdp_ad'];


    $nom_ad = $_POST['nom_ad'];
    $prenom_ad = $_POST['prenom_ad'];
    $mail_ad = $_POST['mail_ad'];
    
    if(!empty($nom_ad)){
        $update_nom = $con->prepare("UPDATE t_admin SET nom_ad = :nom_ad WHERE id = :id");
        $update_nom->bindParam(":nom_ad", $nom_ad);
        $update_nom->bindParam(":id", $id_admin);
        $update_nom->execute();
        $success_msg[] = 'Nom modifié avec succès!';
    }
 
    if(!empty($prenom_ad)){
        $update_prenom = $con->prepare("UPDATE t_admin SET prenom_ad = :prenom_ad WHERE id = :id");
        $update_prenom->bindParam(":prenom_ad", $prenom_ad);
        $update_prenom->bindParam(":id", $id_admin);
        $update_prenom->execute();
        $success_msg[] = 'Prénom modifié avec succès!';
    }

    if(!empty($mail_ad)){
        $select_email = $con->prepare("SELECT mail_ad FROM t_admin WHERE id = :id AND mail_ad = :mail_ad");
        $select_email->bindParam(":id", $id_admin);
        $select_email->bindParam(":mail_ad", $mail_ad);
        $select_email->execute();
        if($select_email->rowCount() > 0){
            $warning_msg[] = 'Cet email existe déjà!';
        } else {
            $update_email = $con->prepare("UPDATE t_admin SET mail_ad = :mail_ad WHERE id = :id");
            $update_email->bindParam(":mail_ad", $mail_ad);
            $update_email->bindParam(":id", $id_admin);
            $update_email->execute();
            $success_msg[] = 'Email modifié avec succès!';
        }
    }

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'id/'.$image;
  
    if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'Image trop large!';
        } else {
            $update_image = $con->prepare("UPDATE t_admin SET image = :image WHERE id = :id");
            $update_image->bindParam(":image", $image);
            $update_image->bindParam(":id", $id_admin);
            $update_image->execute();
            move_uploaded_file($image_tmp_name, $image_folder);
            if($prev_image != '' && $prev_image != $image){
                unlink('id/'.$prev_image);
            }
            $success_msg[] = 'Image modifiée avec succès!';
        }
    }

    // Vérification et modification du mot de passe
    $ancien_pass = $_POST["ancien_pass"];
    $nouveau_pass = $_POST["nouveau_pass"];
    $cpass = $_POST["cpass"];

    if (isset($_POST["changer_mdp"])) {
      if (password_verify($ancien_pass, $prev_pass)) {
        if ($nouveau_pass === $cpass) {
            // Vérification du format du nouveau mot de passe
            $regexMotDePasse = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/';
            if (preg_match($regexMotDePasse, $nouveau_pass)) {
                // Hash du nouveau mot de passe
                $hashedNewPassword = password_hash($nouveau_pass, PASSWORD_DEFAULT);
                // Mise à jour du mot de passe dans la base de données
                $sql = "UPDATE t_admin SET mdp_ad = :mdp_ad WHERE id = :id";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(":mdp_ad", $hashedNewPassword);
                $stmt->bindParam(":id", $id_admin);
                $stmt->execute();
                $success_msg[] = 'Mot de passe modifié avec succès!';
            } else {
                $warning_msg[] = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d\'au moins 8 caractères.';
            }
        } else {
            $warning_msg[] = 'Les mots de passe ne correspondent pas.';
        }
      } else {
         $warning_msg[] = 'Mot de passe actuel incorrect.';
      }
    }
}
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>

</head>

<body>


<!--barre de Navigation-->
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
   <?php
        $select_profil = $con->prepare("SELECT * FROM t_admin WHERE id = :id");
        $select_profil->bindParam(":id", $id_admin);
        $select_profil->execute();
        $fetch_profile = $select_profil->fetch(PDO::FETCH_ASSOC); 
       ?>  

   <section class="form-containerr" style="min-height: calc(100vh - 19rem);">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Modification</h3>
      <div class="flex">
         <div class="col">
            <p>Nom</p>
            <input type="text" name="nom_ad" placeholder="<?= $fetch_profile['nom_ad']; ?>" maxlength="50"  class="box"  pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
            <p>prenom</p>
            <input type="text" name="prenom_ad" placeholder="<?= $fetch_profile['prenom_ad']; ?>" maxlength="50"  class="box" pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">            
            <p>Email</p>
            <input type="email" name="mail_ad" placeholder="<?= $fetch_profile['mail_ad']; ?>" maxlength="50"  class="box">
   
         </div>

         <div class="col">
      <p>Nouvelle photo de profil :</p>
   <input type="file" name="image" accept="image/*"  class="box">
   
      </div>

       
         <div class="col">
         <span class="check" id="check"  >
            <input type="checkbox" name="changer_mdp" value="1">
             Changer le mot de passe?  
      </span>
         <div class="mdp">
            <p>Ancien mot de passe :</p>
            <input type="password" name="ancien_pass" placeholder="Entrer votre ancien mot de passe" maxlength="20"  class="box">
            <p>nouveau mot de passe :</p>
            <input type="password" name="nouveau_pass" id="nouveau_pass" placeholder="Entrer votre nouveau mot de passe" maxlength="20"  class="box">
            <p>confirmation :</p>
            <input type="password" name="cpass" placeholder="Confirmer votre mot de passe" maxlength="20"  class="box">
            </div>
         </div>
      </div>
     
      <input type="submit" name="submit" value="Modifier" class="btn1">
   </form>

</section>
</div>


<script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}
</script>

<script>
   let mdp = document.querySelector('.mdp');

   document.querySelector('#check').onclick = () =>{
         mdp.classList.toggle("open");
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