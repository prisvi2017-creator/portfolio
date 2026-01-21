<?php
include("sessioneq.php");

// Récupère toutes les notifications non lues
$select_notif = $con->prepare("SELECT * FROM t_notifications WHERE id_client = :id_client AND est_lue = 0 ORDER BY date_envoi DESC");
$select_notif->bindParam(":id_client", $id_client);
$select_notif->execute();
$notifications = $select_notif->fetchAll(PDO::FETCH_ASSOC);

// Renvoie le JSON
header('Content-Type: application/json');
echo json_encode($notifications);
?>
