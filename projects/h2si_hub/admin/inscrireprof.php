<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="style2.css">
<title>Espace enseignant</title>


</head>



<body>



   <div style="background: url('Images/fnddd.png') no-repeat;
    background-size: cover;" class="form-container">
  
    <form  action="" method="post" enctype="multipart/form-data" onsubmit="return validerFormulaire()">
    <span id="messageErreurMotDePasse" style="color: red; font-size:0.8rem; padding:5px; background-color: antiquewhite;"></span>
    <input  style="margin-top: 30px;" type="text" name="nom_prof" placeholder="Nom" class="box" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
	<input  style="margin-top: 30px;" type="text" name="prenom_prof" placeholder="Prenom" class="box" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
    <input style="margin-top: 30px;" type="file" name="photoo" accept="image/*" >
	<input type="text" name="mail_prof" placeholder="Email" class="box" required>
    <input type="text" name="mdp_prof" id="mdp_prof" placeholder="Mot de passe" class="box" required>
	<input type="text" name="confirme" placeholder="Confirmation mot de passe" class="box" required>
   <input style="margin-top: 50px;" type="submit" name="submit"  value="Inscrire" class="btn">
	</form>
    <a href="enseigne.php"> <button class="btn-rt">
    <i style="font-weight: 900; font-size:35px;" class="bi bi-arrow-right">
</i>
</a>
</button>
    </div> 
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
            $success_msg[] = 'Inscription reussi,connectez-vous!';
        }            
		
}

?>

    </div>
    <script>
        function validerFormulaire() {
            var motDePasse = document.getElementById("mdp_prof").value;
            var regexMotDePasse = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;

            if (!regexMotDePasse.test(motDePasse)) {
                document.getElementById("messageErreurMotDePasse").innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 8 caractères.";
                return false;
            }

            // Autres validations et traitement du formulaire ici

            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
 </body>
 

 
</html>