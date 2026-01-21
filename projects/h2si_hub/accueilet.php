<?php
  include("sessionet.php");

  include("admin/connexion.php");


  $formation_id_etudiant = $_SESSION['formation_id_etudiant'];
  

  $select_playlists = $con->prepare("SELECT * FROM t_playlist WHERE id_formation = :id_formation LIMIT 2");
  $select_playlists->bindParam(":id_formation", $formation_id_etudiant);
  $select_playlists->execute();
 
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
            <a href="#" class="active">
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
  
         
   <section class="home-grid">

<h1 style="border-bottom: 2px dashed #e81c11;" class="heading">Options rapides</h1>

<div class="box-container">
 

   <div style="width: 300px;" class="box">
      <h3 class="title">liste des Formations</h3>
      <div class="flex">
         <a href="#"><span>Santé environnement </span></a>
         <a href="#"><span>management sanitaire et laboratoire</span></a>
         <a href="#"><span>Biologie</span></a>
         <a href="#"><span>Biochimie</span></a>
         <a href="#"><span>Microbiologie </span></a>
         <a href="#"><span>Toxicologie </span></a>
      </div>
   </div>

   <div style="margin-left: 30px;" class="box2">
      <h3 class="title">Modifier son profil</h3>
      <p class="tutor">Changer de mot de passe et de photo de profil</p>
      <a href="modifprof.php" class="inline-btn">Modifier</a>
   </div>

   <div style="margin-left: 30px;" class="box3">
      <h3 class="title"> Scolarité Etudiant</h3>
      <p class="tutor">Payer vos frais d'inscription ou mensualité ici!</p>
      <a href="scolarite_et.php" class="inline-btn">Voir Plus</a>
   </div>


</div>

</section>



<section class="courses">

<h1 style="border-bottom: 2px dashed #e81c11;" class="heading">Cours publiés</h1>


<div class="box-container">

<?php
         if ($select_playlists->rowCount() > 0) {
            while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
               $cours_id = $fetch_playlist['id'];
               $id_enseignant = $fetch_playlist['id_enseignant'];

            
               $select_enseignant = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id_enseignant");
               $select_enseignant->bindParam(":id_enseignant", $id_enseignant);
               $select_enseignant->execute();
               $fetch_enseignant = $select_enseignant->fetch(PDO::FETCH_ASSOC);
             
         ?>


   <div class="box">
      <div class="tutor">
         <img src="admin/imgprof/<?php echo $fetch_enseignant['image']; ?>" alt="">
         <div class="info">
            <h3><?php echo $fetch_enseignant['nom_prof']. ' ' . $fetch_enseignant['prenom_prof']; ?></h3>
         </div>
      </div>
      <div class="thumb">
         <img src="admin/dossierimage/<?php echo $fetch_playlist['image']; ?>" alt="">
         
      </div>
      <h3 class="title"><?php echo $fetch_playlist['titre']; ?></h3>
      <a href="playlist_et.php?get_id=<?= $cours_id; ?>" class="inline-btn">Voir la playlist</a>
   </div>

   <?php
            }
         } else {
            echo '<p class="empty">Aucune playlist disponible pour cette formation.</p>';
         }
         ?>

</div>

<div class="more-btn">
   <a href="coursetudiant.php" class="inline-option-btn">Voir plus</a>
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
<script>
function checkNotifications() {
    fetch('check.php') 
        .then(response => response.json())
        .then(data => {
            if(data.length > 0) {
                data.forEach(notif => {
                    Swal.fire({
                        title: notif.titre,
                        text: notif.message,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Voir',
                        cancelButtonText: 'Fermer'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'notification.php';
                        }
                    });
                });
            }
        })
        .catch(err => console.error(err));
}

// Vérifie toutes les 10 secondes
setInterval(checkNotifications, 10000);
</script>

<script src="scripte.js"></script>
</body>
</html>