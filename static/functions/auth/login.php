<?php
    require '../connect.php';

    //กรณี Login
if (isset($_POST['login_submit'])) {
    $user = $_POST['login_username'];
    $pass = $_POST['login_password']; $md5_pass = md5($pass);

    //ดึงข้อมูลมาเช็คว่า $User ที่ตั้งรหัสผ่านเป็น $Pass มีในระบบรึเปล่า
    $query = "SELECT * FROM `user` WHERE (username = '$user' OR id = '$user' OR email = '$user') AND (password = '$md5_pass')";
    $result = mysqli_query($conn, $query);
    if (!$result) die('Could not get data: ' . mysqli_error($conn));

    //ถ้าไม่เจอ User นี้ จะ return เป็น 0
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง";
        header("Location: ../../../login/");
    } else {
        //ปกติค่านี้ ถ้าเจอในฐานข้อมูลจะ return ออกมา > 0
        //ตั้งค่าข้อมูลต่าง ๆ ของ User ใส่ SESSION
        $_SESSION['id'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['id'];
        $_SESSION['real_id'] = $_SESSION['id'];
        $_SESSION['username'] = getUserdata($_SESSION['id'], 'username', $conn);
        $_SESSION['name'] = getUserdata($_SESSION['id'], 'firstname', $conn) . ' ' . getUserdata($_SESSION['id'], 'lastname', $conn);
        $_SESSION['shortname'] = getUserdata($_SESSION['id'], 'firstname', $conn);

        $_SESSION['swal_success'] = "เข้าสู่ระบบสำเร็จ";
        $_SESSION['swal_success_msg'] = "ยินดีต้อนรับ! " . $_SESSION['name'];

        if (isset($_POST['method'])) {
            if ($_POST['method'] == "loginPage") header("Location: ../../../home/");
            else if ($_POST['method'] == "loginNav") back();
            else header("Location: ../../../home/");
        } else {
            back();
        }
    }
}

    //กรณี Register
if (isset($_POST['register_submit'])) {
    $user = $_POST['register_username'];
    $pass = md5($_POST['register_password']);
    $id = $_POST['register_id'];
    $firstname = $_POST['register_firstname'];
    $lastname = $_POST['register_lastname'];
    $email = $_POST['register_email'];
    $prefix = $_POST['register_prefix'];
    $grade = $_POST['register_grade'];
    $class = $_POST['register_class'];

    //ลองเอาค่าต่าง ๆ ไปดูว่ามีผู้ใช้นี้อยู่ในระบบแล้วรึยัง
    $query1 = "SELECT * FROM `user` WHERE username = '$user'";
    $query2 = "SELECT * FROM `user` WHERE id = $id";
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    if (! $result1) {
        die('Could not get data: ' . mysqli_error($conn));
    }

    //กรณีมีข้อมูลอยู่แล้ว จะ return ค่าเป็น 1
    if (mysqli_num_rows($result1) == 1) {
        $_SESSION['error'] = "มีชื่อผู้ใช้นี้อยู่แล้ว";
        header("Location: ../../../register/");
    } else if (mysqli_num_rows($result2) == 1) {
        $_SESSION['error'] = "รหัสนักเรียนนี้เคยใช้ในการสมัครเข้าใช้งานไปแล้ว";
        header("Location: ../../../register/");
    } else {
        
        $query_final = "INSERT INTO `user` (id, username, password, prefix, firstname, lastname, grade, class, email) VALUES ($id, '$user', '$pass', '$prefix', '$firstname', '$lastname', $grade, $class, '$email')";
        $result_final = mysqli_query($conn, $query_final);

        //แสดงค่ากลับหาผู้ใช้
        if (! $result_final) {
            die('Could not register ' . mysqli_error($conn));
        } else {
            $_SESSION['error'] = null;
            $_SESSION['swal_success'] = "สมัครผู้ใช้งานสำเร็จ";
            $_SESSION['swal_success_msg'] = "อย่าลืมเข้าไปยืนยันตัวตนทางอีเมลนะครับ";
            $_SESSION['username'] = $user;
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $_POST['register_firstname'] . ' ' . $_POST['register_lastname'];
            header("Location: ../../../home/");
            //header("Location: ../verify/mail.php?key=" . $pass . "&email=" . $email . "&name=" . $_SESSION['name'] . "&method=reg");
        }
    }
}

if (isset($_GET['user']) && isset($_GET['pass'])) {
    $user = $_GET['user'];
    $pass = $_GET['pass']; $md5_pass = md5($pass);

    //ดึงข้อมูลมาเช็คว่า $User ที่ตั้งรหัสผ่านเป็น $Pass มีในระบบรึเปล่า
    $query = "SELECT * FROM `user` WHERE (username = '$user' OR id = '$user' OR email = '$user') AND (password = '$md5_pass' OR password = '$pass')";
    $result = mysqli_query($conn, $query);
    if (!$result) die('Could not get data: ' . mysqli_error($conn));

    //ถ้าไม่เจอ User นี้ จะ return เป็น 0
    if (mysqli_num_rows($result) == 0) {
        echo "WRONG PASSWORD";
        return false;
    } else {
        $_SESSION['id'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['id'];
        $_SESSION['real_id'] = $_SESSION['id'];
        $_SESSION['username'] = getUserdata($_SESSION['id'], 'username', $conn);
        $_SESSION['name'] = getUserdata($_SESSION['id'], 'firstname', $conn) . ' ' . getUserdata($_SESSION['id'], 'lastname', $conn);
        $_SESSION['shortname'] = getUserdata($_SESSION['id'], 'firstname', $conn);
        
        if (isset($_GET['method'])) {
            if ($_GET['method'] == "normal") {
                $_SESSION['swal_success'] = "เข้าสู่ระบบสำเร็จ";
                if (isVerify($_SESSION['id'], $conn)) $_SESSION['swal_success_msg'] = "ยินดีต้อนรับ! " . $_SESSION['name'];
                else $_SESSION['swal_success_msg'] = "อย่าลืมเข้าไปยืนยันตัวตนทางอีเมลนะครับ";
                header("Location: ../../home");
            } else if ($_GET['method'] == "email") {
                $_SESSION['swal_success'] = "ยืนยันอีเมลสำเร็จ";
                $_SESSION['swal_success_msg'] = "ยินดีต้อนรับ! " . $_SESSION['name'];
                header("Location: ../../home");
            }
        } else {
            echo "ACCEPT";
        }
    }
}
?>