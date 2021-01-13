<?php declare(strict_types=1);

    function latestIncrement($dbdatabase, $db, $conn) {
        return mysqli_fetch_array(mysqli_query($conn,"SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbdatabase' AND TABLE_NAME = '$db'"), MYSQLI_ASSOC)["AUTO_INCREMENT"];
    }
    function isLogin() {
        if (isset($_SESSION['id'])) return true;
        return false;
    }

    function isAdmin($id, $conn) {
        if (getUserdata($id, 'isAdmin', $conn)) return true;
        return false;
    }

    function getAnySQL($sql, $val, $key, $key_val, $conn) {
        if ($sql == null || $val == null || $key == null || $key_val == null || $conn == null) return false;
        return mysqli_fetch_array(mysqli_query($conn, "SELECT `$val` from `$sql` WHERE $key = '$key_val'"), MYSQLI_ASSOC)[$val];
    }

    function saveAnySQL($sql, $col, $val, $key, $key_val, $conn) {
        if ($sql == null || $key == null || $key_val == null || $conn == null) return false;
        return mysqli_query($conn, "UPDATE `$sql` SET `$col` = $val WHERE `$key` = '$key_val'");
    }

    function getUserdata($id, $data, $conn) {
        return getAnySQL('user', $data, 'id', $id, $conn);
    }
    //getUserdata('604019', 'username', $conn);

    function saveUserdata($id, $data, $val, $conn) {
        if (saveAnySQL('user', $data, $val, 'id', $id, $conn)) return true;
        return false;
    }
    //saveUserdata('604019', 'username', 'PondJaTH', $conn);

    function isValidUserID($id, $conn) {
        $query = "SELECT * FROM `user` WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) return true;
        return false;
    }

    function rating($rate) {
        switch($rate) {
            case 0:
                return "<text class='text-secondary'>Peaceful</text>";
            case 1:
                return "<text class='text-success'>Easy</text>";
            case 2:
                return "<text class='text-warning'>Normal</text>";
            case 3:
                return "<text class='text-danger'>Hard</text>";
            default:
                return "<text class='text-muted'>Unrated</text>";
        }
    }

    
?>
<?php

    function getDisplayName($id, $conn) {
        return getUserdata($id, 'prefix', $conn) . getUserdata($id, 'firstname', $conn) . ' ' . getUserdata($id, 'lastname', $conn);
    }

    function getClientIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }

    function path_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y/m/d', time());
    }

    function unformat_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('YmdHis', time());
    }

    function curDate() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d', time());
    }

    function curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('H:i:s', time());
    }

    function curFullTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d H:i:s', time());
    }

    function sendFileToIMGHost($file) {
        $data = array(
            'img' => new CURLFile($file['tmp_name'],$file['type'], $file['name']),
        ); 
        
        //**Note :CURLFile class will work if you have PHP version >= 5**
        
         $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://img.p0nd.ga/upload.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $msg = FALSE;
        } else {
            $msg = $response;
        }
        
        curl_close($ch);
        return $msg;
    }


    function generateOpenGraphMeta($conn) {
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        if (strpos($current_url, "/event/")) {
            //Mean you're currently browsing in post page
            if (isset($_GET['id']) && isValidEventID($_GET['id'], $conn)) {
                $postID = $_GET['id'];
                $topic = getEventdata($postID, 'name', $conn);
                $img = getEventdata($postID, 'thumbnail', $conn);
                
                if ($img == null) {
                    list($ogwidth, $ogheight, $ogtype, $ogattr) = getimagesize("../static/elements/logo/logo.jpg");
                    $img = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/static/elements/logo/logo.jpg";
                } else {
                    list($ogwidth, $ogheight, $ogtype, $ogattr) = getimagesize($img);
                    $img = str_replace("..", (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'], $img);
                }
                
                ?>
        <meta property="og:image" content="<?php echo $img; ?>" />
        <meta property="og:image:width" content="<?php echo $ogwidth; ?>" />
        <meta property="og:image:height" content="<?php echo $ogheight; ?>" />
        <meta property="og:title" content="<?php echo $topic;?>" />
        <title><?php echo $topic;?> | Grader.GA</title>
        <meta property="og:description" content="Grader.GA" />
            <?php }
        } else { ?>
        <meta property="og:image" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']; ?>/static/elements/logo/logo.jpg" />
        <?php list($ogwidth, $ogheight, $ogtype, $ogattr) = getimagesize("../static/elements/logo/logo.jpg"); ?>
        <meta property="og:image:width" content="<?php echo $ogwidth; ?>" />
        <meta property="og:image:height" content="<?php echo $ogheight; ?>" />
        <meta property="og:title" content="Grader.GA" />
        <title>Grader.GA</title>
        <meta property="og:description" content="{DESCRIPTION}" />
        <?php } ?>
        <meta name="twitter:card" content="summary"></meta>
        <link rel="image_src" href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']; ?>/static/elements/logo/logo.jpg" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo $current_url; ?>" />
    <?php }

    function generateRandom($length = 16) {
        $characters = md5(time());
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
?>

<?php
    function needLogin() {
    if (!isLogin()) {?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You need to logged-in!",
        icon: "error"
    }).then(function () {
        <?php $_SESSION['error'] = "กรุณาเข้าสู่ระบบก่อนดำเนินการต่อ"; ?>
        window.location = "../login/";
    });
</script>
<?php die(); }} ?>

<?php
    function needAdmin($conn) {
    if (!isLogin()) { needLogin(); die(); return false; }
    if (!isAdmin($_SESSION['id'], $conn)) { ?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You don't have enough permission!",
        icon: "warning"
    });
</script>
<?php die(); return false;}
        return true;
    }
?>
<?php function back() {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        home();
    }
    die();
    } ?>
<?php function home() {
    header("Location: ../home/");
} ?>
<?php function logout() { ?>
    <script>
        swal({
            title: "ออกจากระบบ ?",
            text: "คุณต้องการออกจากระบบหรือไม่?",
            icon: "warning",
            buttons: true,
            dangerMode: true}).then((willDelete) => {
                if (willDelete) {
                    window.location = "../logout/";
                }
            });
</script>
<?php } ?>

<?php function deletePost($id) { ?>
    <script>
        swal({
            title: "ลบข่าวหรือไม่ ?",
            text: "หลังจากที่ลบแล้ว ข่าวนี้จะไม่สามารถกู้คืนได้!",
            icon: "warning",
            buttons: true,
            dangerMode: true}).then((willDelete) => {
                if (willDelete) {
                    window.location = "../post/delete.php?id=<?php echo $id; ?>";
                }
            });
    </script>
<?php } ?>
<?php function warningSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "warning"
    });
    </script>
<?php } ?>
<?php function errorSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "error"
    });
    </script>
<?php } ?>
<?php function successSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "success"
    });
    </script>
<?php } ?>
<?php function debug($message) { echo $message; } ?>

<?php
    function startsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
    function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
?>
