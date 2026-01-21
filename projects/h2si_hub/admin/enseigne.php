<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">  
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
<link rel="stylesheet" href="style3.css">
<title>Espace enseignant</title>
</head>

<body>
   
 <section class="connexions">
        <div class="connexion">
            <h2>Espace enseignant</h2>
            <?php if (isset($_GET['erreur'])) { ?>

<?php echo '
 <div class="erreur form">
 <i class="bi bi-exclamation-triangle-fill"></i>
 <span>'.$_GET['erreur'].'</span>
 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
</div>' ; ?>
<?php } ?>
            <form action="enseignant1.php" method="post">
                <div class="input-boite">
                   <span class="icone"><i class="bi bi-person-fill"></i></span>
                   <input type="email"  name="mail_prof" required>
                   <label>Email</label>
                </div>

                <div class="input-boite">
                <span class="pw_hide">
                    <i class="uil-eye-slash"></i>
                </span>
                   <input type="password"  name="mdp_prof" required>
                   <label>Mot de passe</label>
                </div>
                <div class="remember">
                <label><input type="checkbox" name="remember"> Se souvenir</label>
                <a href="mot_de_passe_oublie.php">Mot de passe oublié?</a>
            </div>
              <input type="submit" value="Connexion" class="login-link">
              <div class= "lienprof">
 <p>Vous n'avez de compte ?</p> 
  <a href="inscrireprof.php">Inscrivez-vous</a>
        </div>
            </form>
           
        </div>
        </section>
        <script>
             const pwHide = document.querySelector('.input-boite .pw_hide'); // Modification du sélecteur ici
    const pwInput = document.querySelector('.input-boite input[type="password"]'); // Modification du sélecteur ici

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