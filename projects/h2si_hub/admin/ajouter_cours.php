<?php
  include("sessionens.php");
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
         <a href="modifprof.php" class="option-btn">Modifier profil</a>
         <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
         </div>


   </div>
         
   <section class="video-form">

   <h1 class="heading">Ajouter un cours</h1>

   <div class="box-container">
   <form action="ajouter_cours.php" method="post" enctype="multipart/form-data">
      <p>Titre <span>*</span></p>
      <input type="text" name="titre" maxlength="100" required placeholder="entrer un titre" class="box">
      <p>description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="écrivez une description" maxlength="1000" cols="30" rows="10"></textarea>
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
      <p>Ajouter une miniature<span>*</span></p>
      <input type="file" name="file" accept="image/*" required class="box">
      <p>Ajouter une video<span>*</span></p>
      <input type="file" name="video" accept="video/*"  class="box">
      <p>Ajouter un fichier PDF<span>*</span></p>
      <input type="file" name="pdf" accept=".pdf"  class="box">
      <input type="submit" value="Publier" name="submit" class="btn">
   </form>
   <?php

if(isset($_POST["submit"]))
{
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $playlist = $_POST["playlist"];
    
    
    $repertoire = "dossierimage/";
    $extention = strrchr($_FILES['file']['name'],'.');
    $image = $_FILES['file']['name']=rand(700,900000).$extention;
        echo "";
    if($extention!=".png" && $extention!=".jpg" && $extention!=".jpeg" && $extention!=".PNG" && $extention!=".JPG" && $extention!=".JPEG")
        die("Impossible d'ajouter un fichier image");
    
    if(!is_uploaded_file($_FILES['file']['tmp_name']))
        die("Fichier est introuvable");
    
    if(!move_uploaded_file($_FILES['file']['tmp_name'],$repertoire.$_FILES['file']['name']))
        die("Impossible de copier le fichier dans le dossier");

   

    include("connexion.php");

    // Insérer les informations du cours
    $sql = "INSERT INTO t_cours (id_enseignant, titre, description, id_playlist, image) VALUES (:id_enseignant, :titre, :description, :id_playlist, :image)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_enseignant", $id_enseignant);
    $stmt->bindParam(":titre", $titre);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":id_playlist", $playlist);
    $stmt->bindParam(":image", $image);
    $stmt->execute();

    // Récupérer l'ID du cours inséré
    $last_id = $con->lastInsertId();

    if(!empty($_FILES['video']['name'])){
        $dossier = "dossiervideo/";
        $ext = strrchr($_FILES['video']['name'],'.');
        $video = rand(700,900000).$ext;
        echo "";
        if($ext!=".mp4" && $ext!=".avi"  && $ext!=".MP4" && $ext!=".AVI")
            die("Impossible d'ajouter un fichier video");
        
        if(!is_uploaded_file($_FILES['video']['tmp_name']))
            die("Fichier est introuvable");
        
        if(!move_uploaded_file($_FILES['video']['tmp_name'],$dossier.$video))
            die("Impossible de copier le fichier dans le dossier");
        $update_video = $con->prepare("UPDATE t_cours SET video = :video WHERE id = :id");
        $update_video->bindParam(":id", $last_id);
        $update_video->bindParam(":video", $video);
        $update_video->execute();
    }

    if(!empty($_FILES['pdf']['name'])){
        $dossierpdf = "dossierpdf/";
        $exte = strrchr($_FILES['pdf']['name'],'.');
        $pdf = rand(700,900000).$exte;
        echo "";
        if($exte!=".pdf"   && $exte!=".PDF")
            die("Impossible d'ajouter un fichier pdf");
        
        if(!is_uploaded_file($_FILES['pdf']['tmp_name']))
            die("Fichier est introuvable");
        
        if(!move_uploaded_file($_FILES['pdf']['tmp_name'],$dossierpdf.$pdf))
            die("Impossible de copier le fichier dans le dossier");
        $update_pdf = $con->prepare("UPDATE t_cours SET pdf = :pdf WHERE id = :id");
        $update_pdf->bindParam(":id", $last_id);
        $update_pdf->bindParam(":pdf", $pdf);
        $update_pdf->execute();
    }

    $success_msg[] = 'Cours ajouté!';
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