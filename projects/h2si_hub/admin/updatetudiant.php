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
         <li><a href="tableau.php"><span class="icon"><ion-icon name="desktop-outline"></ion-icon></span><span class="title">Tableau de bord</span></a></li>
         <li><a href="Client.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Client</span></a></li>
         <li><a href="produit.php"><span class="icon"><ion-icon name="storefront-outline"></ion-icon></span><span class="title">Produits</span></a></li>
         <li><a href="commandes.php"><span class="icon"><ion-icon name="bag-check-outline"></ion-icon></span><span class="title">Commandes</span></a></li>
         <li><a href="#"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Etudiants</span></a></li>
         <li><a href="enseignant.php"><span class="icon"><ion-icon name="person-sharp"></ion-icon></span><span class="title">Enseignant</span></a></li>
         <li><a href="formation.php"><span class="icon"><ion-icon name="document-attach-outline"></ion-icon></span><span class="title">Formations</span></a></li>
         <li><a href="newsletter.php"><span class="icon"><ion-icon name="newspaper-outline"></ion-icon></span><span class="title">Newsletter</span></a></li>
         <li><a href="message.php"><span class="icon"><ion-icon name="mail-unread-outline"></ion-icon></span><span class="title">Messages</span></a></li>
         <li><a href="deconnexion.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="title">Deconnexion</span></a></li>
       </ul>
    </div>

    <div class="menu">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="search">
                <label>
                    <input type="text" placeholder="Que recherchez-vous?">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <div class="Bienvenue"><p>Bienvenue,<span><?php echo "$prenom_ad" ?></span></p></div>
            <div class="user" id="user-btn">
                <?php
                $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
                while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {
                    echo '<img src="id/'.$fetch['image'].'">';  
                }  
                ?>
            </div>
            <div class="profile">
                <?php
                $select = $con->query("SELECT * FROM `t_admin` WHERE id= $id_admin ");
                while ($fetch= $select->fetch(PDO::FETCH_ASSOC)) {        
                    echo '<img class="image" src="id/'.$fetch['image'].'">';  
                }  
                ?>
                <h3 class="name"><?= "$nom_ad  $prenom_ad"; ?></h3>
                <div class="flex-btn">
                    <a href="profil.php" class="option-btn">Modifier profil</a>
                    <a href="adminn.php" class="option-btn">Nouvel admin</a>
                </div>
            </div>
        </div>
        <a href="#"><button class="btn-aj">Scolarite etudiant</button></a>

        <?php  
        if (isset($_POST['submit'])) {
            $id_etudiant = $_POST['id_etudiant'];
            $nom_et = $_POST["nom_et"];
            $prenom_et = $_POST["prenom_et"];
            $mail_et = $_POST["mail_et"];
            $sexe = $_POST["sexe"];
            $formation = $_POST["formation"];
            $tel_et = $_POST["tel_et"];
            $nouveau_pass = $_POST["nouveau_pass"];
            $cpass = $_POST["cpass"];

            include("connexion.php");

          
      if(!empty($nom_et)){
         $update_nom = $con->prepare("UPDATE t_etudiant SET nom_et =:nom_et WHERE id = :id");
         $update_nom ->bindParam(":nom_et", $nom_et);
         $update_nom ->bindParam(":id", $id_etudiant);
         $update_nom ->execute();
        $success_msg[] = 'nom modifié avec succès!';
      }
 
      if(!empty($prenom_et)){
         $update_prenom = $con->prepare("UPDATE t_etudiant SET prenom_et =:prenom_et WHERE id = :id");
         $update_prenom ->bindParam(":prenom_et", $prenom_et);
         $update_prenom ->bindParam(":id", $id_etudiant);
         $update_prenom ->execute();
        $success_msg[] = 'prenom modifié avec succès!';
      }
 
      if(!empty($mail_et)){
         $select_email = $con->prepare("SELECT mail_et FROM t_etudiant WHERE id =:id AND mail_et = :mail_et");
         $select_email ->bindParam(":id", $id_etudiant);
         $select_email ->bindParam(":mail_et", $mail_et);
         $select_email ->execute();
         if($select_email->rowCount() > 0){
             $warning_msg[] = 'Ce mail existe déjà!';
         }else{
            $update_email = $con->prepare("UPDATE t_etudiant SET mail_et = :mail_et WHERE id =:id ");
            $update_email->bindParam(":mail_et", $mail_et);
            $update_email ->bindParam(":id", $id_etudiant);
            $update_email ->execute();
            $success_msg[] = 'mail modifié avec succès!';
         }
      }
 
      if(!empty($sexe)){
         $update_sexe = $con->prepare("UPDATE t_etudiant SET sexe =:sexe WHERE id = :id");
         $update_sexe ->bindParam(":sexe", $sexe);
         $update_sexe ->bindParam(":id", $id_etudiant);
         $update_sexe ->execute();
        $success_msg[] = 'sexe modifié avec succès!';
      }
 
      if (!empty($formation)) {
       $select_nom = $con->prepare("SELECT nom_form FROM t_formation WHERE id = :id_formation ");
       $select_nom->bindParam(":id_formation", $formation);
       $select_nom->execute();
       $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);
   
       $update_formation = $con->prepare("UPDATE t_etudiant SET id_formation = :id_formation, nom_form = :nom_form WHERE id = :id");
       $update_formation->bindParam(":id_formation", $formation);
       $update_formation->bindParam(":nom_form", $fetch_nom['nom_form']);
       $update_formation->bindParam(":id", $id_etudiant);
       $update_formation->execute();
       $success_msg[] = 'formation modifiée avec succès!';
   }
   
 
 
      if(!empty($tel_et)){
         $update_tel = $con->prepare("UPDATE t_etudiant SET tel_et =:tel_et WHERE id = :id");
         $update_tel ->bindParam(":tel_et", $tel_et);
         $update_tel ->bindParam(":id", $id_etudiant);
         $update_tel ->execute();
        $success_msg[] = 'telephone modifié avec succès!';
      }
 

            if (!empty($nouveau_pass) && $nouveau_pass === $cpass) {
                $nouveau_pass = password_hash($nouveau_pass, PASSWORD_BCRYPT);
                $update_pass = $con->prepare("UPDATE `t_etudiant` SET mdp_et = :mdp_et WHERE id = :id");
                $update_pass->execute([':mdp_et' => $nouveau_pass, ':id' => $id_etudiant]);
                $success_msg[] = 'mot de passe modifié avec succès!';
            }

            header("Location: etudiant.php");
        }
        ?>
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
