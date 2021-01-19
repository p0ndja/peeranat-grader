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
    <table class="table table-responsive table-hover w-100 d-block d-md-table">
        <thead>
            <tr class="text-nowrap me">
                <th scope="col" class="font-weight-bold text-coe">ID</th>
                <th scope="col" class="font-weight-bold text-coe">Timestamp</th>
                <th scope="col" class="font-weight-bold text-coe">User</th>
                <th scope="col" class="font-weight-bold text-coe">Problem ID</th>
                <th scope="col" class="font-weight-bold text-coe">Language</th>
                <th scope="col" class="font-weight-bold text-coe">Result</th>
            </tr>
        </thead>
        <tbody class="text-nowrap">
            <?php
                if ($stmt = $conn -> prepare("SELECT * FROM `submission` ORDER BY `id` DESC")) {
                    //$stmt->bind_param('ii', $page, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $me = (isLogin() && $_SESSION['id'] == $row['user']) ? "me" : "";
                            $subID = $row['id'];
                            $subUser = $row['user'];
                            $subProb = $row['problem'];
                            $subLang = $row['lang'];
                            $subResult = $row['result'] != 'W' ? $row['result'] : 'รอผลตรวจ...';
                            $subRuntime = $row['runningtime']/1000;
                            $subUploadtime = $row['uploadtime']; ?>
                            <tr class='launchModal <?php echo $me;?>' id='sub<?php echo $subID;?>' onclick='javascript:;' data-toggle='modal' data-target='#modalPopup' data-title='Submission #<?php echo $subID; ?>' data-id='<?php echo $subID; ?>' data-uid='<?php echo $subUser; ?>'>
                                <th scope='row'><?php echo $subID; ?></th>
                                <td><?php echo $subUploadtime; ?></td>
                                <td><?php echo getUserdata($subUser, 'username', $conn); ?></td>
                                <td><?php echo prob($subProb, $conn); ?></td>
                                <td><?php echo $subLang; ?></td>
                                <td><code><?php echo $subResult . ' (' . $subRuntime . 's)';?></code></td>
                            </tr>
                        <?php }
                        $stmt->free_result();
                        $stmt->close();  
                    }
                }
            ?>
        </tbody>
    </table>
</div>
