<?php
    require_once '../connect.php';
    require_once '../function.php';

    $key = $_GET['key'];
    $email = $_GET['email'];

    global $conn;
    if ($stmt = $conn->prepare("SELECT `id`,`username`,`password` FROM `user` WHERE json_extract(`tempAuthKey`,'$.key') = ? AND email = ? LIMIT 1")) {
        $stmt->bind_param('ss', $key, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                if (useAuthKey($key, 30*60, $row['id'])) {
                    header("Location: ../auth/login.php?user=".$row['username']."&pass=".$row['password']."&method=reset");
                    die();
                }
            }
        }
        $_SESSION['swal_error'] = "ไม่สามารถรีเซ็ตรหัสผ่าน";
        $_SESSION['swal_error_msg'] = ErrorMessage::DATABASE_CONFLICT;
        header("Location: ../../../home/");
        die();
    }
    header("Location: ../../../home/");
    
?>