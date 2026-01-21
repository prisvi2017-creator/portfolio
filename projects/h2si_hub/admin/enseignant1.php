
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_prof']) && isset($_POST['mdp_prof']) && !empty($_POST['mail_prof']) && !empty($_POST['mdp_prof'])) {
        $mail_prof = $_POST['mail_prof'];
        $mdp_prof = $_POST['mdp_prof'];

        if(isset($_POST['remember'])) {
         // Définition des cookies pour se souvenir de l'utilisateur
         setcookie('mail_prof', $mail_prof, time() + (86400 * 30), "/"); // 86400 = 1 jour
   
     } elseif (isset($_COOKIE['email'])) {
      // Si les cookies sont définis, utilisez-les pour remplir les champs du formulaire
      $mail_prof = $_COOKIE['mail_prof'];
  }

        include("connexion.php");

        $sql = "SELECT * FROM t_enseignant WHERE mail_prof = :mail_prof";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_prof", $mail_prof);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe
            if (password_verify($mdp_prof, $user['mdp_prof'])) {
                // Connexion réussie
                $_SESSION['id_enseignant'] = $user['id'];
                $_SESSION['mail_prof'] = $user['mail_prof'];
                $_SESSION['nom_prof'] = $user['nom_prof']; 
                $_SESSION['prenom_prof'] = $user['prenom_prof']; 

                // Redirection vers la page protégée ou autre traitement
                echo "";
            } else {
                // Mot de passe incorrect
                header("Location: enseigne.php?erreur=Mot de passe incorrect");
                exit();
            }
        } else {
            // Adresse email non valide
            header("Location: enseigne.php?erreur=Adresse email non valide");
            exit();
        }
      
    }

   }

   if (!isset($_SESSION['id_enseignant'])) {
      header("Location: enseigne.php");
      exit(); // Assure que le script s'arrête après la redirection
  }
   
$id_enseignant = $_SESSION['id_enseignant'];
$nom_prof = $_SESSION['nom_prof'];
$prenom_prof = $_SESSION['prenom_prof'];
$mail_prof = $_SESSION['mail_prof'];
 

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



<?php

 $select_contents = $con->prepare("SELECT * FROM t_cours WHERE id_enseignant = :id_enseignant");
 $select_contents->bindParam(":id_enseignant", $id_enseignant);
$select_contents->execute();
$total_contents = $select_contents->rowCount();

$select_playlists = $con->prepare("SELECT * FROM t_playlist WHERE  id_enseignant = :id_enseignant");
$select_playlists->bindParam(":id_enseignant",$id_enseignant);
$select_playlists->execute();
$total_playlists = $select_playlists->rowCount();

$select_comments = $con->prepare("SELECT * FROM t_commentaire WHERE  id_enseignant = :id_enseignant");
$select_comments->bindParam(":id_enseignant",$id_enseignant);
$select_comments->execute();
$total_comments = $select_comments->rowCount();

 ?>

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
        $select = $con->query("SELECT * FROM `t_enseignant` WHERE id= $id_enseignant" );
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {
         echo '<img class="image" src="imgprof/'.$fetch['image'].'">';       
      }       
      ?>

      <h3 class="name"><span><?= "$nom_prof  $prenom_prof"; ?></span></h3>
      <p class="role"><span><?php echo "$mail_prof" ?></span></p>
     
   </div>
         
         <li>
            <a href="#">
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
            <a href="prestation.php">
                <span class="icon">
                <i class="bi bi-clipboard2" style="color: #0efb2a;"></i>
                </span>
                <span class="title">Prestations</span>
            </a>
         </li>


   <//li>
   <//a href="Visio1.php">
   <//span class="icon">
                <//i class="bi bi-camera-video-fill" style="color: #0efb2a;"><//i>
                <//span>
   <//span class="title"><//span>
            <//a>
         <//li>


        
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
         <h3 class="name"><?php echo "$nom_prof $prenom_prof" ?></h3>
         <p class="role">Formateur</p>
         <div class="flex-btn">
         <a href="modifprof.php" class="option-btn">Modifier profil</a>
         <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
         </div>


   </div>
         
   <section class="dashboard">

<h1 class="heading">Tableau de bord</h1>

<div class="box-container">

   <div class="box">
      <h3>Bienvenue!</h3>
      <p><?= $nom_prof; ?></p>
      <a href="profile.php" class="btn">voir le profil</a>
   </div>

   <div class="box">
      <h3><?= $total_contents; ?></h3>
      <p>cours postés</p>
      <a href="ajouter_cours.php" class="btn">ajouter un nouveau cours</a>
   </div>

   <div class="box">
      <h3><?= $total_playlists; ?></h3>
      <p>Playlist de cours</p>
      <a href="playlist.php" class="btn">Voir</a>
   </div>


   <div class="box">
   <h3><?= $total_comments; ?></h3>
   <p>Commentaires<p>
   <a href="commentaires.php" class="btn">Voir</a>
   </div>

   
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


<script src="script.js"></script>
</body>
</html>