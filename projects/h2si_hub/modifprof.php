<?php
  include("sessionet.php");

  include("admin/connexion.php");

 

  if(isset($_POST['submit'])){
    $select_et = $con->prepare("SELECT * FROM t_etudiant WHERE id = :id");
    $select_et->bindParam(":id", $id_etudiant);
    $select_et->execute();
    $fetch_et = $select_et->fetch(PDO::FETCH_ASSOC); 

    $prev_image = $fetch_et['image'];
    $prev_pass = $fetch_et['mdp_et'];

    

     $image = $_FILES['image']['name'];
     $image_size = $_FILES['image']['size'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_folder = 'etudiant/'.$image;
  
     if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'image trop large!';
        }else{
           $update_image = $con->prepare("UPDATE  t_etudiant SET image = :image  WHERE  id =:id ");
           $update_image->bindParam(":image", $image);
           $update_image ->bindParam(":id", $id_etudiant);
           $update_image ->execute();
           move_uploaded_file($image_tmp_name, $image_folder);
           if($prev_image != '' AND $prev_image != $image){
              unlink('etudiant/'.$prev_image);
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
        
            $hashedNewPassword = password_hash($nouveau_pass, PASSWORD_DEFAULT);
          
            $sql = "UPDATE t_etudiant SET mdp_et = :mdp_et WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":mdp_et", $hashedNewPassword);
            $stmt->bindParam(":id", $id_etudiant);
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




  $formation_id_etudiant = $_SESSION['formation_id_etudiant'];
  

 
 
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Espace etudiant</title>
   <link rel="icon" href="Images/logoH2Si2.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>




<div class="container">
    <div style="background: #e81c11;" class="navigation">
       <ul>
        


         <div class="profile">
        

         <?php
        $select = $con->query("SELECT * FROM `t_etudiant` WHERE mail_et='$mail_et'  ");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {
         echo '<img class="image" src="etudiant/'.$fetch['image'].'">';            
                
     
                      }
                 
                ?>



      
      <h3 style="color: #18b7ff;" class="name"><span><?= $prenom_et . ' ' . $nom_et; ?></span></h3>
      <p class="role"><span><?=  $nom_form; ?></span></p>

     
   </div>
         
         <li>
            <a href="accueilet.php">
                <span class="icon">
                <i class="fa-solid fa-house"></i> 
                </span>             
                  <span class="title">Accueil</span>
            </a>
         </li>

       <li>
            <a href="modifprof.php" class="active">
                <span class="icon">
                <i class="fa-solid fa-user" ></i>
                </span>             
                  <span class="title">Profil</span>
            </a>
         </li>

         <li>
            <a href="coursetudiant.php">
                <span class="icon">
                <i class="fa-solid fa-file-video"></i>
                </span>
                <span class="title">Cours</span>
            </a>
         </li>



              <li>
            <a href="contactez.php">
                <span class="icon">
                <i class="bi bi-headset"></i>
                </span>
                <span class="title">contactez-nous</span>
            </a>
         </li>

         <li>
            <a href="propos.php">
                <span class="icon">
                <i class="bi bi-exclamation-circle"></i>
                </span>
                <span class="title">FAQ</span>
            </a>
         </li>
      

         <li>
            <a href="deconnexionet.php">
                <span class="icon">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </span>
                <span class="title">Deconnexion</span>
            </a>
         </li>

       
       </ul>
       
    </div>
</div>

<div class="menu">
   <div class="topbar">


   

   <a href="#" class="logo"><img src="images/icone.png" width="55" height="55"></a>

   <div class="search">
   <form action="recherche_cours.php" method="post">
     <label>
        <input type="text" name="search" placeholder="Que recherchez-vous?">
        <i class="fa-sharp fa-solid fa-magnifying-glass" name="search_btn" style="color: #7EBB40;"></i>
     </label>
     </form>
   </div>

    <a href="notification.php" class="notification"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
   
<div class="btn-aj">
   <a href="scolarite_et.php"><button>Scolarité Étudiant</button></a>
</div>
         
   
   </div>

  
   <section class="form-containerr" style="min-height: calc(100vh - 19rem);">

<form class="register" action="" method="post" enctype="multipart/form-data" onsubmit="return validerFormulaire()">
   <h3>Modification</h3>
   <div class="flex">
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
      <span id="messageErreurMotDePasse" style="color: red; font-size:0.8rem; padding:5px; background-color: antiquewhite;"></span>
         <p>Ancien mot de passe :</p>
         <input type="password" name="ancien_pass" placeholder="Entrer votre ancien mot de passe" maxlength="20"  class="box">
         <p>nouveau mot de passe :</p>
         <input type="password" name="nouveau_pass" placeholder="Entrer votre nouveau mot de passe" maxlength="20"  class="box">
         <p>confirmation :</p>
         <input type="password" name="cpass" placeholder="Confirmer votre mot de passe" maxlength="20"  class="box">
         </div>
      </div>
   </div>
   <input type="submit" name="submit" value="Modifier" class="btn">
</form>

<input type="submit" name="Supprimer_compte" value="Supprimer votre compte">

</section>  
   

<footer class="footer">

&copy; copyright @ 2023  <span>H<b style="color: #e81c11;">2</b>S<b style="color: #e81c11;">I</b></span> | tout droit reserves!

</footer>

      </div>

     
      <script>
        function validerFormulaire() {
            var motDePasse = document.getElementById("nouveau_pass").value;
            var regexMotDePasse = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;

            if (!regexMotDePasse.test(motDePasse)) {
                document.getElementById("messageErreurMotDePasse").innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 8 caractères.";
                return false;
            }

            // Autres validations et traitement du formulaire ici

            return true;
        }
    </script>



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
<script src="scripte.js"></script>
</body>
</html>