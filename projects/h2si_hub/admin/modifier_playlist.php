<?php
include("sessionens.php");

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    header('location:playlist.php');
 }

 include("connexion.php");

if(isset($_POST['submit'])){
    $titre = $_POST["titre"];
 $description = $_POST["description"];
 $formations = $_POST["formations"];

 $update_playlist = $con->prepare("UPDATE t_playlist SET titre = :titre, description = :description WHERE id = :id");
 $update_playlist->bindParam(":titre", $titre);
 $update_playlist->bindParam(":description", $description);
 $update_playlist->bindParam(":id", $get_id);
 $update_playlist->execute();

 if (!empty($formations)) {
   // Convertir le tableau de formations en chaîne de caractères
   $formations_string = implode(',', $formations);
   
   // Mettre à jour la colonne formations dans t_playlist
   $update_formations = $con->prepare("UPDATE t_playlist SET id_formation = :id_formation WHERE id = :id");
   $update_formations->bindParam(":id_formation", $formations_string); 
   $update_formations->bindParam(":id", $get_id);
   $update_formations->execute();
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
       $update_image = $con->prepare("UPDATE t_playlist SET image = :image  WHERE id = :id");
       $update_image->bindParam(":image", $image);
       $update_image->bindParam(":id", $get_id);
       $update_image->execute();
       move_uploaded_file($image_tmp_name, $image_folder);
       if($ancien_image != '' AND $ancien_image != $image){
          unlink('dossierimage/'.$ancien_image);
       }
    }
}

   
$success_msg[] = 'playlist modifié avec succès!'; 
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

<h1 class="heading">Modification playlist</h1>
<?php
         $select_playlist = $con->prepare("SELECT * FROM t_playlist WHERE id = :id ");
         $select_playlist->bindParam(":id", $get_id);
         $select_playlist->execute();
         if($select_playlist->rowCount() > 0){
         while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
            $id_playlist = $fetch_playlist['id'];
            $count_videos = $con->prepare("SELECT * FROM t_cours WHERE id_playlist= :id_playlist");
            $count_videos->bindParam(":id_playlist", $id_playlist);
            $count_videos->execute();
            $total_videos = $count_videos->rowCount();
      ?>

<div class="box-container">
<form  action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="ancien_image" value="<?= $fetch_playlist['image']; ?>">
<p>Titre <span>*</span></p>
   <input type="text" name="titre" maxlength="100" required placeholder="entrer un titre" value="<?= $fetch_playlist['titre']; ?>" class="box"> 
   <p>description <span>*</span></p>
   <textarea name="description" class="box" required placeholder="écrivez une description" maxlength="1000" cols="30" rows="10"><?= $fetch_playlist['description']; ?></textarea>
   <p>Ajouter une miniature<span>*</span></p>
   <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="dossierimage/<?= $fetch_playlist['image']; ?>" alt="">
      </div>
   <input class="box" type="file" name="file" accept="image/*" >
   <p>Formation<span>*</span></p>
            <div class="checkbox-container">
               <?php
                  include("connexion.php");
                  $select_formation = $con->prepare("SELECT * FROM t_formation");
                  $select_formation->execute();
                  if($select_formation->rowCount() > 0){
                     while($fetch_formation = $select_formation->fetch(PDO::FETCH_ASSOC)){
               ?>
               <label class="checkbox-label">
                  <input type="checkbox" name="formations[]" value="<?= $fetch_formation['id']; ?>">
                  <span class="custom-checkbox"></span>
                  <?= $fetch_formation['nom_form']; ?>
               </label>
               <?php
                  }
               ?>
               <?php
               }else{
                  echo '<p>Aucune formation disponible!</p>';
               }
               ?>
            </div>
   <input type="submit" name="submit"  value="Modifier" class="btn" >
   <div class="flex-btn">
       
         <a href="voir_playlist.php?get_id=<?= $id_playlist; ?>" class="option-btne">voir la playlist</a>
      </div>   
</form>

<style>
    .checkbox-container {
    display: flex;
    flex-direction: column;
    gap: 10px; /* Espacement entre chaque formation */
}

.checkbox-label {
    display: flex;
    align-items: center;
    font-size: 16px;
    cursor: pointer;
    position: relative;
    padding-left: 35px; /* Espace pour le checkbox personnalisé */
    margin-bottom: 10px;
}

.checkbox-label input[type="checkbox"] {
    opacity: 0;
    position: absolute;
    left: 0;
}

.custom-checkbox {
    position: absolute;
    left: 0;
    top: 0;
    height: 20px;
    width: 20px;
    background-color: #f1f1f1;
    border: 2px solid #ccc;
    border-radius: 5px;
    transition: background-color 0.2s, border-color 0.2s;
}

.checkbox-label:hover .custom-checkbox {
    border-color: #7EBB40; /* Couleur au survol */
}

.checkbox-label input[type="checkbox"]:checked + .custom-checkbox {
    background-color: #7EBB40; /* Couleur une fois coché */
    border-color: #7EBB40;
}

.custom-checkbox:after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-label input[type="checkbox"]:checked + .custom-checkbox:after {
    display: block;
}

.checkbox-label .custom-checkbox:after {
    left: 6px;
    top: 2px;
    width: 7px;
    height: 12px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Améliorations visuelles pour le texte des labels */
.checkbox-label {
    color: #333;
    font-family: Arial, sans-serif;
}

.checkbox-label:hover {
    color: #7EBB40;
}

</style>

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