<?php
    if (isset($_FILES['submission']['name']) && $_FILES['submission']['name'] != "") {
        $name_file = $probCodename . ".zip";
        $tmp_name = $_FILES['submission']['tmp_name'];
        $locate ="/uploads/submission/$id/";
        if (!file_exists($locate)) {
            if (!mkdir($locate)) die("Can't mkdir");
        }
        if (!move_uploaded_file($tmp_name,$locate.$name_file)) die("Can't upload file");
        $probDoc = $locate.$name_file;
    }
?>