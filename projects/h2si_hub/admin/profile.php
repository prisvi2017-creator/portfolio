<?php
  include("sessionens.php");


  include("connexion.php");



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
       <?php
        $select_profil = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id");
        $select_profil->bindParam(":id", $id_enseignant);
        $select_profil->execute();
        $fetch_profile = $select_profil->fetch(PDO::FETCH_ASSOC); 
       ?>  
   <section class="tutor-profile" style="min-height: calc(100vh - 19rem);"> 

   <h1 class="heading">Detail profil</h1>

   <div class="details">
      <div class="tutor">
         <img src="imgprof/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['nom_prof'] . ' ' .$fetch_profile['prenom_prof']; ?></h3>
         <span><?= $fetch_profile['mail_prof']; ?></span>
         <a href="modifprof.php" class="inline-btn">Modifier profil</a>
      </div>
     
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