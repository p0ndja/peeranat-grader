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
    <?php if (isLogin() && isAdmin($_SESSION['id'], $conn)) { ?>
    <div id="adminZone" class="border border-danger text-coe">&nbsp;&nbsp;สำหรับ Admin:
        <a href="../file/judge/prob/<?php echo $id; ?>/" target="_blank" class="btn btn-sm btn-success">View Testcase</a>
        <a href="../problem/edit-<?php echo $id; ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="#notready" class="btn btn-sm btn-warning">Rejudge</a>
        <a href="#notready" class="btn btn-sm btn-danger">Delete</a>
    </div>
    <?php } ?>
    <hr>
    <div class="row">
        <div class="col-12 col-md-8">
            <a href="../problem/" class="float-left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
            <a target="_blank" href="../doc/<?php echo $id; ?>-<?php echo $codename; ?>" class="float-right">เปิดในแท็บใหม่ <i
                    class="fas fa-location-arrow"></i></a>
            <iframe
                src="../static/interface/js/pdf.js/web/viewer.html?file=../../../../../doc/<?php echo $id; ?>-<?php echo $codename; ?>"
                width="100%" height="650" class="z-depth-1 mb-3"></iframe>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card-text">
                        <h5 class="font-weight-bold text-coe">Task</h5>
                        Time Limit: <?php echo $time; ?>
                        <br>Memory Limit: <?php echo $mem; ?> ❓
                        <br>Score: <?php echo $score; ?> pts.
                        <br>Difficulty: <?php echo rating($rate); ?>
                    </div>
                </div>
            </div>
            <?php if (!isLogin()) { ?>
                <a href="../login/" class='btn btn-coe btn-block'>Login</a>
            <?php } else {?>
            <div class="card mb-3">
                <div class="card-body">
                    <form method="post" action="../pages/problem_user_submit.php" enctype="multipart/form-data">
                        <h5 class="font-weight-bold text-coe">Submission</h5>
                        <div class="custom-file mb-2">
                            <input type="hidden" name="probID" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="probCodename" value="<?php echo $codename; ?>"/>
                            <input type="file" class="custom-file-input" id="submission" name="submission" accept=".c, .cpp, .java, .py" required>
                            <label class="custom-file-label" for="submission">Choose file</label>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <select class="form-control mb-2" id="lang" name="lang" required>
                                    <option value="C">C</option>
                                    <option value="Cpp">C++</option>
                                    <option value="Python">Python</option>
                                    <option value="Java" selected>Java</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <button type="submit" value="prob" name="submit" class="btn btn-block btn-coe btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="font-weight-bold text-coe">History</h5>
                    <div class="table-responsive" style="max-height: 248px;">
                        <table class="table table-sm table-hover w-100 d-table">
                            <thead>
                                <tr>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Result</th>
                                </tr>
                            </thead>
                            <tbody class="text-nowrap">
                            <?php
                                $html = "";
                                if ($stmt = $conn -> prepare("SELECT `id`,`runningtime`,`uploadtime`,`result` FROM `submission` WHERE user = ? and problem = ? ORDER BY `id` DESC LIMIT 5")) {
                                    $user = $_SESSION['id'];
                                    $stmt->bind_param('ii', $user, $id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $subID = $row['id'];
                                            $subResult = $row['result'] != 'W' ? $row['result']: 'รอผลตรวจ...';
                                            $subRuntime = $row['runningtime']/1000;
                                            $subUploadtime = str_replace("-", "/", $row['uploadtime']); ?>
                                            <tr class='launchModal' onclick='javascript:;' data-toggle='modal' data-target='#modalPopup' data-title='Submission #<?php echo $subID; ?>' data-id='<?php echo $subID; ?>'>
                                                <th scope='row'><?php echo $subUploadtime; ?></th>
                                                <td <?php if ($row['result'] == 'W') echo "data-wait=true data-sub-id=" . $subID; ?>><code><?php echo "$subResult ($subRuntime" . "s)"; ?></code></td>
                                            </tr>
                                        <?php }
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