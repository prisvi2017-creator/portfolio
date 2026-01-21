<?php
  include("sessionens.php");

  if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:courenseignant.php');
}

if(isset($_POST['supprimer'])){

   $delete_id = $_POST['video_id'];
   
   $delete_pdf_thumb = $con->prepare("SELECT image FROM t_cours WHERE id = :id LIMIT 1");
   $delete_pdf_thumb->bindParam(":id", $delete_id);
   $delete_pdf_thumb->execute();
   $fetch_thumb = $delete_pdf_thumb->fetch(PDO::FETCH_ASSOC);
   unlink('dossierimage/'.$fetch_thumb['image']);

   $delete_pdf = $con->prepare("SELECT pdf FROM t_cours WHERE id = :id LIMIT 1");
   $delete_pdf->bindParam(":id", $delete_id);
   $delete_pdf->execute();
   $fetch_pdf = $delete_pdf->fetch(PDO::FETCH_ASSOC);
   unlink('dossierpdf/'.$fetch_pdf['pdf']);

   $delete_content = $con->prepare("DELETE FROM t_cours WHERE id = :id");
   $delete_cours->bindParam(":id", $delete_id);
      $delete_cours->execute();
   header('location:courenseignant.php');
    
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
            <a href="whatsapp.php">
                <span class="icon">
                <i class="bi bi-whatsapp" style="color: #00ddfa;"></i>
                </span>
                <span class="title">Groupe Whatsapp</span>
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
   <form action="recherche_prof.php" method="post">
     <label>
        <input type="text" name="search" placeholder="Que recherchez-vous?">
        <i class="fa-sharp fa-solid fa-magnifying-glass" name="search_btn" style="color: #7EBB40;"></i>
     </label>
     </form>
   </div>
   
   <div class="user" id="user-btn">
   <i class="fa-solid fa-user" style="color: #18b7ff;" ></i>
   </div>
      
   <div class="profile2">
         <h3 class="name"><?php echo "$nom_prof  $prenom_prof" ?></h3>
         <p class="role">Formateur</p>
         <div class="flex-btn">
         <a href="modifprof.php" class="option-btn">Modifier profile</a>
         <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
         </div>


   </div>
         
   <section class="view-content">
   <?php

      $select_content = $con->prepare("SELECT * FROM t_cours WHERE id = :id AND id_enseignant = :id_enseignant");
      $select_content->bindParam(":id", $get_id);
      $select_content->bindParam(":id_enseignant",$id_enseignant);
      $select_content->execute();
      if($select_content->rowCount() > 0){
         while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
            $video_id = $fetch_content['id'];

            $count_comments = $con->prepare("SELECT * FROM t_commentaire WHERE id_enseignant =:id_enseignant AND id_cours =:id_cours");
            $count_comments->bindParam(":id_enseignant",$id_enseignant); 
            $count_comments->bindParam(":id_cours",$video_id); 
            $count_comments->execute();
            $total_comments = $count_comments->rowCount();

   ?>
<div class="container">
   <iframe src="dossierpdf/<?= $fetch_content['pdf']; ?>"  frameborder="0"  class="video"></iframe>
   <h3 class="title"><?= $fetch_content['titre']; ?></h3>
   <div class="flex">
      <div><i class="fas fa-comment"></i><span><?= $total_comments; ?></span></div>
   </div>
   <div class="description"><?= $fetch_content['description']; ?></div>
   <form action="" method="post">
      <div class="flex-btn">
         <input type="hidden" name="video_id" value="<?= $video_id; ?>">
         <a href="modifier_courspdf.php?get_id=<?= $video_id; ?>" class="inline-option-btn">Modifier</a>
         <input type="submit" value="Supprimer" class="delete-btn" onclick="return confirm('supprimer le fichier?');" name="supprimer">
      </div>
   </form>
</div>
<?php
    }
   }else{
      echo '<p class="empty">aucun cours ici! <a href="ajouter_cours.php" class="btn" style="margin-top: 1.5rem;">ajouter video</a></p>';
   }
      
   ?>

</section>

<section class="comments">

<h1 class="heading">Commentaires etudiants</h1>


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
   <div class="box">
      <div class="user">
         <img src="../etudiant/<?= $fetch_commentor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_commentor['nom_et']; ?></h3>
            <span><?= $fetch_comment['date']; ?></span>
         </div>
      </div>
      <p class="text"><?= $fetch_comment['commentaire']; ?></p>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
         <button type="submit" name="delete_comment" class="inline-delete-btn">supprimer</button>
         <button type="submit" name="delete_comment" class="inline-delete-btn">Repondre</button>
      </form>
   </div>
   <?php
       }
      }else{
         echo '<p class="empty">aucun commentaires disponible!</p>';
      }
      ?>
   </div>

</section>





<footer class="footer">

&copy; copyright @ 2023  <span>H<b style="color: #e81c11;">2</b>S<b style="color: #e81c11;">I</b></span> | tout droit reserves!

<footer>

      </div>

     




      <script>
    let profile2 = document.querySelector('.menu .topbar .profile2');

document.querySelector('#user-btn').onclick = () =>{
   profile2.classList.toggle('active');
}
</script>


<script src="script.js"></script>
</body>
</html>