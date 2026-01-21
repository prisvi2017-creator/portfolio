<?php
     if(isset($_POST['submit'])){

       $nom_ad=$_POST["nom_ad"];
       $prenom_ad=$_POST["prenom_ad"];
       $mail_ad=$_POST["mail_ad"];
       $mdp_ad=$_POST["mdp_ad"];
       $confirmation=$_POST["confirmation"];
        
       $repertoire = "id/";
       $extention = strrchr($_FILES['image']['name'],'.');
       $image = $_FILES['image']['name']=rand(700,900000).$extention;
           echo "";
       if($extention!=".png" && $extention!=".jpg" && $extention!=".jpeg" && $extention!=".PNG" && $extention!=".JPG" && $extention!=".JPEG")
           die("Impossible d'ajouter un fichier image");
       
       if(!is_uploaded_file($_FILES['image']['tmp_name']))
           die("Fichier est introuvable");
       
       if(!move_uploaded_file($_FILES['image']['tmp_name'],$repertoire.$_FILES['image']['name']))
           die("Impossible de copier le fichier dans le dossier");

           

           if ($mdp_ad!= $confirmation){
            $warning_msg[] = 'Les deux mots de passe sont différents';
        }

        include("connexion.php");
           $sql = "SELECT COUNT(*) FROM t_admin WHERE mail_ad = :mail_ad";
           $stmt = $con->prepare($sql);
           $stmt->bindParam(":mail_ad", $mail_ad);
           $stmt->execute();
           $emailExists = $stmt->fetchColumn();
       
           if ($emailExists > 0) {
             $warning_msg[] = 'Cet email est déjà utilisé';
           }
         

           if (empty($warning_msg)) {
            // Hachage du mot de passe
            $hashedPassword = password_hash($mdp_ad, PASSWORD_DEFAULT);

        
            $sql = "INSERT INTO t_admin(nom_ad,prenom_ad,mail_ad,mdp_ad,image) VALUES(:nom_ad,:prenom_ad,:mail_ad,:mdp_ad,:image)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":nom_ad", $nom_ad);
            $stmt->bindParam(":prenom_ad", $prenom_ad);
            $stmt->bindParam(":mail_ad", $mail_ad);
            $stmt->bindParam(":mdp_ad", $hashedPassword);
            $stmt->bindParam(":image", $image);
            $stmt->execute();
            $success_msg[] = 'Inscription reussi,connectez-vous!';
        }            
 
      }
      

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>
<?php
 include("session.php");
?>
</head>

<body>

   <div class="form-container">
   <form action="" method="post" enctype="multipart/form-data"  onsubmit="return validerFormulaire()">
   <span id="messageErreurMotDePasse" style="color: red; font-size:0.8rem; padding:5px; background-color: antiquewhite;"></span>
   <input type="text" name="nom_ad" placeholder="Entrer votre nom" class="box" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
<input type="text" name="prenom_ad" placeholder="Entrer votre prenom" class="box" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">

     <input type="email" name="mail_ad" placeholder="Entrer votre mail" class="box" required>
     <input type="password" name="mdp_ad" id="mdp_ad" placeholder="Entrer votre mot de passe" class="box" required>
     <input type="password" name="confirmation" placeholder="Confirmer votre mot de passe" class="box" required>
    <input type="file" name="image" class="boxe" accept="image/jpg, image/jpeg, image/png">
    <input type="submit" name="submit" value="Enregistrer" class="btn">
    <a href="tableau.php"><button class="btn-rt">Retour</a></button>
   </form>
  
</div>

<script>
        function validerFormulaire() {
            var motDePasse = document.getElementById("mdp_ad").value;
            var regexMotDePasse = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;

            if (!regexMotDePasse.test(motDePasse)) {
                document.getElementById("messageErreurMotDePasse").innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 8 caractères.";
                return false;
            }

            // Autres validations et traitement du formulaire ici

            return true;
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