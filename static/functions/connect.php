<?php
    ob_start();
    session_start();
    $dbhost = "pondhub.ga";
    $dbuser = "pondjaco_graderga";
    $dbpass = "Apo4J8fKBv";
    $dbdatabase = "pondjaco_graderga";
    $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbdatabase); 
    mysqli_set_charset($conn, 'utf8');

    if(!$conn)  die('Could not connect: ' . mysqli_error($conn));
    
    require 'function.php';

    if (isLogin() && !isValidUserID($_SESSION['id'], $conn)) {
        session_destroy();
        header("Location: ../home/");
    }

    @ini_set('upload_max_size','64M');
    @ini_set('post_max_size','64M');
    @ini_set('max_execution_time','300');
    
    date_default_timezone_set('Asia/Bangkok');

?>
