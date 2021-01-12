<?php
    include '../static/functions/connect.php';
    $id = "";
    if (isLogin() && isAdmin($_SESSION['id'], $conn)) {
        if (isset($_POST['problem'])) {
            $isCreate = $_POST['problem'] == "create" ? 1 : 0; //Create(true) or Edit(false)
            $probName = $_POST['name'];
            $probCodename = $_POST['codename'];
            $probScore = $_POST['score'];
            $probRate = $_POST['rating'];
            $probTime = $_POST['time'];
            $probMemory = $_POST['memory'];
            $probScript = $_POST['script'];

            $id = $isCreate ? latestIncrement($dbdatabase, 'problem', $conn) : $_GET['id'];

            $probDoc = $_POST['probDoc'];
            if (isset($_FILES['pdfPreview']['name']) && $_FILES['pdfPreview']['name'] != "") {
                $name_file = $probCodename . ".pdf";
                $tmp_name = $_FILES['pdfPreview']['tmp_name'];
                $locate ="../file/task/$id/";
                if (!file_exists($locate)) {
                    if (!mkdir($locate)) die("Can't mkdir");
                }
                if (!move_uploaded_file($tmp_name,$locate.$name_file)) die("Can't upload file");
                $probDoc = $locate.$name_file;
            }

            $probTestcase = $_POST['testcaseFile'];
            if (isset($_FILES['testcase']['name']) && $_FILES['testcase']['name'] != "") {
                $name_file = $probCodename . ".zip";
                $tmp_name = $_FILES['testcase']['tmp_name'];
                $locate ="../file/testcase/$id/";
                if (!file_exists($locate)) {
                    if (!mkdir($locate)) die("Can't mkdir");
                }
                if (!move_uploaded_file($tmp_name,$locate.$name_file)) die("Can't upload file");
                $probDoc = $locate.$name_file;
            }

            //INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE name="A", age=19
            if ($stmt = $conn -> prepare("INSERT INTO `problem` (id, name, codename, score, memory, time, rating, script) VALUES (?,?,?,?,?,?,?,?)")) {
                $stmt->bind_param('issiiiis', $id, $probName, $probCodename, $probScore, $probMemory, $probTime, $probRate, $probScript);
                if (!$stmt->execute()) {
                    $_SESSION['swal_error'] = "พบข้อผิดพลาด";
                    $_SESSION['swal_error_msg'] = "ไม่สามารถ Query Database ได้";
                } else {
                    $_SESSION['swal_success'] = "สำเร็จ!";
                    $_SESSION['swal_success_msg'] = "เพิ่มโจทย์ $probCodename แล้ว!";
                }
            }
        }
    }
    header("Location: ../problem/$id");
?>