<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style1.css">
<title>Administrateur</title>
</head>

<body>
   

<div class="form">
<h1>ESPACE ADMINISTRATEUR</h1>
   <form  action="admin.php" method="post">

   <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

    <h3>Connexion</h3>
     <input type="text" name="mail_ad" placeholder="Email" class="box" required>
     <input type="password" name="mdp_ad" placeholder="mot de passe" class="box" required>
     <input type="submit"  value="Connexion" class="btn">
  </form>
  <div class= "lienprof">
 <p>Vous êtes enseignant ?</p> 

  <a href="enseigne.php"> Connectez-vous ici</a>
  </div>
 
</div>
</body>
</html>