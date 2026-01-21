<?php
  include("sessionet.php");

  include("admin/connexion.php");


  $formation_id_etudiant = $_SESSION['formation_id_etudiant'];
  

  if (isset($_POST['supprimer_notif'])) {
    $notif_id = $_POST['notif_id'];
    $delete_notif = $con->prepare("DELETE FROM t_notifications WHERE id = :id AND id_etudiant = :id_etudiant");
    $delete_notif->bindParam(":id", $notif_id, PDO::PARAM_INT);
    $delete_notif->bindParam(":id_etudiant", $id_etudiant, PDO::PARAM_INT);
    $delete_notif->execute();
}

// Récupérer le nombre de notifications non lues pour le badge
$count_notif = $con->prepare("SELECT COUNT(*) FROM t_notifications WHERE id_etudiant = :id_etudiant AND est_lue = 0");
$count_notif->bindParam(":id_etudiant", $id_etudiant);
$count_notif->execute();
$num_notif = $count_notif->fetchColumn();

// Récupérer toutes les notifications du client
$select_notif = $con->prepare("SELECT * FROM t_notifications WHERE id_etudiant = :id_etudiant ORDER BY date_envoi DESC");
$select_notif->bindParam(":id_etudiant", $id_etudiant);
$select_notif->execute();
$notifications = $select_notif->fetchAll(PDO::FETCH_ASSOC);

// Optionnel : marquer toutes comme lues
$update_lue = $con->prepare("UPDATE t_notifications SET est_lue = 1 WHERE id_etudiant = :id_etudiant");
$update_lue->bindParam(":id_etudiant", $id_etudiant);
$update_lue->execute();


 
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
<h1 style="border-bottom: 2px dashed #e81c11;" class="heading">Notifications</h1>
<div class="boxis">
    <?php if (count($notifications) > 0): ?>
        <?php foreach ($notifications as $notif): ?>
           <div class="box notif-box">
    <p><b><?= htmlspecialchars($notif['titre']); ?></b></p>
    <p><?= htmlspecialchars($notif['message']); ?></p>
    <p style="font-size:0.8em; color:gray;">Envoyé le : <?= $notif['date_envoi']; ?></p>
   <form method="post" onsubmit="return confirm('Voulez-vous supprimer cette notification ?');">
        <input type="hidden" name="notif_id" value="<?= $notif['id']; ?>">
        <button type="submit" name="supprimer_notif" class="un-supprimer">Supprimer</button>
    </form>
</div>

        <?php endforeach; ?>
    <?php else: ?>
        <p class="vide">Aucune notification disponible !</p>
    <?php endif; ?>
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
    fetch('check.php') // fichier qui renvoie les notifications non lues
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