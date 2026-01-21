<?php
include("sessioneq.php");

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:commande.php');
    exit;
}

$statut_cmde = 'Annuler';

// Annuler la commande
if (isset($_POST['annuler'])) {
    $update_commande = $con->prepare("UPDATE t_commande SET statut_cmde = :statut_cmde WHERE id=:id");
    $update_commande->bindParam(":statut_cmde", $statut_cmde, PDO::PARAM_STR);
    $update_commande->bindParam(":id", $get_id, PDO::PARAM_INT);
    $update_commande->execute();
    header('location:commande.php');
    exit;
}

// Marquer comme livré

if (isset($_POST['livrer'])) {
    $update_commande = $con->prepare("UPDATE t_commande SET statut_cmde = 'Livré' WHERE id = :id");
    $update_commande->bindParam(":id", $get_id, PDO::PARAM_INT);
    $update_commande->execute();

    // Récupérer l'id du client
    $select_commande = $con->prepare("SELECT id_client FROM t_commande WHERE id = :id");
    $select_commande->bindParam(":id", $get_id, PDO::PARAM_INT);
    $select_commande->execute();
    $client = $select_commande->fetch(PDO::FETCH_ASSOC);
    $client_id = $client['id_client'];

    // Insérer la notification
    $titre = "Livraison effectuée";
    $message = "Votre commande n°$get_id a été livrée avec succès. Merci de nous avoir fait confiance !";
    $insert_notif = $con->prepare("INSERT INTO t_notifications (id_client, titre, message) VALUES (:id_client, :titre, :message)");
    $insert_notif->bindParam(":id_client", $client_id);
    $insert_notif->bindParam(":titre", $titre);
    $insert_notif->bindParam(":message", $message);
    $insert_notif->execute();

    header("Location: commande.php");
    exit;
}

// Supprimer la commande pour le client (mais pas dans la base de données)
if (isset($_POST['supprimer'])) {
    $update_visible = $con->prepare("UPDATE t_commande SET visible_client = 0 WHERE id = :id");
    $update_visible->bindParam(":id", $get_id, PDO::PARAM_INT);
    $update_visible->execute();
    header("Location: commande.php");
    exit;
}

?>


  

<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <meta http-equiv="X-UA-Compatible" content="IE=chrome">
    <title>H2SI HUB</title>
    <link rel="icon" href="Images/icone.png">
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<!-- Barre de navigation -->
<div class="navbar-container">
    <div class="navbar-top">
        <a href="#" class="logo"><img src="Images/H2SI Hub.png" class="logo-img" alt="H2SI Logo" /></a>
        <div class="nav-icons">
            <i class="bi bi-search" id="search-icon"></i>
            <a href="panier.php" class="panier">
                <i class="bi bi-cart-fill"></i>
                <sup>
                    <?php
                    $count_panier = $con->prepare("SELECT COUNT(*) FROM t_panier WHERE id_client = :id_client");
                    $count_panier->bindParam(":id_client", $id_client);
                    $count_panier->execute();
                    echo $count_panier->fetchColumn();
                    ?>
                </sup>
            </a>
            <a href="wishlist.php" class="wishlist">
                <i class="bi bi-suit-heart-fill"></i>
                <sup>
                    <?php
                    $count_wishlist = $con->prepare("SELECT COUNT(*) FROM t_wishlist WHERE id_client = :id_client");
                    $count_wishlist->bindParam(":id_client", $id_client);
                    $count_wishlist->execute();
                    echo $count_wishlist->fetchColumn();
                    ?>
                </sup>
            </a>

            <a href="notif.php" class="wishlist"><i class="bi bi-bell-fill"></i><sup><?= $num_notif ?></sup></a>
            <i class="bi bi-person-fill" id="person-icon"></i>
        </div>
    </div>

    <nav class="sidebar">
        <ul class="nav-links">
            <li><a href="moncompte.php" class="nav-link">Mon compte</a></li>
            <li><a href="eqconnect.php" class="nav-link">Produits</a></li>
            <li><a href="presentation.php" class="nav-link">Catégories</a></li>
            <li><a href="commande.php" class="nav-link active">Commandes</a></li>
            <li><a href="devis.php" class="nav-link">Demandes de devis</a></li>
            <li><a href="service_client.php" class="nav-link">Service client</a></li>
            <li><a href="faq.php" class="nav-link">À propos</a></li>
        </ul>
    </nav>
</div>

<div class="search-box">
    <form action="rechercheproduit.php" method="post">
        <input type="search" name="search" placeholder="Rechercher..">
    </form>
</div>

<div class="user-box">
    <p>Nom : <span><?php echo $nom_client . ' ' . $prenom_client; ?></span></p>
    <p>Email : <span><?php echo $mail_client; ?></span></p>
    <a href="moncompte.php" class="compte">Mon compte</a>
    <a href="deconnexioneq.php" class="deconnexion-btn">Déconnexion</a>
</div>
<!-- Fin barre navigation -->

<section class="voir_page">
    <h1 class="title">Détail commande</h1>
    <div class="box-container">
        <?php 
        $grand_total = 0;
        $select_commande = $con->prepare("SELECT * FROM t_commande WHERE id=:id LIMIT 1");
        $select_commande->bindParam(":id", $get_id);
        $select_commande->execute();

        if ($select_commande->rowCount() > 0) {
            while ($fetch_commande = $select_commande->fetch(PDO::FETCH_ASSOC)) {
                $select_product = $con->prepare("SELECT * FROM t_produit WHERE id=:id LIMIT 1");
                $select_product->bindParam(":id", $fetch_commande['pid']);
                $select_product->execute();

                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                        $sub_total = $fetch_commande['prix'];
                        $grand_total += $sub_total;
                        ?>

                        <div class="cal">
                            <p class="titre"><?= $fetch_commande['date']; ?></p>
                            <img src="admin/image/<?= $fetch_product['image']; ?>" width="180" class="images">
                            <h3 class="nom"><?= $fetch_commande['produit']; ?></h3>
                            <p class="grand-total">Total : <span><?= $grand_total; ?> Fcfa</span></p>
                        </div>
<div class="col">
    <p class="titre">Adresse de livraison</p>
    <p class="user"><b style="color:#7EBB40;">Nom:</b> <?= $fetch_commande['nom_client']; ?></p>
    <p class="numero"><b style="color:#7EBB40;">Tel:</b> 0<?= $fetch_commande['numero']; ?></p>
    <p class="addresse"><b style="color:#7EBB40;">Adresse:</b> <?= $fetch_commande['addresse']; ?></p>

    <p class="statut" style="color:
        <?php 
            if ($fetch_commande['statut_cmde'] == 'Valider' || $fetch_commande['statut_cmde'] == 'Confirmer') {
                echo 'green';
            } elseif ($fetch_commande['statut_cmde'] == 'Annuler') {
                echo 'red';
            } elseif ($fetch_commande['statut_cmde'] == 'Livré') {
                echo 'blue';
            } else {
                echo 'orange';
            }
        ?>">
        <?= $fetch_commande['statut_cmde'] ?>
    </p>

    <?php if ($fetch_commande['statut_cmde'] == 'Livré' || $fetch_commande['statut_cmde'] == 'Annuler') { ?>
        <!-- Bouton supprimer -->
        <form method="post">
            <button type="submit" name="supprimer" class="btn_supprimer" 
                onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?')">
                Supprimer la commande
            </button>
        </form>
    <?php } else { ?>
        <!-- Bouton annuler -->
        <form method="post">
            <button type="submit" name="annuler" class="btn_annule" 
                onclick="return confirm('Voulez-vous annuler cette commande ?')">
                Annuler la commande
            </button>
        </form>
    <?php } ?>
</div>



                        <?php if ($fetch_commande['statut_cmde'] == 'Confirmer') { ?>
                        <div class="tracking-container">
                            <h3>Suivi de votre commande</h3>
                            <div class="progress-bar">
                                <div class="progress" id="progress"></div>
                                <div class="circle active">1</div>
                                <div class="circle">2</div>
                                <div class="circle">3</div>
                                <div class="circle">4</div>
                            </div>
                            <p id="status-text">En cours de préparation...</p>
                            <form method="post" id="livrer-form" style="display:none;">
                                <input type="hidden" name="livrer" value="1">
                                <button type="submit" class="btn_livrer">Confirmer la réception</button>
                            </form>
                        </div>

                        <style>
                        .tracking-container { max-width:500px; margin-top:20px; }
                        .progress-bar { display:flex; justify-content:space-between; position:relative; margin:20px 0; }
                        .progress-bar::before { content:''; background-color:#ccc; position:absolute; top:50%; left:0; transform:translateY(-50%); height:4px; width:100%; z-index:-1; }
                        .progress { background-color:#4caf50; position:absolute; top:50%; left:0; transform:translateY(-50%); height:4px; width:0%; transition:width 1s ease-in-out; z-index:-1; }
                        .circle { background-color:#ccc; color:white; border-radius:50%; height:30px; width:30px; display:flex; justify-content:center; align-items:center; }
                        .circle.active { background-color:#4caf50; }
                        .btn_livrer { background-color:#4caf50; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer; }
                        </style>

                        <script>
                        let currentStep = 1;
                        const circles = document.querySelectorAll('.circle');
                        const progress = document.getElementById('progress');
                        const statusText = document.getElementById('status-text');
                        const formLivrer = document.getElementById('livrer-form');

                        const statuses = [
                            "En cours de préparation...",
                            "Prêt à être expédié",
                            "En cours de livraison...",
                            "Livré !"
                        ];

                        function updateProgress() {
                            circles.forEach((circle, idx) => {
                                if (idx < currentStep) {
                                    circle.classList.add('active');
                                } else {
                                    circle.classList.remove('active');
                                }
                            });
                            progress.style.width = ((currentStep - 1) / (circles.length - 1)) * 100 + "%";
                            statusText.textContent = statuses[currentStep - 1];
                            if (currentStep === circles.length) {
                                formLivrer.style.display = 'block';
                            }
                        }

                        updateProgress();

                        let timer = setInterval(() => {
                            if (currentStep < circles.length) {
                                currentStep++;
                                updateProgress();
                            } else {
                                clearInterval(timer);
                            }
                        }, 3000);
                        </script>
                        <?php } ?>

                        <?php
                    }
                } else {
                    echo '<p class="vide">Aucun produit trouvé !</p>';
                }
            }
        } else {
            echo '<p class="vide">Aucune commande disponible !</p>';
        }
        ?>
    </div>
    <a href="commande.php"><i class="bi bi-box-arrow-right"></i></a>
</section>

<script>
let navLinks = document.querySelector('.nav-links');
document.querySelector('#menu-icon')?.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});
</script>

<script src="box.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
