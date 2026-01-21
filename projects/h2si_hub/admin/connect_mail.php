<?php
// Connexion à la boîte mail via IMAP
$mailbox = '{imap.hostinger.com:993/imap/ssl}INBOX';
$username = 'formationh2si@groupeh2si.com';
$password = 'Groupe_h2si2024'; 

$inbox = imap_open($mailbox, $username, $password) or die('Impossible de se connecter à la boîte mail : ' . imap_last_error());

imap_close($inbox);
?>
