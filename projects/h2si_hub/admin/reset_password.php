<?php
session_start();

// Inclure le fichier de connexion à la base de données
include ('connexion.php'); // Assurez-vous de remplacer 'connexion.php' par le chemin correct

$success_msg = array();
$warning_msg = array();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Récupérer l'adresse e-mail associée au token depuis la base de données
    try {
        $stmt = $con->prepare("SELECT mail_prof FROM t_enseignant WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $mail_prof = $row['mail_prof'];

            if (isset($_POST['nouveau_mdp']) && isset($_POST['confirme_mdp'])) {
                $nouveau_mdp = $_POST['nouveau_mdp'];
                $confirme_mdp = $_POST['confirme_mdp'];

                if ($nouveau_mdp === $confirme_mdp) {
                    // Hasher le nouveau mot de passe
                    $hashed_password = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

                    try {
                        // Préparer la requête SQL pour mettre à jour le mot de passe
                        $stmt = $con->prepare("UPDATE t_enseignant SET mdp_prof = :mdp_prof, token = NULL WHERE mail_prof = :mail_prof");

                        // Lier les paramètres
                        $stmt->bindParam(':mdp_prof', $hashed_password);
                        $stmt->bindParam(':mail_prof', $mail_prof);

                        // Exécuter la requête
                        $stmt->execute();

                        // Vérifier si la mise à jour a réussi
                        if ($stmt->rowCount() > 0) {
                            $success_msg[] = 'Mot de passe réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.';
                        } else {
                            $warning_msg[] = 'Aucune modification effectuée. Veuillez réessayer.';
                        }
                    } catch (PDOException $e) {
                        $warning_msg[] = 'Une erreur est survenue lors de la réinitialisation du mot de passe : ' . $e->getMessage();
                    }
                } else {
                    $warning_msg[] = 'Les mots de passe ne correspondent pas. Veuillez réessayer.';
                }
            }
        } else {
            $warning_msg[] = 'Le jeton de réinitialisation de mot de passe est invalide.';
        }
    } catch (PDOException $e) {
        $warning_msg[] = 'Une erreur est survenue lors de la vérification du jeton : ' . $e->getMessage();
    }
} else {
    $warning_msg[] = 'Jeton de réinitialisation de mot de passe manquant.';
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
    <?php if(isset($success_msg) || isset($warning_msg)) { ?>
        <div class="message form">
            <?php 
            if(isset($success_msg)) {
                foreach($success_msg as $msg) {
                    echo '<p class="success">' . $msg . '</p>';
                }
            }
            if(isset($warning_msg)) {
                foreach($warning_msg as $msg) {
                    echo '<p class="warning">' . $msg . '</p>';
                }
            }
            ?>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    <?php }?>
    <section class="connexions">
        <div class="connexion">
            <h2>Réinitialisation du mot de passe</h2>
            <form method="post" action="" onsubmit="return validerFormulaire()">
                <span id="messageErreurMotDePasse"></span>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <div class="input-boite">
                    <span class="pw_hide">
                        <i class="uil-eye-slash"></i>
                    </span>
                    <input type="password"  name="nouveau_mdp" required>
                    <label>Nouveau mot de passe :</label>
                </div>
                <div class="input-boite">
                    <span class="ps_hide">
                        <i class="uil-eye-slash"></i>
                    </span>
                    <input type="password"  name="confirme_mdp" required>
                    <label>Confirmer le nouveau mot de passe :</label>
                </div>
                <input type="submit" value="Réinitialiser le mot de passe" class="login-link">
            </form>
        </div>
    </section>
    <script>
        const pwHide = document.querySelector('.input-boite .pw_hide'); 
        const pwInput = document.querySelector('.input-boite input[type="password"]'); 

    pwHide.addEventListener('click', () => {
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            pwHide.innerHTML = '<i class="uil-eye"></i>';
        } else {
            pwInput.type = 'password';
            pwHide.innerHTML = '<i class="uil-eye-slash"></i>';
        }
    });

    const psHide = document.querySelector('.input-boite .ps_hide'); 
    const psInput = document.querySelector('.input-boite input[name="confirme_mdp"]'); 

    psHide.addEventListener('click', () => {
        if (psInput.type === 'password') {
            psInput.type = 'text';
            psHide.innerHTML = '<i class="uil-eye"></i>';
        } else {
            psInput.type = 'password';
            psHide.innerHTML = '<i class="uil-eye-slash"></i>';
        }
    });
</script>

<script>
    function validerFormulaire() {
        var motDePasse = document.querySelector('input[name="nouveau_mdp"]').value;
        var regexMotDePasse = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;

        if (!regexMotDePasse.test(motDePasse)) {
            document.getElementById("messageErreurMotDePasse").innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et avoir une longueur d'au moins 8 caractères.";
            return false;
        }

        // Autres validations et traitement du formulaire ici

        return true;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>