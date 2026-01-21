<?php

function generateToken($length = 20) {
    return bin2hex(random_bytes($length));
}


include ('connexion.php'); 

// Vérifie si l'utilisateur a soumis le formulaire
if (isset($_POST['submit'])) {
    // Adresse e-mail saisie par l'utilisateur
    $mail_prof = $_POST['mail_prof'];

    // Génère un token aléatoire
    $token = generateToken();

    try {
        // Préparer la requête SQL pour mettre à jour le token dans la base de données
        $stmt = $con->prepare("UPDATE t_enseignant SET token = :token WHERE mail_prof = :mail_prof");

        // Lier les paramètres
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':mail_prof', $mail_prof);

        // Exécuter la requête
        $stmt->execute();

        // Vérifier si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            // URL de réinitialisation avec le token
            $reset_link = "https://groupeh2si.com/admin/reset_password.php?token=$token";

            // Envoi de l'e-mail avec le lien de réinitialisation
            $to = $mail_prof;
            $subject = "Réinitialisation de mot de passe";
            $message = "Bonjour,\n\nPour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :\n$reset_link\n\nCordialement,\nNotre équipe";
            $headers = "From: Groupe H2SI <formationh2si@groupeh2si.com>\r\n";

            // Envoyer l'e-mail
            mail($to, $subject, $message, $headers);

            // Message de confirmation
            $confirmation_message = "Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception.";
        } else {
            $confirmation_message = "Aucune correspondance trouvée pour cet e-mail.";
        }
    } catch (PDOException $e) {
        $confirmation_message = "Une erreur est survenue : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">  
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="style3.css">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <?php if(isset($confirmation_message)) { ?>
        <div class="message form">
            <p><?php echo $confirmation_message; ?></p>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    <?php }?>
    <section class="connexions">
        <div class="connexion">
            <h2>Mot de passe oublié</h2>
            <form method="post">
                <div class="input-boite">
                    <span class="icone"><i class="bi bi-person-fill"></i></span>
                    <input type="email" name="mail_prof" required>
                    <label>Adresse e-mail</label>
                </div>
                <input type="submit" name="submit" value="Envoyer" class="login-link">
            </form>
        </div>
    </section>
</body>
</html>