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
            <a href="client.php">
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
            <a href="#">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <span class="title">Commandes</span>
            </a>
         </li>

         
         <li>
            <a href="#">
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
            <a href="#">
                <span class="icon">
                    <ion-icon name="document-attach-outline"></ion-icon>
                </span>
                <span class="title">Cours</span>
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
  
    <form  action="" method="post" enctype="multipart/form-data">
    <input  style="margin-top: 30px;" type="text" name="nom_prof" placeholder="Nom" class="box" required>
	<input  style="margin-top: 30px;" type="text" name="prenom_prof" placeholder="Prenom" class="box" required>
    <input style="margin-top: 30px;" type="file" name="photoo" accept="image/*" >
	<input type="text" name="mail_prof" placeholder="Email" class="box" required>
    <input type="text" name="mdp_prof" placeholder="Mot de passe" class="box" required>
	<input type="text" name="confirme" placeholder="Confirmation mot de passe" class="box" required>
   <input style="margin-top: 50px;" type="submit" name="submit"  value="Inscrire" class="btn">
   <a href="enseignant.php"><button class="btn-rt">Retour</a></button>
	</form>
   
    <?php 
if (isset($_POST['submit']))
{
	$nom_prof = $_POST["nom_prof"];
	$prenom_prof = $_POST["prenom_prof"];
    $mail_prof = $_POST["mail_prof"];
	$mdp_prof = $_POST["mdp_prof"];
    $confirme = $_POST["confirme"];
	
	
	$repertoire = "imgprof/";
	$extention = strrchr($_FILES['photoo']['name'],'.');//pour recuperer l'extention
	$image = $_FILES['photoo']['name']=rand(700,900000).$extention;
		echo "";
	if($extention!=".png" && $extention!=".jpg" && $extention!=".jpeg" && $extention!=".PNG" && $extention!=".JPG" && $extention!=".JPEG")
		die("Impossible d'ajouter un fichier image");
	
	if(!is_uploaded_file($_FILES['photoo']['tmp_name']))
		die("Fichier est introuvable");
	
	if(!move_uploaded_file($_FILES['photoo']['tmp_name'],$repertoire.$_FILES['photoo']['name']))
		die("Impossible de copier le fichier dans le dossier");

        if ($mdp_prof!= $confirme){
            $message[] = 'Les deux mots de passe sont différents';
        }
  
        include("connexion.php");
        $sql = "SELECT COUNT(*) FROM t_enseignant WHERE mail_prof = :mail_prof";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_prof", $mail_prof);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();
    
        if ($emailExists > 0) {
          $message[] = 'Cet email est déjà utilisé';
        }
    
        if (empty($message)) {
            // Hachage du mot de passe
            $hashedPassword = password_hash($mdp_prof, PASSWORD_DEFAULT);

        
            $sql = "INSERT INTO t_enseignant(nom_prof,prenom_prof,image,mail_prof,mdp_prof) VALUES(:nom_prof,:prenom_prof,:image,:mail_prof,:mdp_prof)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":nom_prof", $nom_prof);
            $stmt->bindParam(":prenom_prof", $prenom_prof);
            $stmt->bindParam(":image", $image);
            $stmt->bindParam(":mail_prof", $mail_prof);
            $stmt->bindParam(":mdp_prof", $hashedPassword);
            $stmt->execute();
            $success_msg[] = 'Inscription reussi!';
        }            
		
}

?>

    </div>

   </div>
	
   	</div>

   
       <script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
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