<?php
include("sessionens.php");

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    header('location:courenseignant.php');
 }

 include("connexion.php");

if(isset($_POST['submit'])){
    $pdf_id = $_POST['pdf_id'];
    $titre = $_POST["titre"];
 $description = $_POST["description"];
 $playlist = $_POST["playlist"];

 $update_cours = $con->prepare("UPDATE t_cours SET titre = :titre, description = :description WHERE id = :id");
 $update_cours->bindParam(":titre", $titre);
 $update_cours->bindParam(":description", $description);
 $update_cours->bindParam(":id", $pdf_id);
 $update_cours->execute();

 if(!empty($playlist)){
    $update_playlist = $con->prepare("UPDATE t_cours SET id_playlist = :id_playlist WHERE id = :id");
    $update_playlist->bindParam(":id_playlist", $playlist);
    $update_playlist->bindParam(":id", $pdf_id);
    $update_playlist->execute();
 }
 $ancien_image = $_POST['ancien_image'];
 $image = $_FILES['file']['name'];
 $image_size = $_FILES['file']['size'];
 $image_tmp_name = $_FILES['file']['tmp_name'];
 $image_folder = 'dossierimage/'.$image;

 if(!empty($image)){
    if($image_size > 2000000){
        $warning_msg[] = 'image trop large!';
    }else{
       $update_image = $con->prepare("UPDATE t_cours SET image = :image  WHERE id = :id");
       $update_image->bindParam(":image", $image);
       $update_image->bindParam(":id", $pdf_id);
       $update_image->execute();
       move_uploaded_file($image_tmp_name, $image_folder);
       if($ancien_image != '' AND $ancien_image != $image){
          unlink('dossierimage/'.$ancien_image);
       }
    }
}

$ancien_pdf = $_POST['ancien_pdf'];
$pdf = $_FILES['pdf']['name'];
$pdf_tmp_name = $_FILES['pdf']['tmp_name'];
$pdf_folder = 'dossierpdf/'.$pdf;

if(!empty($pdf)){
   $update_pdf = $con->prepare("UPDATE t_cours SET pdf = :pdf WHERE id = :id");
   $update_pdf->bindParam(":video", $pdf);
   $update_pdf->bindParam(":id", $pdf_id);
   move_uploaded_file($pdf_tmp_name, $pdf_folder);
   if($ancien_pdf != '' AND $ancien_pdf != $pdf){
      unlink('dossierpdf/'.$ancien_pdf);
   }
}

$success_msg[] = 'cours modifié avec succès!'; 
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

   <?php
        $select_profil = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id");
        $select_profil->bindParam(":id", $id_enseignant);
        $select_profil->execute();
        $fetch_profile = $select_profil->fetch(PDO::FETCH_ASSOC); 
       ?>     
   <section class="video-form">

<h1 class="heading">Modification cours</h1>
<?php
         $select_pdf = $con->prepare("SELECT * FROM t_cours WHERE id = :id AND id_enseignant= :id_enseignant");
         $select_pdf->bindParam(":id", $get_id);
         $select_pdf->bindParam(":id_enseignant", $id_enseignant);
         $select_pdf->execute();
         if( $select_pdf->rowCount() > 0){
         while($fetch_pdf =  $select_pdf->fetch(PDO::FETCH_ASSOC)){
            $pdf_id = $fetch_pdf['id'];
          
      ?>

<div class="box-container">
<form  action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="pdf_id" value="<?= $fetch_pdf['id']; ?>">
  <input type="hidden" name="ancien_pdf" value="<?= $fetch_pdf['pdf']; ?>">
<input type="hidden" name="ancien_image" value="<?= $fetch_pdf['image']; ?>">
<p>Titre <span>*</span></p>
   <input type="text" name="titre" maxlength="100" required placeholder="entrer un titre" value="<?= $fetch_pdf['titre']; ?>" class="box"> 
   <p>description <span>*</span></p>
   <textarea name="description" class="box" required placeholder="écrivez une description" maxlength="1000" cols="30" rows="10"><?= $fetch_pdf['description']; ?></textarea>
   <p>Modifier la miniature<span>*</span></p>
   <div class="thumb">
         <img src="dossierimage/<?= $fetch_pdf['image']; ?>" alt="">
      </div>
   <input class="box" type="file" name="file" accept="image/*" >
   <iframe src="dossierpdf/<?= $fetch_pdf['pdf']; ?>" width="300" height="200" frameborder="10" ></iframe>
      <p>Modifier le fichier pdf</p>
      <input type="file" name="pdf" accept=".pdf" class="box">
   <p>playlist<span>*</span></p>
      <select name="playlist" class="box" required>
         <option value="" disabled selected>--selectionner la playlist</option>
         <?php
           include("connexion.php");
         $select_playlist = $con->prepare("SELECT * FROM t_playlist WHERE id_enseignant = $id_enseignant ");
         $select_playlist->execute();
         if($select_playlist->rowCount() > 0){
            while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
         ?>
<option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['titre']; ?></option>
<?php
   }
?>
<?php
}else{
   echo '<option value="" disabled>Aucune playlist disponible!</option>';
}
?>
      </select>
   <input type="submit" name="submit"  value="Modifier" class="btn" >
   <div class="flex-btn">
         <a href="voir_courspdf.php?get_id=<?= $pdf_id; ?>" class="option-btne">voir le cours</a>
      </div>   
</form>
<?php
      } 
   }else{
      echo '<p class="empty">Aucune playlist disponible!</p>';
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script src="script.js"></script>

</body>
</html>