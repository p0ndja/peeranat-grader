<?php
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    require_once '../connect.php';
    require_once '../function.php';

    $id = isset($_GET['id']) ? "WHERE id = " . (int) $_GET['id'] : "";
    $arr = array();
    if ($stmt = $conn -> prepare("SELECT * FROM `problem` $id ORDER BY id")) {
        //$stmt->bind_param('ii', $page, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $id = $row['id']; $name = $row['name']; $codename = $row['codename']; $score = $row['score']; $rate = $row['rating']; $hide = $row['hidden']; $writer = $row['writer']; $memory = $row['memory']; $time = $row['time'];
                $e_arr = array(
                    "id" => $id,
                    "name" => $name,
                    "codename" => $codename,
                    "author" => $writer,
                    "score" => $score,
                    "memory" => $memory,
                    "time" => $time,
                    "rating" => array(
                        "value" => $rate,
                        "display" => rating($rate)
                    ),
                    "hide" => $hide,
                    "doc" => "../file/judge/prob/$id/$codename.pdf"
                );

                array_push($arr, $e_arr);
            }
            $stmt->free_result();
            $stmt->close();  
        }
    }
    echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>