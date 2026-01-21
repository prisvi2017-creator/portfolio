<?php
include("session.php");
include("connexion.php");

// Import PHPMailer (déclaration en haut)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Répondre à un message
if (isset($_POST['envoyer_reponse'])) {
    $id_message = $_POST['id_message'];
    $reponse = $_POST['reponse'];

    // Récupérer infos du message
    $select_msg = $con->prepare("SELECT id_client, id_etudiant, mail FROM t_message WHERE id = :id");
    $select_msg->bindParam(':id', $id_message, PDO::PARAM_INT);
    $select_msg->execute();
    $data_msg = $select_msg->fetch(PDO::FETCH_ASSOC);

    if ($data_msg) {
        // --- 1. Mettre à jour la réponse ---
        $update = $con->prepare("UPDATE t_message SET reponse = :reponse WHERE id = :id");
        $update->execute([':reponse' => $reponse, ':id' => $id_message]);

        // --- 2. Envoi email avec PHPMailer ---
        $mail = new PHPMailer(true);
        $mail_sent = false; // valeur par défaut

        try {
            // Config SMTP Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hubhsi14@gmail.com';
            $mail->Password = 'srhmbntzjxmyhitt'; // mot de passe d'application sans espace
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Expéditeur et destinataire
            $mail->setFrom('hubhsi14@gmail.com', 'H2SI Hub');
            $mail->addAddress($data_msg['mail']);

            // Contenu du mail
            $mail->isHTML(false);
            $mail->Subject = "Réponse à votre message";
            $mail->Body    = $reponse;

            $mail_sent = $mail->send();
        } catch (Exception $e) {
            $warning_msg[] = "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }

        // --- 3. Insérer notification ---
        $titre_notif = "Réponse à votre message";
        $message_notif = "L'administrateur vous a répondu : \"$reponse\"";

        if (!empty($data_msg['id_client'])) {
            $insert_notif = $con->prepare("INSERT INTO t_notifications (id_client, titre, message) VALUES (:id, :titre, :message)");
            $insert_notif->bindParam(':id', $data_msg['id_client']);
        } elseif (!empty($data_msg['id_etudiant'])) {
            $insert_notif = $con->prepare("INSERT INTO t_notifications (id_etudiant, titre, message) VALUES (:id, :titre, :message)");
            $insert_notif->bindParam(':id', $data_msg['id_etudiant']);
        }

        if (isset($insert_notif)) {
            $insert_notif->bindParam(':titre', $titre_notif);
            $insert_notif->bindParam(':message', $message_notif);
            $insert_notif->execute();
        }


        // --- 4. Message de confirmation ---
        if ($mail_sent) {
            $success_msg[] = 'Réponse envoyée par email et enregistrée dans les notifications !'; 
        } else {
            $warning_msg[] = 'Réponse enregistrée mais email non envoyé.'; 
        }
    } else {
        $warning_msg[] = 'Message introuvable.'; 
    }
}

// Supprimer un message
if (isset($_GET['supprimer'])) {
    $id_message = $_GET['supprimer'];
    $delete = $con->prepare("DELETE FROM t_message WHERE id = :id");
    $delete->execute([':id' => $id_message]);
    echo "<script>alert('Message supprimé !'); window.location='message.php';</script>";
}

// Sélectionner tous les messages
$select = $con->prepare("SELECT * FROM t_message");
$select->execute();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style2.css">
<title>Administrateur</title>

</head>

<body>

<div class="container">

    <!-- MENU ADMIN ORIGINAL -->
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
    <!-- FIN MENU -->

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

        <?php
        $select = $con->prepare("SELECT * FROM t_message ");
        $select->execute();
        ?>

         <div style="margin-top:95px; margin-left:28px; max-width:1500px; background:#fff; box-shadow:0 6px 10px rgba(0,0,0,0.25); border-radius:5px; padding:20px;">
            <h2>Liste des messages</h2>
            <table class="responsive" border="0" width="100%">
                <tr class='con'>
                    <th>N°</th>
                    <th>Nom et Prénoms</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Message</th>
                    <th>Réponse</th>
                    <th>Action</th>
                </tr>

                <?php if ($select->rowCount() > 0): ?>
                    <?php while ($fetch = $select->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $fetch['id']; ?></td>
                            <td><?= $fetch['nom'] . ' ' . $fetch['prenom']; ?></td>
                            <td><?= $fetch['mail']; ?></td>
                            <td><?= $fetch['tel']; ?></td>
                            <td><?= nl2br($fetch['message']); ?></td>
                            <td><?= nl2br($fetch['reponse']); ?></td>
                            <td>
                                <!-- Formulaire intégré -->
                                <form method="POST" style="display:flex; flex-direction:column; gap:5px;">
                                    <textarea name="reponse" rows="3" placeholder="Votre réponse..."><?= $fetch['reponse']; ?></textarea>
                                    <input type="hidden" name="id_message" value="<?= $fetch['id']; ?>">
                                    <button type="submit" name="envoyer_reponse" style="background:#28a745; color:white; border:none; padding:5px;">Enregistrer</button>
                                    <a href="message.php?supprimer=<?= $fetch['id']; ?>" onclick="return confirm('Supprimer ce message ?')" style="background:#dc3545; color:white; padding:5px; text-align:center; text-decoration:none;">Supprimer</a>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Aucun message</td></tr>
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
