<?php
    $html = ""; $id = $_GET['id'];
    if ($stmt = $conn -> prepare("SELECT id,name,score,memory,time,rating,codename FROM `problem` WHERE id = ?")) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id']; $name = $row['name']; $codename = $row['codename']; $rate = $row['rating']; $mem = $row['memory'] . " Megabyte"; $time = $row['time'] . " Second"; $score = $row['score'];
                if ($row['time'] > 1) $time .= "s"; if ($row['memory'] > 1) $mem .= "s";
            }
            $stmt->free_result();
            $stmt->close();  
        } else {
            header("Location: ../problem/");
        }
        
    }
?>
<div class="container mb-3" style="padding-top: 88px;" id="container">
    <h2 class="font-weight-bold text-coe"><?php echo $name; ?> <span class='badge badge-coekku'><?php echo $codename; ?></span></h2>
    <hr>
    <div class="row">
        <div class="col-12 col-md-8">
            <a href="../problem/" class="float-left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
            <a target="_blank" href="../file/task/<?php echo $id; ?>/<?php echo $codename; ?>.pdf" class="float-right">เปิดในแท็บใหม่ <i
                    class="fas fa-location-arrow"></i></a>
            <iframe
                src="../static/interface/js/pdf.js/web/viewer.html?file=../../../../../file/task/<?php echo $id; ?>/<?php echo $codename; ?>.pdf"
                width="100%" height="650" class="z-depth-1 mb-3"></iframe>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="font-weight-bold text-coe">Task</h5>
                    Time Limit: <?php echo $time; ?>
                    <br>Memory Limit: <?php echo $mem; ?> ❓
                    <br>Testcase: <?php echo '<code>//TODO</code>'; ?>
                    <br>Score: <?php echo $score; ?> pts.
                    <br>Difficulty: <?php echo rating($rate); ?>
                </div>
            </div>
            <?php if (!isLogin()) { ?>
                <a href="../login/" class='btn btn-coe btn-block'>Login</a>
            <?php } else {?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="font-weight-bold text-coe">Submission</h5>
                    <div class="custom-file mb-2">
                        <input type="file" class="custom-file-input" id="submission" name="submission" accept=".c, .cpp, .java, .py">
                        <label class="custom-file-label" for="submission">Choose file</label>
                    </div>
                    <select class="form-control mb-2" id="register_prefix" name="register_prefix" required>
                        <option value="C">C</option>
                        <option value="C++">C++</option>
                        <option value="Python">Python</option>
                        <option value="Java">Java</option>
                    </select>
                    <a class="btn btn-block btn-coe">Submit</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="font-weight-bold text-coe">History</h5>
                    <div class="table-responsive" style="max-height: 180px;">
                        <table class="table table-sm w-100 d-table">
                            <thead>
                                <tr>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Result</th>
                                    <th scope="col">Language</th>
                                </tr>
                            </thead>
                            <tbody class="text-nowrap">
                            <?php
                                $html = "";
                                if ($stmt = $conn -> prepare("SELECT `lang`,`runningtime`,`uploadtime`,`result` FROM `submission` WHERE user = ? and problem = ? ORDER BY `id` DESC LIMIT 5")) {
                                    $user = $_SESSION['id'];
                                    $stmt->bind_param('ii', $user, $id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $subLang = $row['lang'];
                                            $subResult = $row['result'];
                                            $subRuntime = $row['runningtime']/1000;
                                            $subUploadtime = str_replace("-", "/", $row['uploadtime']);
                                            $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
                                                    </tr>";
                                                    $html .= "<tr>
                                                <th scope='row'><a href='#'><i class='fas fa-search'></i> $subUploadtime</a></th>
                                                <td><code>$subResult ($subRuntime" . "s)</code></td>
                                                <td>$subLang</td>
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
                </div>
            </div>
            <?php } //End of isLogin()?> 
        </div>
    </div>
</div>