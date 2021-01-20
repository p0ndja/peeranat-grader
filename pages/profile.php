<?php

    if (isset($_GET['id'])) {
        $profile_id = (int) $_GET['id'];
    } else if (isLogin()) {
        $profile_id = (int) $_SESSION['id'];
    } else {
        header("Location: ../home/");
    }


    
?>