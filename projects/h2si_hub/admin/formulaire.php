<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>

</head>

<body>

   <div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">

   
    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
        }
    }
     ?>

     <input type="text" name="nom_ad" placeholder="Entrer votre nom" class="box" required>
     <input type="text" name="prenom_ad" placeholder="Entrer votre prenom" class="box" required>
     <input type="email" name="mail_ad" placeholder="Entrer votre mail" class="box" required>
     <input type="password" name="mdp_ad" placeholder="Entrer votre mot de passe" class="box" required>
     <input type="password" name="confirmation" placeholder="Confirmer votre mot de passe" class="box" required>
    <input type="file" name="image" class="boxe" accept="image/jpg, image/jpeg, image/png">
    <input type="submit" value="Enregistrer" class="btn">
    <a href="tableau.php"><button class="btn-rt">Retour</a></button>
   </form>
</div>
</div>
<?php
      if(isset($_POST["nom_ad"])&& isset($_POST["prenom_ad"])&& isset($_POST["mail_ad"])&& isset($_POST["mdp_ad"])&&!empty($_POST["nom_ad"])&&
      !empty($_POST["prenom_ad"]) && !empty($_POST["mail_ad"])&&
      !empty($_POST["mdp_ad"]))
      {
       $nom_ad=$_POST["nom_ad"];
       $prenom_ad=$_POST["prenom_ad"];
       $mail_ad=$_POST["mail_ad"];
       $mdp_ad=$_POST["mdp_ad"];
       $confirmation=$_POST["confirmation"];


       $repertoire = "id/";
       $extention = strrchr($_FILES['image']['name'],'.');
       $image = $_FILES['image']['name']=rand(700,900000).$extention;
           echo "<br> $extention <br>";
       if($extention!=".png" && $extention!=".jpg" && $extention!=".jpeg" && $extention!=".PNG" && $extention!=".JPG" && $extention!=".JPEG")
           die("Impossible d'ajouter un fichier image");
       
       if(!is_uploaded_file($_FILES['image']['tmp_name']))
           die("Fichier est introuvable");
       
       if(!move_uploaded_file($_FILES['image']['tmp_name'],$repertoire.$_FILES['image']['name']))
           die("Impossible de copier le fichier dans le dossier");

 
 if ($mdp_ad!= $confirmation)
   die("Les deux mot de passe sont different");
 $mdp_ad2 = sha1($mdp_ad);


    include("connexion.php");
    $date=gmdate("y-m-d");
$sql = "INSERT INTO t_admin(nom_ad,prenom_ad,mail_ad,mdp_ad,image,date)  VALUES('$nom_ad','$prenom_ad','$mail_ad','$mdp_ad2','$image','$date')";
   $rep = $con -> exec($sql);

   if($rep)

   $success_msg[] = 'Inscription reussi,connectez-vous!';
      }
      

?>

<script src="menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>