<?php
    include '../static/functions/connect.php';
    include '../static/functions/function.php';
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
    $html = "";
    if ($stmt = $conn -> prepare("SELECT * FROM `submission` WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $subID = $row['id'];
                $subUser = $row['user'];
                $subProb = $row['problem'];
                $subLang = $row['lang'];
                $subResult = $row['result'];
                $subRuntime = $row['runningtime']; //ms
                $subMemory = $row['memory'] ? $row['memory'] . " MB": "UNSUPPORTED"; //MB
                $subUploadtime = $row['uploadtime'];
                $html .= "<p>User: <code>".getUserdata($subUser, 'username', $conn)."</code><br>Problem: ".prob($subProb, $conn)."<br>Result: <code>$subResult</code><br>Language: <code>$subLang</code><br>Running Time: <code>$subRuntime ms</code><br>Memory: <code>$subMemory</code><br>Submit Time: $subUploadtime</p>";
            }
            $stmt->free_result();
            $stmt->close();  
        }
    }
    echo $html;
?>