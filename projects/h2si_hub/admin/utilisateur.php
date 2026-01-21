<?php
 session_start ();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail_ad']) && isset($_POST['mdp_ad']) && !empty($_POST['mail_ad']) && !empty($_POST['mdp_ad'])) {
        $mail_ad = $_POST['mail_ad'];
        $mdp_ad = $_POST['mdp_ad'];

        include("connexion.php");

        $sql = "SELECT * FROM t_admin WHERE mail_ad = :mail_ad";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":mail_ad", $mail_ad);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe
            if (password_verify($mdp_ad, $user['mdp_ad'])) {
                // Connexion réussie
                $_SESSION['id_admin'] = $user['id'];
                $_SESSION['mail_ad'] = $user['mail_ad'];
                $_SESSION['nom_ad'] = $user['nom_ad']; 
                $_SESSION['prenom_ad'] = $user['prenom_ad']; 

                // Redirection vers la page protégée ou autre traitement
              
            } else {
                // Mot de passe incorrect
                header("Location: index1.php?error=Mot de passe incorrect");
                exit();
            }
        } else {
            // Adresse email non valide
            header("Location: index1.php?error=Adresse email non valide");
            exit();
        }
      
    }

   }

   if (!isset($_SESSION['id_admin'])) {
      header("Location: index1.php");
      exit(); // Assure que le script s'arrête après la redirection
  }
   
$id_admin = $_SESSION['id_admin'];
$nom_ad = $_SESSION['nom_ad'];
$prenom_ad = $_SESSION['prenom_ad'];
$mail_ad = $_SESSION['mail_ad'];
 

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>

</head>

<body>

<?php
include("connexion.php");

 $select_admin = $con->prepare("SELECT id FROM t_admin");
 $select_admin->execute();
 $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
 

$select_etudiants = $con->prepare("SELECT * FROM t_etudiant ");
$select_etudiants->execute();
$total_etudiants = $select_etudiants->rowCount();


$select_produit = $con->prepare("SELECT * FROM t_produit ");
$select_produit ->execute();
$total_produit  = $select_produit ->rowCount();

$select_commandes = $con->prepare("SELECT * FROM t_commande ");
$select_commandes ->execute();
$total_commandes  = $select_commandes ->rowCount();

$select_messages = $con->prepare("SELECT * FROM t_message ");
$select_messages ->execute();
$total_messages  = $select_messages ->rowCount();
 ?>
<!--barre de Navigation-->
<div class="container">
    <div class="navigation">
       <ul>
         <li>
            <a href="#">
                <span class="icon">
                <ion-icon name="desktop-outline"></ion-icon>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
         </li>

         

         <li>
            <a href="produit1.php">
                <span class="icon">
                    <ion-icon name="storefront-outline"></ion-icon>
            </span>
                <span class="title">Produits</span>
            </a>
         </li>

         <li>
            <a href="commande.php">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <span class="title">Commandes</span>
            </a>
         </li>
         
         <li>
            <a href="etudiant1.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Etudiants</span>
            </a>
         </li>
        

         
         <li>
            <a href="newsletter1.php">
                <span class="icon">
                <ion-icon name="newspaper-outline"></ion-icon>              
              </span>
                <span class="title">Newsletter</span>
            </a>
         </li>

         <li>
            <a href="message1.php">
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
            <a href="profil1.php" class="option-btn">Modifier profil</a>
         </div>

      </div>


   </div>
   <section class="dashboard">

<h1 class="heading">Tableau de bord</h1>

<div class="box-container">

   <div class="box">
      <h3>Bienvenue!</h3>
      <p><?= $prenom_ad; ?></p>
      <a href="profil1.php" class="btn">Modifier le profil</a>
   </div>

   
   <div class="box">
      <h3>Total etudiants</h3>
      <p><?= $total_etudiants; ?></p>
      <a href="etudiant1.php" class="btn">voir liste etudiants</a>
   </div>


   <div class="box">
      <h3>Total produits</h3>
      <p><?= $total_produit; ?></p>
      <a href="ajouterproduit1.php" class="btn">ajouter produit</a>
   </div>

   <div class="box">
      <h3>Commandes</h3>
      <p><?= $total_commandes; ?></p>
      <a href="commande.php" class="btn">voir commandes</a>
   </div>


   <div class="box">
      <h3>Messages</h3>
      <p><?= $total_messages; ?></p>
      <a href="message1.php" class="btn">Voir les messages</a>
   </div>

   
</div>

</section>
</div>

<script>
    let profile = document.querySelector('.menu .topbar .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}
</script>

<script src="menu.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>