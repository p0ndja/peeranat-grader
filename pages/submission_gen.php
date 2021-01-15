<?php
    include '../static/functions/connect.php';
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
                $subMemory = $row['runningtime']; //MB
                $subUploadtime = $row['uploadtime'];
                $html .= "<p>User: ".getUserdata($subUser, 'username', $conn)."<br>Problem: ".prob($subProb, $conn)."<br>Result: <code>$subResult</code><br>Language: $subLang<br>Running Time: $subRuntime ms<br>Memory: $subMemory MB<br>$subUploadtime</p>";
            }
            $stmt->free_result();
            $stmt->close();  
        }
    }
    echo $html;
?>