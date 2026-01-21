<?php
include("sessionens.php");

if (isset($_POST['supprimer_groupe'])) {
    $delete_id = $_POST['groupe_id'];
    include("connexion.php");

    $delete_groupe = $con->prepare("SELECT * FROM t_whatsapp WHERE id = :id LIMIT 1");
    $delete_groupe->bindParam(":id", $delete_id);
    $delete_groupe->execute();

    if ($delete_groupe->rowCount() > 0) {
        $delete_lien = $con->prepare("DELETE FROM t_whatsapp WHERE id = :id");
        $delete_lien->bindParam(":id", $delete_id);
        $delete_lien->execute();
        $success_msg[] = 'Lien supprimé avec succès!';
    } else {
        $warning_msg[] = 'Lien déjà supprimé!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace enseignant</title>
    <link rel="icon" href="Images/logoH2Si2.png">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="navigation">
        <ul>
            <li>
                <a href="#">
                    <span class="title">Espace enseignant</span>
                </a>
            </li>
            <div class="profile">
                <?php
                include("connexion.php");
                $select = $con->query("SELECT * FROM `t_enseignant` WHERE id= $id_enseignant");
                while ($fetch = $select->fetch(PDO::FETCH_ASSOC)) {
                    echo '<img class="image" src="imgprof/' . $fetch['image'] . '">';
                }
                ?>
                <h3 class="name"><span><?php echo "$nom_prof $prenom_prof"; ?></span></h3>
                <p class="role"><span><?php echo "$mail_prof"; ?></span></p>
            </div>
            <li>
                <a href="acceuilprof.php">
                    <span class="icon">
                    <i class="fa-solid fa-house" style="color: #0efb2a;"></i>
                    </span>
                    <span class="title">Accueil</span>
                </a>
            </li>
            <li>
                <a href="courenseignant.php">
                    <span class="icon">
                    <i class="fa-solid fa-file-video" style="color: #00ddfa;"></i>
                    </span>
                    <span class="title">Cours</span>
                </a>
            </li>
            <li>
                <a href="playlist.php">
                    <span class="icon">
                    <i class="fas fa-folder-open" style="color: #5ae548;"></i>
                    </span>
                    <span class="title">Playlist</span>
                </a>
            </li>
            <li>
                <a href="programme.php">
                    <span class="icon">
                    <i class="bi bi-calendar-fill" style="color: #00ddfa;"></i>
                    </span>
                    <span class="title">Programme de cours</span>
                </a>
            </li>
            <li>
                <a href="whatsapp.php">
                    <span class="icon">
                    <i class="bi bi-whatsapp" style="color: #00ddfa;"></i>
                    </span>
                    <span class="title">Groupe Whatsapp</span>
                </a>
            </li>
            <li>
                <a href="Visio1.php">
                    <span class="icon">
                    <i class="bi bi-camera-video-fill" style="color: #0efb2a;"></i>
                    </span>
                    <span class="title">Visioconférence</span>
                </a>
            </li>
            <li>
                <a href="deconnexionprof.php">
                    <span class="icon">
                    <i class="fa-solid fa-arrow-right-from-bracket" style="color: #52f10e;"></i>
                    </span>
                    <span class="title">Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="menu">
    <div class="topbar">
        <div class="toggle">
            <i class="fa-solid fa-bars" style="color: #e81c11;"></i>
        </div>
        <a href="#" class="logo"><img src="images/logoH2Si.png" width="70" height="25"></a>
        <div class="search">
            <form action="recherche_prof.php" method="post">
                <label>
                    <input type="text" name="search" placeholder="Que recherchez-vous?">
                    <i class="fa-sharp fa-solid fa-magnifying-glass" name="search_btn" style="color: #7EBB40;"></i>
                </label>
            </form>
        </div>
        <div class="user" id="user-btn">
            <i class="fa-solid fa-user" style="color: #18b7ff;"></i>
        </div>
        <div class="profile2">
            <h3 class="name"><?php echo "$nom_prof $prenom_prof"; ?></h3>
            <p class="role">Formateur</p>
            <div class="flex-btn">
                <a href="modifprof.php" class="option-btn">Modifier profil</a>
                <div id="toggle-btn" class="fas fa-sun"></div>
            </div>
        </div>
    </div>

    <section class="video_call" style="margin-top: 10rem; margin-left: 10rem;">
    <?php
    $select_groupe = $con->prepare("SELECT * FROM t_whatsapp WHERE id_enseignant = :id_enseignant ORDER BY id DESC");
    $select_groupe->bindParam(":id_enseignant", $id_enseignant);
    $select_groupe->execute();

    if ($select_groupe->rowCount() > 0) {
        while ($fetch_groupe = $select_groupe->fetch(PDO::FETCH_ASSOC)) {
            $groupe_id = $fetch_groupe['id'];
            $id_formation = $fetch_groupe['id_formation']; 

      
            $select_nom = $con->prepare("SELECT nom_form FROM t_formation WHERE id = :id_formation");
            $select_nom->bindParam(":id_formation", $id_formation);
            $select_nom->execute();
            $fetch_nom = $select_nom->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="reunion">
                <h3><?php echo $fetch_groupe['lien']; ?></h3>
                <p style="color:#000; font-weight: 700; " >(<?php echo $fetch_nom['nom_form']; ?>)</p>
                <form method="post" action="">
                    <input type="hidden" name="groupe_id" value="<?= $groupe_id; ?>">
                    <input type="submit" value="Supprimer" class="btn-delete" onclick="return confirm('Supprimer le lien?');" name="supprimer_groupe">
                </form>
            </div>
            <?php
        }
    } else {
        echo '<p>Aucun groupe trouvé</p>';
    }
    ?>
</section>


    <footer class="footer">
        &copy; copyright @ 2023 <span>H<b style="color: #e81c11;">2</b>S<b style="color: #e81c11;">I</b></span> | tous droits réservés!
    </footer>
</div>

<script>
    let profile2 = document.querySelector('.menu .topbar .profile2');

    document.querySelector('#user-btn').onclick = () => {
        profile2.classList.toggle('active');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
