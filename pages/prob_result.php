<?php
require_once '../static/functions/connect.php';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
$needTime = isset($_GET['time']) ? true : false;
if ($stmt = $conn -> prepare("SELECT `result`,`runningtime` FROM `submission` WHERE id = ? LIMIT 1")) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subResult = $row['result'] != 'W' ? $row['result']: 'รอผลตรวจ...';
            $subRuntime = $row['runningtime']/1000; ?>
<code><?php echo $subResult;?><?php if ($needTime) echo ' (' . $subRuntime . 's)'; ?></code>
        <?php }
        $stmt->free_result();
        $stmt->close();  
    }
}
?>