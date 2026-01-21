
<?php
  include("sessionet.php");

  if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:accueilet.php');
}

  include("admin/connexion.php");


  $formation_id_etudiant = $_SESSION['formation_id_etudiant'];

  if(isset($_POST['add_comment'])){

   
      $comment_box = $_POST['comment_box'];
      $content_id = $_POST['content_id'];
     

      $select_content = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
      $select_content->bindParam(":id",$content_id); 
      $select_content->execute();
      $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

      if ($fetch_content) {
      $id_enseignant = $fetch_content['id_enseignant'];
   } else {
     
  }

      if($select_content->rowCount() > 0){

         $select_comment = $con->prepare("SELECT * FROM t_commentaire WHERE id_cours =:id_cours  AND id_etudiant =:id_etudiant AND id_enseignant =:id_enseignant AND commentaire =:commentaire");
         $select_comment->bindParam(":id_cours",$content_id);
         $select_comment->bindParam(":id_etudiant",$id_etudiant);
         $select_comment->bindParam(":id_enseignant",$id_enseignant); 
         $select_comment->bindParam(":commentaire",$comment_box); 
         $select_content->execute();
         if($select_comment->rowCount() > 0){
            $warning_msg[] = 'Commentaire déja ajouté!';
         }else{
            $insert_comment = $con->prepare("INSERT INTO t_commentaire (id, id_cours, id_etudiant, id_enseignant, commentaire) VALUES(:id,:id_cours,:id_etudiant,:id_enseignant,:commentaire)");
            $insert_comment->bindParam(":id", $id);
            $insert_comment->bindParam(":id_cours", $content_id);
            $insert_comment->bindParam(":id_etudiant", $id_etudiant);
            $insert_comment->bindParam(":id_enseignant", $id_enseignant);
            $insert_comment->bindParam(":commentaire",  $comment_box); 
            $insert_comment->execute();
            $sucess_msg[] = 'commentaire ajouté!';
         }

      }else{
         $warning_msg[] = 'erreur!';
      }

   

}

if(isset($_POST['supprimer'])){

   $delete_id = $_POST['comment_id'];

   $verify_comment = $con->prepare("SELECT * FROM t_commentaire WHERE id = :id");
   $verify_comment->bindParam(":id", $delete_id); 
   $verify_comment->execute();

   if($verify_comment->rowCount() > 0){
      $delete_comment = $con->prepare("DELETE FROM t_commentaire WHERE id = :id");
      $delete_comment->bindParam(":id", $delete_id); 
      $delete_comment->execute();
      $sucess_msg[] = 'commentaire supprimé avec succès!';
   }else{
      $warning_msg[] = 'commentaire déja supprimé!';
   }

}

if(isset($_POST['modification'])){

   $update_id = $_POST['update_id'];
   $update_box = $_POST['update_box'];

   $verify_comment = $con->prepare("SELECT * FROM t_commentaire WHERE id = :id AND commentaire = :commentaire");
   $verify_comment->bindParam(":id", $update_id); 
   $verify_comment->bindParam(":commentaire", $update_box); 
   $verify_comment->execute();

   if($verify_comment->rowCount() > 0){
      $warning_msg[] = 'commentaire déja ajouté!';
   }else{
      $update_comment = $con->prepare("UPDATE t_commentaire SET commentaire = :commentaire WHERE id = :id");
      $update_comment->bindParam(":commentaire", $update_box); 
      $update_comment->bindParam(":id", $update_id); 
      $update_comment->execute();
      $sucess_msg[] = 'commentaire modifié avec succès!';
   }

}
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
            <a href="modifprof.php">
                <span class="icon">
                <i class="fa-solid fa-user" ></i>
                </span>             
                  <span class="title">Profil</span>
            </a>
         </li>

         <li>
            <a href="coursetudiant.php" class="active">
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

   <section class="watch-video">

   <?php
      $select_content = $con->prepare("SELECT * FROM t_cours WHERE id = :id");
      $select_content->bindParam(":id",$get_id);
      $select_content->execute();
      if($select_content->rowCount() > 0){
         while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
            $content_id = $fetch_content['id'];


            $select_tutor = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id LIMIT 1");
            $select_tutor->bindParam(":id",$fetch_content['id_enseignant']);
            $select_tutor->execute();
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
   ?>

<div class="video-details">
   <video src="admin/dossiervideo/<?= $fetch_content['video']; ?>" class="video" poster="admin/dossierimage/<?= $fetch_content['image']; ?>" controls autoplay></video>
   <h3 class="title"><?= $fetch_content['titre']; ?></h3>
  
   <div class="tutor">
      <img src="admin/imgprof/<?= $fetch_tutor['image']; ?>" alt="">
      <div>
         <h3><?= $fetch_tutor['nom_prof']. ' ' . $fetch_tutor['prenom_prof']; ?></h3>
        
      </div>
   </div>
   <form action="" method="post" class="flex">
      <input type="hidden" name="content_id" value="<?= $content_id; ?>">
      <a href="playlist_et.php?get_id=<?= $fetch_content['id_playlist']; ?>" class="inline-btn">voir la playlist</a>
     
   </form>
   <div class="description"><p><?= $fetch_content['description']; ?></p></div>
</div>
<?php
         }
      }else{
         echo '<p class="empty">aucune video disponible!</p>';
      }
   ?>
</section>

<?php
   if(isset($_POST['modifier'])){
      $edit_id = $_POST['comment_id'];
      $verify_comment = $con->prepare("SELECT * FROM t_commentaire WHERE id =:id LIMIT 1");
      $verify_comment->bindParam(":id",$edit_id);
      $verify_comment->execute();
      if($verify_comment->rowCount() > 0){
         $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
?>
<section class="edit-comment">
   <h1 class="heading1">Editer commentaire</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
      <textarea name="update_box" class="box" maxlength="1000" required placeholder="please enter your comment" cols="30" rows="10"><?= $fetch_edit_comment['commentaire']; ?></textarea>
      <div class="flex">
         <a href="lire_video.php?get_id=<?= $get_id; ?>" class="inline-option-btn">X</a>
         <input type="submit" value="Modifier" name="modification" class="inline-btn">
      </div>
   </form>
</section>
<?php
   }else{
      $warning_msg[] = 'erreur!';
   }
}
?>

<section class="comments">

<h1 class="heading">Espace commentaire</h1>

<form action="" method="post" class="add-comment">
   <input type="hidden" name="content_id" value="<?= $get_id; ?>">
   <textarea name="comment_box" required placeholder="ecrire un commentaire..." maxlength="1000" cols="30" rows="10"></textarea>
   <input type="submit" value="Publier" name="add_comment" class="inline-btn">
</form>

<h1 class="heading">Autres commentaires</h1>


<div class="show-comments">
<?php
         $select_comments = $con->prepare("SELECT * FROM t_commentaire WHERE id_cours =:id_cours");
         $select_comments->bindParam(":id_cours",$get_id); 
         $select_comments->execute();
         if($select_comments->rowCount() > 0){
            while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
               $select_commentor = $con->prepare("SELECT * FROM t_etudiant WHERE id = :id");
               $select_commentor->bindParam(":id",$fetch_comment['id_etudiant']); 
               $select_commentor->execute();
               $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
      ?>
   <div class="box" style="<?php if($fetch_comment['id_etudiant'] == $id_etudiant){echo 'order:-1;';} ?>">
      <div class="user">
         <img src="etudiant/<?= $fetch_commentor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_commentor['nom_et']; ?></h3>
            <span><?= $fetch_comment['date']; ?></span>
         </div>
      </div>
      <p class="text"><?= $fetch_comment['commentaire']; ?></p>
      <?php
            if($fetch_comment['id_etudiant'] == $id_etudiant){ 
         ?>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
         <button type="submit" name="modifier" class="inline-option-btn">Modifier</button>
         <button type="submit" name="supprimer" class="inline-delete-btn" onclick="return confirm('supprimer ce commentaire?');">Supprimer</button>
      </form>
      <?php
         }
         ?>
   </div>
   <?php
       }
      }else{
         echo '<p class="empty">Aucun commentaire disponible!</p>';
      }
      ?>
   </div>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>

<script src="scripte.js"></script>
</body>
</html>


	