
<?php
  include("sessionet.php");
  include("admin/connexion.php");

  $message_info = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom  = htmlspecialchars(trim($_POST['prenom']));
    $nom     = htmlspecialchars(trim($_POST['nom']));
    $mail    = htmlspecialchars(trim($_POST['mail']));
    $tel     = htmlspecialchars(trim($_POST['tel']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!empty($prenom) && !empty($nom) && !empty($mail) && !empty($tel) && !empty($message)) {
        try {
            $sql = "INSERT INTO t_message (id_etudiant, prenom, nom, mail, tel, message) 
                    VALUES (:id_etudiant, :prenom, :nom, :mail, :tel, :message)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                $success_msg[] = '✅ Message envoyé avec succès !';
            } else {
                $warning_msg[] = '❌ Erreur lors de l\'envoi du message.';
            }
        } catch (PDOException $e) {
            $warning_msg[] = 'Erreur : ' . $e->getMessage();
        }
    } else {
        $warning_msg[] = 'Veuillez remplir tous les champs.';
    }
}




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
<style>
   .service-client {
 margin-top: 0;
  margin: 20px ;
  padding: 25px;
 
}

.client-container {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  margin-top: 20px;
}

.client-form {
  flex: 1 1 60%;
  min-width: 320px;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.contact-infos {
  flex: 1 1 35%;
  min-width: 280px;
  height: 300px;
  background-color: #f0f9ff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.contact-infos h3 {
  color: #004080;
  margin-bottom: 15px;
  font-size: 1.3rem;
}

.contact-infos p {
  margin: 10px 0;
  color: #333;
  font-size: 1rem;
}

.contact-infos i {
  margin-right: 8px;
  color: #0090c5;
}

.contact-infos a {
  color: #0077aa;
  text-decoration: none;
}

.contact-infos a:hover {
  text-decoration: underline;
}

/* Responsive */
@media screen and (max-width: 768px) {
  .client-container {
    flex-direction: column;
  }
}

.service-client h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #D84515;
}

.client-form .form-group {
  margin-bottom: 15px;
}

.client-form label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
  color: #333;
}

.client-form input,
.client-form textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #cfd8dc;
  border-radius: 5px;
  font-size: 1em;
}

.client-form button {
  background-color: #D84515;
  color: #fff;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  transition: background 0.3s ease;
}

.client-form button:hover {
  background-color: #8f1b09;
}

.service-client a .bi-box-arrow-right:hover {
    transform: scale(1.1);
}
.service-client a .bi-box-arrow-right {
    font-size: 2rem;
    color: #e81c11;
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #fff;
    padding: 0.5rem;
    border-radius: 50%;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease;
}

@media (max-width: 480px) {
  .service-client {
    padding: 15px;
  }

  .client-form button {
    font-size: 0.95em;
  }
}
</style>

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
            <a href="contactez.php" class="active">
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

  
<!-- Section produits -->
<section class="service-client">
  <h2>Service Client</h2>
  <div class="client-container">

    <?= $message_info; ?>

    <form method="post" class="client-form">
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= $_SESSION['nom_et']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="prenom">Prénoms :</label>
        <input type="text" id="prenom" name="prenom" value="<?= $_SESSION['prenom_et']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="email">Adresse Email :</label>
        <input type="email" id="email" name="mail" value="<?= $_SESSION['mail_et']; ?>" style="background-color:#61c0dfbd; color: azure;" required>
      </div>
      <div class="form-group">
        <label for="tel">Téléphone :</label>
        <input type="tel" id="tel" name="tel"  required>
      </div>
      <div class="form-group">
        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="6" placeholder="Décrivez votre demande ici..." required></textarea>
      </div>
      <button type="submit">Envoyer</button>
    </form>

    <div class="contact-infos">
      <h3>Nos coordonnées</h3>
      <p><i class="bi bi-telephone-fill"></i> +225 01 61 04 52 91</p>
      <p><i class="bi bi-telephone-fill"></i> +225 27 23 41 40 33</p>
      <p><i class="bi bi-envelope-fill"></i> <a href="mailto:groupeh2si@gmail.com">groupeh2si@gmail.com</a></p>
      <p><i class="bi bi-geo-alt-fill"></i> Abidjan-Yopougon Sopim, Ancien Bel Air,<br> au-dessus de la pharmacie Nickibel</p>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>


	