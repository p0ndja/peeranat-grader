<?php
    require_once '../connect.php';
    $html = "";
    if ($stmt = $conn -> prepare("SELECT id,name,rating,codename,hidden FROM `problem` ORDER BY id")) {
        //$stmt->bind_param('ii', $page, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id']; $name = $row['name']; $codename = $row['codename']; $rate = $row['rating']; $hide = $row['hidden'];
                if (!$hide || (isLogin() && isAdmin($_SESSION['id'], $conn))) {
                    $method = isLogin() ? isPassed($_SESSION['id'], $id, $conn) : "";
                    if ($method == 1) $method = "class='table-success'";
                    else if ($method == -1) $method = "class='table-warning'";
                    else $method = "";
                    $html .= "<tr onclick='window.location=\"../problem/$id\"' ".$method.">
                        <th scope='row'>$id</th>
                        <td>$name <span class='badge badge-coekku'>$codename</span></td>
                        <td>".rating($rate)."</td>
                    </tr>";
                }
            }
            $stmt->free_result();
            $stmt->close();  
        }
        echo $html;
    }
?>