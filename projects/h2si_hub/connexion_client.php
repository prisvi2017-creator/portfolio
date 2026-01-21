<?php

if (isset($_POST['submit'])){
    $nom_client = $_POST['nom_client'];
    $prenom_client = $_POST['prenom_client'];
    $mail_client = $_POST['mail_client'];
    $mdp_client = $_POST['mdp_client'];
    $confirmation = $_POST['confirmation'];


    if ($mdp_client != $confirmation) {
      $message[] = 'Les deux mots de passe sont différents';
    }else {
      // Vérifiez si le mot de passe respecte le format requis
      if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $mdp_client)) {
        $message[] = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d\'au moins 8 caractères.';
      }
    }

    // Vérification si l'email existe déjà
    include("admin/connexion.php");
    $sql = "SELECT COUNT(*) FROM t_client WHERE mail_client = :mail_client";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":mail_client", $mail_client);
    $stmt->execute();
    $emailExists = $stmt->fetchColumn();

    if ($emailExists > 0) {
      $message[] = 'Cet email est déjà utilisé';
    }

    if (empty($message)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($mdp_client, PASSWORD_DEFAULT);

        $sql = "INSERT INTO t_client (nom_client, prenom_client, mail_client, mdp_client) VALUES (:nom_client, :prenom_client, :mail_client, :mdp_client)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":nom_client", $nom_client);
        $stmt->bindParam(":prenom_client", $prenom_client);
        $stmt->bindParam(":mail_client", $mail_client);
        $stmt->bindParam(":mdp_client", $hashedPassword);
        $stmt->execute();
        $success[] = 'Inscription reussi,connectez-vous!';
      
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


       <div class="form login_form">
      
           <form action="traitement_connexion.php" method="post">
    <h2>Connexion</h2>
    <div class="input_box">
        <span class="icons"><i class="bi bi-person-fill"></i></span>
        <input type="email" name="mail_client" required>
        <label>Email</label>
    </div>
    <div class="input_box">
        <input type="password" name="mdp_client" required>
        <label>Mot de passe</label>
        <span class="pw_hide">
            <i class="uil-eye-slash"></i>
        </span>
    </div>
    
    <input type="submit" class="button" value="Connexion">
    
     <div class="login_signup"><p>Pas de compte?</p>
            <p><a href="#" id="signup">S'inscrire</a></p>
              </div>
</form>

       </div>
   

      

      <div class="form signup_form">

            <h2>Inscription</h2>

    <form action=""  method="post">

     <div class="noms">
            <div class="input">
            <input type="text" name="nom_client"   required  pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
             <label class="label2">Nom</label>
            </div>

            <div class="input">
            <input type="text" name="prenom_client"  required pattern = "[A-Za-zÀ-ÿ\s']*[^0-9]+">
             <label class="label1">Prenom</label>
            </div>

            </div>

            

            <div class="input_bose">
            <input type="email" name="mail_client"  required >
             <label>Email</label>
            <oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
           
               <div class="pass">
            <div class="input1">
            <input type="password" name="mdp_client" required>
            <label class="label">Mot de passe</label>
                   <span class="ps_hide">
                    <i class="uil-eye-slash"></i>
                </span>
            </div>


            <div class="input1">
            <input type="password" name="confirmation"  required>
             <label class="label">Confirmer mot de passe</label>
                   <span class="pw_hide">
                    <i class="uil-eye-slash"></i>
                </span>
           <oninput="this.value = this.value.replace(/\s/g, '')">
           </div>

           </div>

            <div class="remember-forgot">
            <input type="checkbox" required>
                    <label>J'accepte les termes& conditions</label>
                </div>
            <input type="submit" name="submit" value="S'inscrire"  class="button2">

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