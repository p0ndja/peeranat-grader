<?php
    include '../static/functions/connect.php';
    $subID = (int) $_GET['target'];
    $r = "FILE NOT FOUND";
    if ($stmt = $conn -> prepare("SELECT `script` FROM `submission` WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $subID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                if (file_exists($row['script'])) {
                    $r = file_get_contents($row['script']);
                }
            }
        }
    }
    echo $r;
?>