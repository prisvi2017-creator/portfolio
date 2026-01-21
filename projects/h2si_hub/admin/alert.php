<?php
if (isset($success_msg) && is_array($success_msg)) {
    foreach ($success_msg as $msg) {
        echo '<script>swal("Succès", "'.$msg.'", "success");</script>';
    }
}

if (isset($warning_msg) && is_array($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo '<script>swal("Attention", "'.$msg.'", "warning");</script>';
    }
}

if (isset($error_msg) && is_array($error_msg)) {
    foreach ($error_msg as $msg) {
        echo '<script>swal("Erreur", "'.$msg.'", "error");</script>';
    }
}
?>