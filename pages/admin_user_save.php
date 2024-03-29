<?php
    require_once '../static/functions/connect.php';
    require_once '../static/functions/function.php';
    
    if(isset($_POST)) {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $email = $_POST['email']; 
        $role = $_POST['role'];

        $properties = array();
        if ($stmt = $conn->prepare("SELECT `properties` FROM `user` WHERE id = ? LIMIT 1;")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $properties = json_decode($row['properties'], true);
                }
            }
        }

        $properties['admin'] = (int) $role;
        $properties = json_encode($properties);
        if ($stmt = $conn->prepare("UPDATE `user` SET `displayname` = ?, `email` = ?, `properties` = ? WHERE id = ?")) {
            $stmt->bind_param('sssi', $name, $email, $properties, $id);
            if ($stmt->execute()) {
                $stmt->free_result();
                $stmt->close();  
                echo "true";
            } else {
                $stmt->free_result();
                $stmt->close();  
                echo "false | " . $conn->error;
            }
        }
    }
?>
