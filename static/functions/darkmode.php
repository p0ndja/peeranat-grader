<?php require_once 'connect.php'; ?>
<?php require_once 'function.php'; ?>
<?php 
    if (isDarkmode()) {
        $_SESSION['dark_mode'] = false;
    } else {
        $_SESSION['dark_mode'] = true;
        $_SESSION['swal_warning'] = "แจ้งเตือน";
        $_SESSION['swal_warning_msg'] = "กำลังอยู่ในช่วงพัฒนา หากพบสิ่งผิดปกติโปรดแจ้ง";
    }
    back();
?>