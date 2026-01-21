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

         
   <section class="video-form">

<h1 class="heading">Creer une playlist</h1>

<div class="box-container">
<form  action="cree_playlist.php" method="post" enctype="multipart/form-data">
<p>Titre <span>*</span></p>
   <input type="text" name="titre" maxlength="100" required placeholder="entrer un titre" class="box"> 
   <p>description <span>*</span></p>
   <textarea name="description" class="box" required placeholder="écrivez une description" maxlength="1000" cols="30" rows="10"></textarea>
   <p>Ajouter une miniature<span>*</span></p>
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

   <input type="submit" value="Terminer" class="btn" >   
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
if(isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["formations"]) && !empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["formations"])) {
   $titre = $_POST["titre"];
   $description = $_POST["description"];
   $formations = $_POST["formations"]; // Tableau contenant une ou plusieurs formations

   $repertoire = "dossierimage/";
   $extention = strrchr($_FILES['file']['name'], '.');
   $image = $_FILES['file']['name'] = rand(700, 900000) . $extention;
   if (!in_array($extention, [".png", ".jpg", ".jpeg", ".PNG", ".JPG", ".JPEG"])) {
       die("Impossible d'ajouter un fichier image");
   }
   if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
       die("Fichier introuvable");
   }
   if (!move_uploaded_file($_FILES['file']['tmp_name'], $repertoire . $_FILES['file']['name'])) {
       die("Impossible de copier le fichier dans le dossier");
   }

   include("connexion.php");


   foreach ($formations as $formation) {
       $select_nom = $con->prepare("SELECT nom_form FROM t_formation WHERE id = :id_formation");
       $select_nom->bindParam(":id_formation", $formation);
       $select_nom->execute();
       $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);

       $sql = "INSERT INTO t_playlist (id_enseignant, titre, description, id_formation, nom_form, image) 
               VALUES (:id_enseignant, :titre, :description, :id_formation, :nom_form, :image)";
       $stmt = $con->prepare($sql);
       $stmt->bindParam(":id_enseignant", $id_enseignant);
       $stmt->bindParam(":titre", $titre);
       $stmt->bindParam(":description", $description);
       $stmt->bindParam(":id_formation", $formation);
       $stmt->bindParam(":nom_form", $fetch_nom['nom_form']);
       $stmt->bindParam(":image", $image);
       $stmt->execute();
   }

   $success_msg[] = 'Playlist(s) ajoutée(s) avec succès pour la/les formation(s) sélectionnée(s)!';
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