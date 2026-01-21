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
    $id = $_GET["id"];
    include("connexion.php");

    $sql3 = "SELECT * FROM t_etudiant WHERE id = :id";
    $stmt = $con->prepare($sql3);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result3 = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <form action="updatetudiant.php" method="post">
        <input type="hidden" name="id_etudiant" value="<?php echo $id; ?>">
        <input style="margin-top: 30px;" type="text" name="nom_et" placeholder="<?php echo $result3['nom_et']; ?>" class="box" pattern="[A-Za-zÀ-ÿ\s']*[^0-9]+">
        <input style="margin-top: 30px;" type="text" name="prenom_et" placeholder="<?php echo $result3['prenom_et']; ?>" class="box" pattern="[A-Za-zÀ-ÿ\s']*[^0-9]+">
        <input style="margin-top: 30px;" type="text" name="mail_et" placeholder="<?php echo $result3['mail_et']; ?>" class="box">

        <label for="sexe">Modifier sexe :</label>
        <select style="height: 50px;" name="sexe" class="box">
            <option value="" selected><?php echo $result3['sexe']; ?></option>
            <option value="homme">H</option>
            <option value="femme">F</option>
        </select>

        <div>
            <span class="check1" id="check">
                <input width="10" type="checkbox" name="changer_mdp" value="1">
                Changer le mot de passe?
            </span>
            <div class="mdp">
                <span id="messageErreurMotDePasse" style="color: red; font-size:0.8rem; padding:5px; background-color: antiquewhite;"></span>
                <p>nouveau mot de passe :</p>
                <input type="password" name="nouveau_pass" id="nouveau_pass" placeholder="Entrer votre nouveau mot de passe" class="box">
                <p>confirmation :</p>
                <input type="password" name="cpass" placeholder="Confirmer votre mot de passe" class="box">
            </div>
        </div>

        <label for="form">Choisir une nouvelle formation :</label>
        <select name="formation" class="box" style="height: 55px;">
            <option value="" selected><?php echo $result3['nom_form']; ?></option>
            <?php
            $select_formation = $con->prepare("SELECT * FROM t_formation");
            $select_formation->execute();
            if ($select_formation->rowCount() > 0) {
                while ($fetch_formation = $select_formation->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option value="<?= $fetch_formation['id']; ?>"><?= $fetch_formation['nom_form']; ?></option>
                    <?php
                }
            } else {
                echo '<option value="" disabled>Aucune formation disponible!</option>';
            }
            ?>
        </select>

        <input type="text" name="tel_et" placeholder="<?php echo $result3['tel_et']; ?>" class="box">
        <input style="margin-top: 50px;" type="submit" name="submit" value="Modifier" class="btn">
        <a href="etudiant.php"><button class="btn-rt" type="button">Retour</button></a>
    </form>
</div>


<script>

let mdp = document.querySelector('.mdp');

document.querySelector('#check').onclick = () => {
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