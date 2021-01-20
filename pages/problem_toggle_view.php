<?php
    include '../static/functions/connect.php';
    include '../static/functions/function.php';
    $problem_id = "";
    if (isLogin() && isAdmin($_SESSION['id'], $conn) && isset($_GET['problem_id'])) {
        $problem_id = (int) $_GET['problem_id'];
        $problem_hide = (int) $_GET['hide'] ? 0 : 1;
        if ($stmt = $conn -> prepare("UPDATE `problem` SET hidden=? WHERE id=?")) {
            $stmt->bind_param('ii', $problem_hide,$problem_id);
            if (!$stmt->execute()) {
                $_SESSION['swal_error'] = "พบข้อผิดพลาด";
                $_SESSION['swal_error_msg'] = "ไม่สามารถ Query Database ได้";
                echo $conn->error;
            } else {
                $_SESSION['swal_success'] = "สำเร็จ!";
                if ($problem_hide)
                    $_SESSION['swal_success_msg'] = "ปิดการมองเห็นโจทย์ข้อ #$problem_id แล้ว";
                else
                    $_SESSION['swal_success_msg'] = "เปิดการมองเห็นโจทย์ข้อ #$problem_id แล้ว";
                echo "Toggled";
            }
        } else {
            echo "Can't establish database";
        }
    }
    header("Location: ../problem/$problem_id");
?>