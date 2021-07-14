<?php $admin = isAdmin(); ?>
<div class="container mb-3" style="padding-top: 88px;" id="container">
    <h1 class="display-4 font-weight-bold text-center text-coekku">Problem</h1>
    <?php if ($admin) { ?><a href="../problem/create" class="btn btn-coekku btn-sm">+ Add Problem</a><?php } ?>
    <div class="table-responsive">
        <table class="table table-hover w-100 d-block d-md-table" id="problemTable">
            <thead>
                <tr class="text-nowrap">
                    <th scope="col" class="font-weight-bold text-coekku text-right">ID</th>
                    <th scope="col" class="font-weight-bold text-coekku">Task</th>
                    <th scope="col" class="font-weight-bold text-coekku">Rate</th>
                    <th scope="col" class="font-weight-bold text-coekku">Result</th>
                </tr>
            </thead>
            <tbody class="text-nowrap">
                <?php
                $userID = isLogin() ? $_SESSION['user']->getID() : 0;
                if ($stmt = $conn -> prepare("SELECT `problem`.`id` as probID, `problem`.`name` as probName, `problem`.`properties` as probProp, `problem`.`codename` as probCode, (select `submission`.`result` as `subResult` FROM `submission` WHERE `submission`.`user` = ? AND `submission`.`problem` = `problem`.`id` ORDER BY `submission`.`id` DESC LIMIT 1) as subResult FROM `problem`")) {
                    $stmt->bind_param('i', $userID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['probID']; $name = $row['probName']; $codename = $row['probCode'];
                            
                            $prop = json_decode($row['probProp'],true);
                            $hide = array_key_exists("hide", $prop) ? $prop["hide"] : false;
                            $rate = array_key_exists("rating", $prop) ? $prop["rating"] : 0;

                            $hideMessage = ($hide) ? "<span class='badge badge-danger'>ซ่อน</span>" : "";
                            if (!$hide || $admin) {
                                $lastResult = $row['subResult'];
                                $color;
                                if (empty($lastResult)) $color = "";
                                else if (str_contains($lastResult, "-") || str_contains($lastResult, "X") || str_contains($lastResult, "T") || str_contains($lastResult, "Compile Error"))
                                    $color = "yellow lighten-4";
                                else $color = "green accent-1";
                                
                                echo "<tr style='cursor: pointer;' class='$color' onmousedown='window.open(\"../problem/$id\")'>
                                    <th class='text-right' scope='row'>$id</th>
                                    <td>$name <span class='badge badge-coekku'>$codename</span> $hideMessage</td>
                                    <td data-order='".$rate."'><b>".rating($rate)."</b></td>
                                    <td><code>$lastResult</code></td>
                                </tr>";
                            }
                        }
                        $stmt->free_result();
                        $stmt->close();  
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#problemTable').DataTable({
                "lengthMenu": [ [15, 50, 100, -1], [15, 50, 100, "All"] ],
                'columnDefs': [ {
                    'targets': [1,3], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }]
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
</div>