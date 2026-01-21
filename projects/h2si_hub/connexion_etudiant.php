<?php 
if (isset($_POST['submit'])){

    $nom_et = $_POST["nom_et"];
    $prenom_et = $_POST["prenom_et"];
    $mail_et = $_POST["mail_et"];
    $sexe = $_POST["sexe"];
    $formation = $_POST["formation"];
    $tel_et = $_POST["tel_et"];
    $mdp_et = $_POST["mdp_et"];
    $confirme = $_POST["confirme"];
    
    // Vérification correspondance mot de passe
    if ($mdp_et != $confirme) {
        $message[] = 'Les deux mots de passe sont différents';
    } else {
        // Vérifiez si le mot de passe respecte le format requis
        if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $mdp_et)) {
            $message[] = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d\'au moins 8 caractères.';
        }
    }

    // ⚠️ Si une erreur existe, on ne continue pas
    if (!empty($message)) {
        // On s'arrête là, mais on n’utilise pas exit, 
        // donc le HTML de la page continue à s’afficher avec les messages
    } else {

        include("admin/connexion.php");
        
        // Vérification image
        $repertoire = "etudiant/";
        $extention = strrchr($_FILES['photo']['name'], '.'); 
        $image = $_FILES['photo']['name'] = rand(700, 900000) . $extention;
        
        if (!in_array(strtolower($extention), [".png", ".jpg", ".jpeg"])) {
            $message[] = "Impossible d'ajouter un fichier image";
        } elseif (!is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $message[] = "Fichier introuvable";
        } elseif (!move_uploaded_file($_FILES['photo']['tmp_name'], $repertoire . $_FILES['photo']['name'])) {
            $message[] = "Impossible de copier le fichier dans le dossier";
        } else {
            
            // Vérifier email existant
            $sql = "SELECT COUNT(*) FROM t_etudiant WHERE mail_et = :mail_et";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":mail_et", $mail_et);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();
            
            if ($emailExists > 0) {
                $message[] = 'Cet email est déjà utilisé';
            } else {
                // Hachage du mot de passe
                $hashedPassword = password_hash($mdp_et, PASSWORD_DEFAULT);
                
                $select_nom = $con->prepare("SELECT nom_form FROM t_formation WHERE id = :id_formation ");
                $select_nom->bindParam(":id_formation", $formation);
                $select_nom->execute();
                $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);
                
                $sql = "INSERT INTO t_etudiant 
                        (nom_et, prenom_et, mail_et, sexe, id_formation, nom_form, tel_et, mdp_et, image) 
                        VALUES (:nom_et, :prenom_et, :mail_et, :sexe, :id_formation, :nom_form, :tel_et, :mdp_et, :image)";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(":nom_et", $nom_et);
                $stmt->bindParam(":prenom_et", $prenom_et);
                $stmt->bindParam(":mail_et", $mail_et);
                $stmt->bindParam(":sexe", $sexe);
                $stmt->bindParam(":id_formation", $formation);
                $stmt->bindParam(":nom_form", $fetch_nom['nom_form']);
                $stmt->bindParam(":tel_et", $tel_et);
                $stmt->bindParam(":mdp_et", $hashedPassword);
                $stmt->bindParam(":image", $image);
                $stmt->execute();
                $success[] = 'Inscription reussie, connectez-vous!';   
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>H2SI HUB</title>
     <link rel="icon" href="images/icone.png"  >
     <link rel="stylesheet" href="conn_inscription.css">
</head>
<body>
  <?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
      <i class="bi bi-exclamation-triangle-fill"></i>
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<?php
if(isset($success)){
   foreach($success as $success){
      echo '
      <div class="success form">
      <i class="bi bi-check-all"></i>
         <span>'.$success.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<?php if (isset($_GET['erreur'])) { ?>

            <?php echo '
             <div class="erreur form">
             <i class="bi bi-exclamation-triangle-fill"></i>
             <span>'.$_GET['erreur'].'</span>
             <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
          </div>' ; ?>
     	<?php } ?>

      
      <div class="form_container">
        <!-- Login From -->
        <div class="form login_form">
          <form action="etudiant.php" method="post">
            <h2>Connexion</h2>
            <div class="input_box">
            <span class="icons"><i class="bi bi-person-fill"></i></span>
                   <input type="email" name="mail_et" required>
                   <label>Email</label>
            </div>
            <div class="input_box">
                   <input type="password" name="mdp_et" required>
                   <label>Mot de passe</label>
                   <span class="pw_hide">
                    <i class="uil-eye-slash"></i>
                </span>
            </div>
            <div class="option_field">
              <span class="checkbox">
                <input type="checkbox" id="check" />
                <label for="check">Se souvenir</label>
              </span>
              <a href="#" class="forgot_pw">Mot de passe oublié?</a>
            </div>
            <button class="button">Connecter</button>
            <div class="login_signup"><p>Pas de compte?</p>
            <p><a href="#" id="signup">S'inscrire</a></p>
        </div>
          </form>
        </div>
        <!-- Signup From -->
        <div class="form signup_form">
         
    
          <form action="" method="post" enctype="multipart/form-data">
            <h2 class="h">Inscription</h2>
            <div class="noms">

            <div class="input">
                   <input type="text" name="prenom_et" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
                   <label class="label1">Prenom</label>
            </div>
            <div class="input">
                   <input type="text" name="nom_et" required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
                   <label class="label2">Nom</label>
            </div>

            </div>

            <div class="input_bose">
                   <input type="email" name="mail_et" required>
                   <label>Email</label>
            </div>      

            <div class="input-sexe">
                  <div class="custom-select">
                       <select name="sexe" required>
                           <option value="">Sexe</option>
                           <option value="Homme">Homme</option>
                           <option value="Femme">Femme</option>
                           <option value="Autre">Autre</option>
                       </select>
                  </div>
                </div>
<br>
                 <div>
                    <label  style=" color:#D84515; margin-left: 10px; font-size: 10px;">*Ajouter une photo</label>
                <input type="file" name="photo" accept="image/*" class="boxe" >
                </div>

                <br>

                <div class="input-form">
    <label>Formation :</label>
    <div class="custom-select">
        <select name="formation" required>
            <option value="" disabled selected>--choisir--</option>

            <?php
            include('admin/connexion.php');

            // Sélectionner les différents types de formation
            $select_types = $con->prepare("SELECT DISTINCT type_form FROM t_formation");
            $select_types->execute();

            // Parcourir chaque type de formation
            while ($type = $select_types->fetch(PDO::FETCH_ASSOC)) {
                echo '<optgroup label="' . $type['type_form'] . '">'; // Créer un groupe pour chaque type de formation

                // Sélectionner les noms de formation pour ce type
                $select_formations = $con->prepare("SELECT id, nom_form FROM t_formation WHERE type_form = ?");
                $select_formations->execute([$type['type_form']]);

                // Afficher chaque nom de formation
                while ($formation = $select_formations->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $formation['id'] . '">' . $formation['nom_form'] . '</option>';
                }

                echo '</optgroup>'; // Fermer le groupe de formation
            }
            ?>

        </select>
    </div>
</div>


            <div class="input_bose">
                   <input type="number" name="tel_et" required>
                   <label>Telephone</label>
            </div>

            <div class="pass">

            <div class="input1">
                   <input type="password" name="mdp_et" id="mdp_et" required>
                   <label class="label">Mot de passe</label>
                   <span class="ps_hide">
                    <i class="uil-eye-slash"></i>
                </span>
            </div>

          
            <div class="input1">
                   <input type="password" name="confirme" required>
                   <label class="label">Confirmer mot de passe</label>
                   <span class="pw_hide">
                    <i class="uil-eye-slash"></i>
                </span>
            </div>

            </div>
           


            <div class="remember-forgot">
            <input type="checkbox" required>
                    <label>J'accepte les termes& conditions</label>
                </div>
            <button type="submit" name="submit" class="button2">S'inscrire</button>
            
            <div class="login_signup1">Déjà un compte? <a href="#" id="login">Connexion</a></div>
          </form>
          
        </div>
      </div>

      <script src="etudiant.js"></script> 

     <script>
        const psHide = document.querySelector('.pass .ps_hide');
const psInput = document.querySelector('.pass input[type="password"]');


psHide.addEventListener('click', () => {
  if (psInput.type === 'password') {
    psInput.type = 'text';
    psHide.innerHTML = '<i class="uil-eye"></i>';
  } else {
    psInput.type = 'password';
    psHide.innerHTML = '<i class="uil-eye-slash"></i>';
  }
});

const pwHide = document.querySelector('.input1 .pw_hide');
const pwInput = document.querySelector('.input1 input[type="password"]');

  pwHide.addEventListener('click', () => {
  if (pwInput.type === 'password') {
    pwInput.type = 'text';
    pwHide.innerHTML = '<i class="uil-eye"></i>';
  } else {
    pwInput.type = 'password';
    pwHide.innerHTML = '<i class="uil-eye-slash"></i>';
  }
});


    </script>
     

</body>
</html>