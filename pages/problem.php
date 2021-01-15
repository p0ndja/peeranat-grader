<div class="container mb-3" style="padding-top: 88px;" id="container">
    <h1 class="display-4 font-weight-bold text-center text-coe">Problem</h1>
    <?php if (isLogin() && isAdmin($_SESSION['id'], $conn)) { ?><a href="../problem/create" class="btn btn-coe btn-sm">+ Add Problem</a><?php } ?>
    <table class="table table-responsive table-hover w-100 d-block d-md-table">
        <thead>
            <tr class="text-nowrap">
                <th scope="col" class="font-weight-bold text-coe">Problem ID</th>
                <th scope="col" class="font-weight-bold text-coe">Task</th>
                <th scope="col" class="font-weight-bold text-coe">Rate</th>
                <th scope="col" class="font-weight-bold text-coe">Time Limit</th>
                <th scope="col" class="font-weight-bold text-coe">Memory</th>
            </tr>
        </thead>
        <tbody class="text-nowrap">
            <?php
            $html = "";
            if ($stmt = $conn -> prepare("SELECT id,name,memory,time,rating,codename FROM `problem` ORDER BY id")) {
                //$stmt->bind_param('ii', $page, $limit);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id']; $name = $row['name']; $codename = $row['codename']; $rate = $row['rating']; $mem = $row['memory'] . " Megabyte"; $time = $row['time'] . " Second";
                        if ($row['time'] > 1) $time .= "s"; if ($row['memory'] > 1) $mem .= "s";
                        $method = isLogin() ? isPassed($_SESSION['id'], $id, $conn) : "";
                        if ($method == 1) $method = "class='table-success'";
                        else if ($method == -1) $method = "class='table-warning'";
                        else $method = "";
                        $html .= "<tr onclick='window.location=\"../problem/$id\"' ".$method.">
                            <th scope='row'>$id</th>
                            <td>$name <span class='badge badge-coekku'>$codename</span></td>
                            <td>".rating($rate)."</td>
                            <td>$time</td>
                            <td>$mem</td>
                        </tr>";
                    }
                    $stmt->free_result();
                    $stmt->close();  
                }
                echo $html;
            }
            ?>
        </tbody>
    </table>
</div>