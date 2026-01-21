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
            <a href="client.php">
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
  
    <form  action="ajouterproduit.php" method="post" enctype="multipart/form-data">
    <input  style="margin-top: 30px;" type="text" name="nom_pdt" placeholder="Nom produit" class="box" required>
    <select style="margin-top: 30px;" name="categorie" class="box" required>
    <option value="">Sélectionner une catégorie</option>
   <option value="Dentiste">Dentiste</option>
   <option value="Chirurgien">Chirurgien</option>
   <option value="Gynécologue">Gynécologue</option>
   <option value="Infirmier">Infirmier</option>
    <option value="Technicien de laboratoire">Technicien de laboratoire</option>
        <option value="Toutes specialites">Toutes specialites</option>

</select>

	<input  style="margin-top: 30px;" type="text" name="prix" placeholder="Prix" class="box" required>
    <input style="margin-top: 30px;" type="file" name="photo" accept="image/*" >
    <textarea style="margin-top: 30px;" placeholder="Details" name="detail_pdt"  id="" cols="30" rows="10"></textarea>
   <input style="margin-top: 50px;" type="submit"  value="Ajouter" class="btn">
   <a href="produit.php"><button class="btn-rt">Retour</a></button>
	</form>
   
    <?php 
if(isset($_POST["nom_pdt"])&& isset($_POST["categorie"])&& isset($_POST["prix"]) && isset($_POST["detail_pdt"]) && !empty($_POST["nom_pdt"])  && !empty($_POST["categorie"])  && !empty($_POST["prix"]) && !empty($_POST["detail_pdt"]))
{
	$nom_pdt = $_POST["nom_pdt"];
    $categorie = $_POST["categorie"];
	$prix = $_POST["prix"];
	$detail_pdt = $_POST["detail_pdt"];
    
	
	
	$repertoire = "image/";
	$extention = strrchr($_FILES['photo']['name'],'.');//pour recuperer l'extention
	$image = $_FILES['photo']['name']=rand(700,900000).$extention;
		echo "";
	if($extention!=".png" && $extention!=".jpg" && $extention!=".jpeg" && $extention!=".PNG" && $extention!=".JPG" && $extention!=".JPEG")
		die("Impossible d'ajouter un fichier image");
	
	if(!is_uploaded_file($_FILES['photo']['tmp_name']))
		die("Fichier est introuvable");
	
	if(!move_uploaded_file($_FILES['photo']['tmp_name'],$repertoire.$_FILES['photo']['name']))
		die("Impossible de copier le fichier dans le dossier");
	
	include("connexion.php");
$sql = "INSERT INTO t_produit(nom_pdt, prix, image, detail_pdt, categorie) 
        VALUES (:nom_pdt, :prix, :image, :detail_pdt, :categorie)";
$stmt = $con->prepare($sql);
$rep = $stmt->execute([
    ':nom_pdt' => $nom_pdt,
    ':prix' => $prix,
    ':image' => $image,
    ':detail_pdt' => $detail_pdt,
    ':categorie' => $categorie
]);
	
		if($rep)
        $success_msg[] = 'Produit ajouté avec succès!';

            else
            $warning_msg[] = 'Produit non ajouter!';
		
}

?>

    </div>

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