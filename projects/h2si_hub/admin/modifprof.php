<?php
  include("sessionens.php");


  include("connexion.php");

  if(isset($_POST['submit'])){
    $select_prof = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id");
    $select_prof->bindParam(":id", $id_enseignant);
    $select_prof->execute();
    $fetch_prof = $select_prof->fetch(PDO::FETCH_ASSOC); 

    $prev_image = $fetch_prof['image'];
    $prev_pass = $fetch_prof['mdp_prof'];

    $nom_prof = $_POST['nom_prof'];
    $prenom_prof = $_POST['prenom_prof'];
    $mail_prof = $_POST['mail_prof'];
    
    if(!empty($nom_prof)){
        $update_nom = $con->prepare("UPDATE t_enseignant SET nom_prof =:nom_prof WHERE id = :id");
        $update_nom ->bindParam(":nom_prof", $nom_prof);
        $update_nom ->bindParam(":id", $id_enseignant);
        $update_nom ->execute();
       $success_msg[] = 'nom modifié avec succès!';
     }
 
     if(!empty($prenom_prof)){
        $update_prenom = $con->prepare("UPDATE t_enseignant SET prenom_prof =:prenom_prof WHERE id = :id");
        $update_prenom ->bindParam(":prenom_prof", $prenom_prof);
        $update_prenom ->bindParam(":id", $id_enseignant);
        $update_prenom ->execute();
       $success_msg[] = 'prenom modifié avec succès!';
     }

     if(!empty($mail_prof)){
        $select_email = $con->prepare("SELECT mail_prof FROM t_enseignant WHERE id =:id AND mail_prof = :mail_prof");
        $select_email ->bindParam(":id", $id_enseignant);
        $select_email ->bindParam(":mail_prof", $mail_prof);
        $select_email ->execute();
        if($select_email->rowCount() > 0){
            $warning_msg[] = 'Ce mail existe déjà!';
        }else{
           $update_email = $con->prepare("UPDATE t_enseignant SET mail_prof = :mail_prof WHERE id =:id ");
           $update_email->bindParam(":mail_prof", $mail_prof);
           $update_email ->bindParam(":id", $id_enseignant);
           $update_email ->execute();
           $success_msg[] = 'mail modifié avec succès!';
        }
     }

     $image = $_FILES['image']['name'];
     $image_size = $_FILES['image']['size'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_folder = 'imgprof/'.$image;
  
     if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'image trop large!';
        }else{
           $update_image = $con->prepare("UPDATE  t_enseignant SET image = :image  WHERE  id =:id ");
           $update_image->bindParam(":image", $image);
           $update_image ->bindParam(":id", $id_enseignant);
           $update_image ->execute();
           move_uploaded_file($image_tmp_name, $image_folder);
           if($prev_image != '' AND $prev_image != $image){
              unlink('imgprof/'.$prev_image);
           }
           $success_msg[] = 'image modifié avec succès!';
        }
     }

     $ancien_pass = $_POST["ancien_pass"];
    $nouveau_pass = $_POST["nouveau_pass"];
    $cpass = $_POST["cpass"];

    if (isset($_POST["changer_mdp"])) {
    if (password_verify($ancien_pass, $prev_pass)) {
        if ($nouveau_pass === $cpass) {
           // Vérification du format du nouveau mot de passe
           $regexMotDePasse = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/';
           if (preg_match($regexMotDePasse, $nouveau_pass)) {
            $hashedNewPassword = password_hash($nouveau_pass, PASSWORD_DEFAULT);
          
            $sql = "UPDATE t_enseignant SET mdp_prof = :mdp_prof WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":mdp_prof", $hashedNewPassword);
            $stmt->bindParam(":id", $id_enseignant);
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

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Espace enseignant</title>
   <link rel="icon" href="Images/logoH2Si2.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>

<div class="container">
    <div class="navigation">
       <ul>
         <li>
            <a href="#">
                <span class="title">Espace enseignant</span>
            </a>
         </li>


         <div class="profile">
        

         <?php
          include("connexion.php");
        $select = $con->query("SELECT * FROM `t_enseignant` WHERE id= $id_enseignant");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {
         echo '<img class="image" src="imgprof/'.$fetch['image'].'">';       
      }       
      ?>

      <h3 class="name"><span><?php echo "$nom_prof  $prenom_prof" ?></span></h3>
      <p class="role"><span><?php echo "$mail_prof" ?></span></p>
     
   </div>
         
         <li>
            <a href="acceuilprof.php">
                <span class="icon">
                <i class="fa-solid fa-house" style="color: #0efb2a;"></i> 
                </span>             
                  <span class="title">Accueil</span>
            </a>
         </li>

         <li>
            <a href="courenseignant.php">
                <span class="icon">
                <i class="fa-solid fa-file-video" style="color: #00ddfa;"></i>
                </span>
                <span class="title">Cours</span>
            </a>
         </li>

         <li>
            <a href="playlist.php">
                <span class="icon">
                <i class="fas fa-folder-open" style="color: #5ae548;"></i>
                </span>
                <span class="title">Playlist</span>
            </a>
         </li>

        
         <li>
            <a href="programme.php">
                <span class="icon">
                <i class="bi bi-calendar-fill" style="color: #00ddfa;"></i>
                </span>
                <span class="title">Progamme de cours</span>
            </a>
         </li>

         <li>
            <a href="Visio1.php">
                <span class="icon">
                <i class="bi bi-camera-video-fill" style="color: #0efb2a;"></i>
                </span>
                <span class="title">Visioconférence</span>
            </a>
         </li>

         <li>
            <a href="deconnexionprof.php">
                <span class="icon">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #52f10e;"></i>
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
   <i class="fa-solid fa-bars" style="color: #e81c11;"></i>
   </div>

   <a href="#" class="logo"><img src="images/logoH2Si.png" width="70" height="25"></a>

   <div class="search">
     <label>
        <input type="text" placeholder="Que recherchez-vous?">
        <i class="fa-sharp fa-solid fa-magnifying-glass" style="color: #7EBB40;"></i>
     </label>
   </div>
   
   <div class="user" id="user-btn">
   <i class="fa-solid fa-user" style="color: #18b7ff;" ></i>
   </div>
      
   <div class="profile2">
         <h3 class="name"><?php echo "$nom_prof  $prenom_prof" ?></h3>
         <p class="role">Formateur</p>
         <div class="flex-btn">
         <a href="modifprof.php" class="option-btn">Modifier profil</a>
         <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
         </div>


   </div>

   <?php
        $select_profil = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id");
        $select_profil->bindParam(":id", $id_enseignant);
        $select_profil->execute();
        $fetch_profile = $select_profil->fetch(PDO::FETCH_ASSOC); 
       ?>  

   <section class="form-containerr" style="min-height: calc(100vh - 19rem);">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Modification</h3>
      <div class="flex">
         <div class="col">
            <p>Nom</p>
            <input type="text" name="nom_prof" placeholder="<?= $fetch_profile['nom_prof']; ?>" maxlength="50"  class="box" pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
            <p>prenom</p>
            <input type="text" name="prenom_prof" placeholder="<?= $fetch_profile['prenom_prof']; ?>" maxlength="50"  class="box"  pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">            
            <p>Email</p>
            <input type="email" name="mail_prof" placeholder="<?= $fetch_profile['mail_prof']; ?>" maxlength="50"  class="box">
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
      <p>Nouvelle photo de profil :</p>
      <input type="file" name="image" accept="image/*"  class="box">
      <input type="submit" name="submit" value="Modifier" class="btn">
   </form>

</section>
       
<footer class="footer">

&copy; copyright @ 2023  <span>H<b style="color: #e81c11;">2</b>S<b style="color: #e81c11;">I</b></span> | tout droit reserves!

</footer>

      </div>

     


      <script>
    let profile2 = document.querySelector('.menu .topbar .profile2');

document.querySelector('#user-btn').onclick = () =>{
   profile2.classList.toggle('active');
}
</script>

<script>
   let mdp = document.querySelector('.mdp');

   document.querySelector('#check').onclick = () =>{
         mdp.classList.toggle("open");
      }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>

<script src="script.js"></script>
</body>
</html>