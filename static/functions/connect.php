<?php
    ob_start();
    session_start();
    $dbhost = "196.53.250.111";
    $dbuser = "graderga";
    $dbpass = "8db!#yYvK]8Lw6F|37wz:UwU";
    $dbdatabase = "graderga";
    $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbdatabase); 
    mysqli_set_charset($conn, 'utf8');

    if(!$conn)  die('Could not connect: ' . mysqli_error($conn));
    
    @ini_set('upload_max_size','64M');
    @ini_set('post_max_size','64M');
    @ini_set('max_execution_time','300');
    
    date_default_timezone_set('Asia/Bangkok');

?>
