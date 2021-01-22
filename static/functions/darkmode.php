<?php require_once 'connect.php'; ?>
<?php require_once 'function.php'; ?>
<?php 
    if (isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] == true) $_SESSION['dark_mode'] = false;
    else $_SESSION['dark_mode'] = true;
    back();
?>