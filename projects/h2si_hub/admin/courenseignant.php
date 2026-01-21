<?php
  include("sessionens.php");

  if(isset($_POST['supprimer_video'])){
  
   $delete_id = $_POST['video_id'];
   include("connexion.php");
  $verify_video = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
  $verify_video->bindParam(":id", $delete_id);
  $verify_video->execute();
  if($verify_video->rowCount() > 0){
     $delete_video_thumb = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
     $delete_video_thumb->bindParam(":id", $delete_id);
     $delete_video_thumb->execute();
     $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
     unlink('dossierimage/'.$fetch_thumb['image']);
     $delete_video = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
     $delete_video->bindParam(":id", $delete_id);
     $delete_video->execute();
     $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
     unlink('dossiervideo/'.$fetch_video['video']);
     $delete_cours = $con->prepare("DELETE FROM t_cours WHERE id = :id");
     $delete_cours->bindParam(":id", $delete_id);
     $delete_cours->execute();
     $success_msg[] = 'Cours supprimé avec succès!';
  }else{
   $warning_msg[] = 'Cours déjà supprimé!';
  }
 }

 if(isset($_POST['supprimer_pdf'])){
  
   $delete_id = $_POST['video_id'];
   include("connexion.php");
  $verify_pdf = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
  $verify_pdf->bindParam(":id", $delete_id);
  $verify_pdf->execute();
  if($verify_pdf->rowCount() > 0){
     $delete_pdf_thumb = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
     $delete_pdf_thumb->bindParam(":id", $delete_id);
     $delete_pdf_thumb->execute();
     $fetch_thumb = $delete_pdf_thumb->fetch(PDO::FETCH_ASSOC);
     unlink('dossierimage/'.$fetch_thumb['image']);
     $delete_pdf = $con->prepare("SELECT * FROM t_cours WHERE id = :id LIMIT 1");
     $delete_pdf->bindParam(":id", $delete_id);
     $delete_pdf->execute();
     $fetch_pdf = $delete_pdf->fetch(PDO::FETCH_ASSOC);
     unlink('dossierpdf/'.$fetch_pdf['pdf']);
     $delete_cours = $con->prepare("DELETE FROM t_cours WHERE id = :id");
     $delete_cours->bindParam(":id", $delete_id);
     $delete_cours->execute();
     $success_msg[] = 'Cours supprimé avec succès!';
  }else{
   $warning_msg[] = 'Cours déjà supprimé!';
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
                <span class="title">Formations</span>
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
         
   <section class="cours">
   
   <h1 class="heading">Mes cours</h1>

   <div class="box-container">

   <div class="box1" style="text-align: center;">
      <h3 class="title" style="margin-bottom: .5rem;">Ajouter un nouveau cours</h3>
      <a href="ajouter_cours.php" class="btn">+ Ajouter</a>
   </div>
   <?php

$select_videos = $con->prepare("SELECT * FROM t_cours WHERE id_enseignant = :id_enseignant ORDER BY date DESC");
$select_videos->bindParam(":id_enseignant",$id_enseignant);
$select_videos->execute();
if($select_videos->rowCount() > 0){
    while($fecth_videos = $select_videos->fetch(PDO::FETCH_ASSOC)){ 
        $video_id = $fecth_videos['id'];
?>

<div class="box">
    <img src="dossierimage/<?= $fecth_videos['image']; ?>" class="thumb" alt="">
    <div class="ss_box">
        <h3 class="title"><?= $fecth_videos['titre']; ?></h3>
        <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <?php
            // Vérification si le cours est une vidéo
            if (!empty($fecth_videos['video'])) {
            ?>
            <a href="modifier_cours.php?type=video&get_id=<?= $video_id; ?>" class="inline-option-btn">Modifier</a>
            <input type="submit" value="supprimer" class="delete-btn" onclick="return confirm('supprimer ce cours?');" name="supprimer_video">
            <?php
            // Vérification si le cours est un PDF
            } elseif (!empty($fecth_videos['pdf'])) {
            ?>
            <a href="modifier_courspdf.php?type=pdf&get_id=<?= $video_id; ?>" class="inline-option-btn">Modifier</a>
            <input type="submit" value="supprimer" class="delete-btn" onclick="return confirm('supprimer ce cours?');" name="supprimer_pdf">
            <?php
            }
            ?>
        </form>
<?php
        // Vérification si le cours est une vidéo
        if (!empty($fecth_videos['video'])) {
?>
        <a href="voir_cours.php?get_id=<?= $video_id; ?>" class="btn">Regarder la vidéo</a>
<?php
        // Vérification si le cours est un PDF
        } elseif (!empty($fecth_videos['pdf'])) {
?>
        <a href="voir_courspdf.php?get_id=<?= $video_id; ?>" class="btn">Voir le PDF</a>
<?php
        }
?>
    </div>
</div>

<?php
    }
} else {
    echo '<p class="empty">aucun cours pour le moment!</p>';
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>
<script src="script.js"></script>
</body>
</html>