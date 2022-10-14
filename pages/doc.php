<?php
    $id = $_GET['id'];
<<<<<<< HEAD
    $codename = $_GET['codename'];
    //print_r("../file/judge/prob/$id/$codename*.pdf");
    $file = glob("../file/judge/prob/$id/*.pdf");
    //print_r($file);
    if ($file) {
=======
    $files = glob("../file/judge/prob/$id/*.pdf");
    $latest_ctime = 0;
    $latest_filename = null;
    foreach($files as $file)
    {
            if (is_file($file) && filectime($file) > $latest_ctime)
            {
                    $latest_ctime = filectime($file);
                    $latest_filename = $file;
            }
    }
    if ($latest_filename != null) {
>>>>>>> e157ae7e05b0be9d022abac747e99184a90e78a9
        header("Content-type: application/pdf");
        readfile($latest_filename);
    } else {
        echo "Not Found.";
    }
?>
