
<?php
  include("sessionet.php");

  include("admin/connexion.php");


  $formation_id_etudiant = $_SESSION['formation_id_etudiant'];
  

  $select_playlists = $con->prepare("SELECT * FROM t_playlist WHERE id_formation = :id_formation");
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
   <link rel="icon" href="Images/icone.png">
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
            <a href="propos.php" class="active">
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

  
 <section class="about-section">
   <h1 class="heading">FAQ</h1>

   <div class="accordion-container">

      <div class="accordion-item">
         <button class="accordion-header">Comment suivre un cours ?</button>
         <div class="accordion-body">
            <p>Vous pouvez consulter les vidéos de cours, lire les fichiers PDF, télécharger les supports et interagir avec les formateurs via l’espace de commentaires.</p>
         </div>
      </div>

      <div class="accordion-item">
         <button class="accordion-header">Comment modifier mon mot de passe ?</button>
         <div class="accordion-body">
            <p>Rendez-vous dans l’onglet Profil, Cliquez sur modifier profil et 
               choisissez l'option modifier mot de passe en entrant d'abord
                votre ancien mot de passe
            </p>
      
         </div>
      </div>

        <div class="accordion-item">
         <button class="accordion-header">Comment vous contactez en cas de soucis?</button>
         <div class="accordion-body">
            <p>Vous pouvez nous contactez  via l'onglet contact en envoyant un message</p>
         </div>
      </div>

      <div class="accordion-item">
         <button class="accordion-header">Comment effectuer le paiement de mon versement ou Scolarité?</button>
         <div class="accordion-body">
            <p>Le paiement de la formation se fait en ligne via Wave. Une fois le paiement validé, l’accès au contenu de la formation est immédiat.</p>
         </div>
      </div>

    

   </div>
</section>
 
<script>
   const accordions = document.querySelectorAll('.accordion-item');
   accordions.forEach(item => {
      const header = item.querySelector('.accordion-header');
      header.addEventListener('click', () => {
         const openItem = document.querySelector('.accordion-item.active');
         if (openItem && openItem !== item) {
            openItem.classList.remove('active');
         }
         item.classList.toggle('active');
      });
   });
</script>



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


<script src="scripte.js"></script>
</body>
</html>


	