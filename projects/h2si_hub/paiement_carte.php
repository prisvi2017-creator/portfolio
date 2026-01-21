<?php
session_start();

if (!isset($_SESSION['paiement'])) {
    // Rediriger si la session de paiement est absente
    header('Location: verifier.php');
    exit();
}

$paiement = $_SESSION['paiement'];

$grand_total = $paiement['grand_total'];
$nom_client = $paiement['nom_client'];
$prenom_client = $paiement['prenom_client'];
$mail_client = $paiement['mail_client'];
$numero = $paiement['numero'];
$addresse = $paiement['addresse'];
$produit = $paiement['produit'];
$pid = $paiement['pid'];
?>


<!DOCTYPE html>
<html>
<head>
    <title>Paiement par carte</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="paiement-form">
        <h2> paiement par carte</h2>
        <form action="paiement_valide.php" method="post">
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="nom_client" value="<?= $nom_client ?>">
            <input type="hidden" name="prenom_client" value="<?= $prenom_client ?>">
            <input type="hidden" name="mail_client" value="<?= $mail_client ?>">
            <input type="hidden" name="numero" value="<?= $numero ?>">
            <input type="hidden" name="addresse" value="<?= $addresse ?>">
            <input type="hidden" name="produit" value="<?= $produit ?>">
            <input type="hidden" name="pid" value="<?= $pid ?>">
            <input type="hidden" name="methode" value="par carte">

            <label>Numéro de carte</label>
            <input type="text" placeholder="0000 0000 0000 0000" required><br>

            <label>Date d'expiration</label>
            <input type="text" placeholder="MM/YY" required><br>

            <label>Code CVV</label>
            <input type="text" placeholder="123" required><br>

            <button type="submit" name="payer">Valider le paiement</button>
        </form>
    </div>
</body>
</html>
