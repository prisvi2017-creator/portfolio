<?php
include("session.php");
include("connexion.php");

// Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Répondre à une demande de devis
if (isset($_POST['envoyer_reponse'])) {
    $id_devis = $_POST['id_devis'];
    $reponse = $_POST['reponse'];

    // Récupérer infos du devis
    $select_devis = $con->prepare("SELECT id_client, mail_client FROM t_devis WHERE id = :id");
    $select_devis->bindParam(':id', $id_devis, PDO::PARAM_INT);
    $select_devis->execute();
    $data_devis = $select_devis->fetch(PDO::FETCH_ASSOC);

    if ($data_devis) {
        // 1. Mettre à jour la réponse
        $update = $con->prepare("UPDATE t_devis SET reponse = :reponse WHERE id = :id");
        $update->execute([':reponse' => $reponse, ':id' => $id_devis]);

        // 2. Envoi email avec PHPMailer
        $mail = new PHPMailer(true);
        $mail_sent = false;

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hubhsi14@gmail.com';
            $mail->Password = 'srhmbntzjxmyhitt';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('hubhsi14@gmail.com', 'H2SI Hub');
            $mail->addAddress($data_devis['mail_client']);

            $mail->isHTML(false);
            $mail->Subject = "Réponse à votre demande de devis";
            $mail->Body    = $reponse;

            $mail_sent = $mail->send();
        } catch (Exception $e) {
            $warning_msg[] = "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }

        // 3. Insérer notification
        $titre_notif = "Réponse à votre demande de devis";
        $message_notif = "L'administrateur vous a répondu : \"$reponse\"";

        if (!empty($data_devis['id_client'])) {
            $insert_notif = $con->prepare("INSERT INTO t_notifications (id_client, titre, message) VALUES (:id, :titre, :message)");
            $insert_notif->bindParam(':id', $data_devis['id_client']);
            $insert_notif->bindParam(':titre', $titre_notif);
            $insert_notif->bindParam(':message', $message_notif);
            $insert_notif->execute();
        }

        // 4. Message de confirmation
        if ($mail_sent) {
            $success_msg[] = 'Réponse envoyée par email et enregistrée dans les notifications !'; 
        } else {
            $warning_msg[] = 'Réponse enregistrée mais email non envoyé.'; 
        }
    } else {
        $warning_msg[] = 'Demande de devis introuvable.'; 
    }
}

// Supprimer une demande de devis
if (isset($_GET['supprimer'])) {
    $id_devis = $_GET['supprimer'];
    $delete = $con->prepare("DELETE FROM t_devis WHERE id = :id");
    $delete->execute([':id' => $id_devis]);
    echo "<script>alert('Demande de devis supprimée !'); window.location='devis.php';</script>";
}

// Sélectionner toutes les demandes de devis
$select = $con->prepare("SELECT * FROM t_devis ORDER BY date DESC");
$select->execute();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur - Devis</title>
</head>

<body>
<div class="container">

    <!-- MENU ADMIN (identique à message.php) -->
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
   <a href="commandes.php" style="margin: 15px;">retour sur les commandes</a>
            <?php
        $select = $con->prepare("SELECT * FROM t_devis ");
        $select->execute();
        ?>
        <div style="margin-top:95px; margin-left:28px; max-width:1500px; background:#fff; box-shadow:0 6px 10px rgba(0,0,0,0.25); border-radius:5px; padding:20px;">
            <h2>Liste des demandes de devis</h2>
            <table class="responsive" border="0" width="100%">
                <tr class='con'>
                    <th>N°</th>
                    <th>Nom du client</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Société</th>
                    <th>Type produit</th>
                    <th>Détails</th>
                    <th>Réponse</th>
                    <th>Action</th>
                </tr>

                <?php if ($select->rowCount() > 0): ?>
                    <?php while ($fetch = $select->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $fetch['id']; ?></td>
                            <td><?= $fetch['nom_client']; ?></td>
                            <td><?= $fetch['mail_client']; ?></td>
                            <td><?= $fetch['numero']; ?></td>
                            <td><?= $fetch['societe']; ?></td>
                            <td><?= $fetch['type_pdt']; ?></td>
                            <td><?= nl2br($fetch['details']); ?></td>
                            <td><?= nl2br($fetch['reponse']); ?></td>
                            <td>
                                <form method="POST" style="display:flex; flex-direction:column; gap:5px;">
                                    <textarea name="reponse" rows="3" placeholder="Votre réponse..."><?= $fetch['reponse']; ?></textarea>
                                    <input type="hidden" name="id_devis" value="<?= $fetch['id']; ?>">
                                    <button type="submit" name="envoyer_reponse" style="background:#28a745; color:white; border:none; padding:5px;">Enregistrer</button>
                                    <a href="devis.php?supprimer=<?= $fetch['id']; ?>" onclick="return confirm('Supprimer cette demande de devis ?')" style="background:#dc3545; color:white; padding:5px; text-align:center; text-decoration:none;">Supprimer</a>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align:center;">Aucune demande de devis</td></tr>
                <?php endif; ?>
            </table>
        
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
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
