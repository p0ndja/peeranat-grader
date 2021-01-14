<div class="container mb-3" style="padding-top: 88px;" id="container">
    <h1 class="display-4 font-weight-bold text-center text-coe">Submission</h1>
    <?php if (isLogin()) { ?>
    <div class="switch switch-danger mb-1 ">
        <label>
            <input type="checkbox" name="onlyme" id="onlyme">
            <span class="lever"></span>Only My Submission
        </label>
    </div>
    <script>
        $("#onlyme").change(function() {
            if ($(this).is(':checked'))
                $('tr:not(.me)').hide();
            else
                $('tr:not(.me)').show();
        });
    </script>
    <?php } ?>
    <table class="table table-responsive w-100 d-block d-md-table">
        <thead>
            <tr class="text-nowrap me">
                <th scope="col" class="font-weight-bold text-coe">ID</th>
                <th scope="col" class="font-weight-bold text-coe">Timestamp</th>
                <th scope="col" class="font-weight-bold text-coe">User</th>
                <th scope="col" class="font-weight-bold text-coe">Problem ID</th>
                <th scope="col" class="font-weight-bold text-coe">Language</th>
                <th scope="col" class="font-weight-bold text-coe">Result</th>
                <?php if (isLogin() && isAdmin($_SESSION['id'], $conn)) { ?><th scope="col" class="font-weight-bold text-coe">#</th><?php } ?>
            </tr>
        </thead>
        <tbody class="text-nowrap">
            <?php
            $html = "";
            if ($stmt = $conn -> prepare("SELECT * FROM `submission` ORDER BY `id` DESC")) {
                //$stmt->bind_param('ii', $page, $limit);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $me = (isLogin() && $_SESSION['id'] == $row['user']) ? "class='me'" : "";
                        $subID = $row['id'];
                        $subUser = $row['user'];
                        $subProb = $row['problem'];
                        $subLang = $row['lang'];
                        $subResult = $row['result'];
                        $subRuntime = $row['runningtime']/1000;
                        $subUploadtime = $row['uploadtime'];
                        $html .= "<tr $me>
                            <th scope='row'>$subID</th>
                            <td>$subUploadtime</td>
                            <td>".getUserdata($subUser, 'username', $conn)."</td>
                            <td>".prob($subProb, $conn)."</td>
                            <td>$subLang</td>
                            <td><code>$subResult ($subRuntime"."s)</code></td>";
                        if (isLogin() && isAdmin($_SESSION['id'], $conn)) $html .= "<td><a href='#'><i class='fas fa-search'></i></a></td>";
                        $html .= "</tr>";
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
