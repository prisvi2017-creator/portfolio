<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>
<?php
 include("session.php");
 include("connexion.php");
?>

</head>



<body>

<div class="container">
    <div class="navigation">
       <ul>
         <li>
            <a href="tableau.php">
                <span class="icon">
                <ion-icon name="desktop-outline"></ion-icon>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
         </li>

         
         <li>
            <a href="Client.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Client</span>
            </a>
         </li>

         <li>
            <a href="produit.php">
                <span class="icon">
                    <ion-icon name="storefront-outline"></ion-icon>
            </span>
                <span class="title">Produits</span>
            </a>
         </li>

         <li>
            <a href="commandes.php">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <span class="title">Commandes</span>
            </a>
         </li>

        
         <li>
            <a href="etudiant.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Etudiants</span>
            </a>
         </li>
         <li>
            <a href="enseignant.php">
                <span class="icon">
                    <ion-icon name="person-sharp"></ion-icon>
                </span>
                <span class="title">Enseignant</span>
            </a>
         </li>
         <li>
            <a href="formation.php">
                <span class="icon">
                    <ion-icon name="document-attach-outline"></ion-icon>
                </span>
                <span class="title">Formations</span>
            </a>
         </li>

         <li>
            <a href="newsletter.php">
                <span class="icon">
                <ion-icon name="newspaper-outline"></ion-icon>              
              </span>
                <span class="title">Newsletter</span>
            </a>
         </li>


         <li>
            <a href="message.php">
                <span class="icon">
                <ion-icon name="mail-unread-outline"></ion-icon>
                </span>
                <span class="title">Messages</span>
            </a>
         </li>


         <li>
            <a href="deconnexion.php">
                <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="title">Deconnexion</span>
            </a>
         </li>
       </ul>
    </div>

	
<div class="menu">

   <div class="topbar">


   <div class="toggle">
   <ion-icon name="menu-outline"></ion-icon>
   </div>

   <div class="search">
     <label>
        <input type="text" placeholder="Que recherchez-vous?">
        <ion-icon name="search-outline"></ion-icon>
     </label>
   </div>
   
   <div class="Bienvenue">
   <p>Bienvenue,<span><?php echo "$prenom_ad" ?></span></p>
   </div>

   <div class="user" id="user-btn">

   <?php
        $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {        
         echo '<img  src="id/'.$fetch['image'].'">';  
       }  
      ?>

   </div>
   <div class="profile">

   <?php
        $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
      while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {        
         echo '<img class="image"  src="id/'.$fetch['image'].'">';  
       }  
      ?>
         <h3 class="name"><?= "$nom_ad  $prenom_ad"; ?></h3>
         <div class="flex-btn">
            <a href="profil.php" class="option-btn">Modifier profil</a>
            <a href="adminn.php" class="option-btn">Nouvel admin</a>
         </div>

      </div>

   </div>

   <div class="form-container">

   <?php
$id = $_GET["modifie"];
include("connexion.php");
$select_enseignant = $con->prepare("SELECT * FROM t_enseignant WHERE id = :id ");
$select_enseignant->bindParam(":id", $id);
$select_enseignant->execute();
if($select_enseignant->rowCount() > 0){
while($fetch_enseignant = $select_enseignant->fetch(PDO::FETCH_ASSOC)){
   $id_enseignant = $fetch_enseignant['id'];

	?>

  <form  action="updateprof.php" method="post" enctype="multipart/form-data" onsubmit="return validerFormulaire()">
  <input type="hidden" name="ancien_image" value="<?=$fetch_enseignant['image']; ?>">
  <input type=text name="id" value="<?=$id_enseignant; ?>" >
  <input  style="margin-top: 30px;" type="text" name="nom_prof"  placeholder="<?=$fetch_enseignant['nom_prof']; ?>" class="box"   pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
  <input  style="margin-top: 30px;" type="text" name="prenom_prof"  placeholder="<?=$fetch_enseignant['prenom_prof']; ?>" class="box"   pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
    <input style="margin-top: 30px;" type="file"  name="image" >
    <img src="imgprof/<?= $fetch_enseignant['image']; ?>" width="100">
    <input  style="margin-top: 30px;" type="text" name="mail_prof"  placeholder="<?=$fetch_enseignant['mail_prof']; ?>" class="box">

    <div>
         <span class="check1" id="check">
            <input width="10" type="checkbox" name="changer_mdp" value="1">
             Changer le mot de passe?  
      </span>
         <div class="mdp">
         <span id="messageErreurMotDePasse" style="color: red; font-size:0.8rem; padding:5px; background-color: antiquewhite;"></span>
            <p>Ancien mot de passe :</p>
            <input type="password" name="ancien_pass" placeholder="Entrer votre ancien mot de passe"   class="box">
            <p>nouveau mot de passe :</p>
            <input type="password" name="nouveau_pass" id="nouveau_pass"  placeholder="Entrer votre nouveau mot de passe"   class="box">
            <p>confirmation :</p>
            <input type="password" name="cpass" placeholder="Confirmer votre mot de passe" class="box">
            </div>
         </div>
   <input style="margin-top: 50px;" type="submit" name="submit"  value="Modifier" class="btn">
   <a href="enseignant.php"><button class="btn-rt">Retour</a></button>
  </form>
  <?php
      } 
   }else{
      echo '<p class="empty">Aucun enseignant disponible!</p>';
   }
   ?>
   
	   </div>
	
   	</div>

      <script>
        function validerFormulaire() {
            var motDePasse = document.getElementById("nouveau_pass").value;
            var regexMotDePasse = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;

            if (!regexMotDePasse.test(motDePasse)) {
                document.getElementById("messageErreurMotDePasse").innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 8 caractères.";
                return false;
            }

            // Autres validations et traitement du formulaire ici

            return true;
        }
    </script>

       <script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}
</script>

<script>
   let mdp = document.querySelector('.mdp');

   document.querySelector('#check').onclick = () =>{
         mdp.classList.toggle("open");
      }
</script>

<script src="menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
 </body>
 

 
</html>