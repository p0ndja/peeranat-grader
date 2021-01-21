<div class="container mb-3" style="padding-top: 88px;" id="container">
    <h1 class="display-4 font-weight-bold text-center text-coe">Submission</h1>
    <?php if (isLogin()) { ?>
    <div class="switch switch-danger mb-1 disabled">
        <label>
            <input type="checkbox" name="onlyme" id="onlyme">
            <span class="lever"></span>Only My Submission (BUG ;-;)
        </label>
    </div>
    <script>
        $("#onlyme").change(function() {
            if ($(this).is(':checked')) {
                $('tr:not(.me)').hide();
            } else {
                $('tr:not(.me)').show();
            }
            submission_table.draw();

        });
    </script>
    <?php } ?>
    <table class="table table-responsive table-hover w-100 d-block d-md-table" id="submissionTable">
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
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            $me = (isLogin() && ($_SESSION['id'] == $row['user'] || isAdmin($_SESSION['id'], $conn))) ? "data-owner='true'" : "data-owner='false'";
                            $subID = $row['id'];
                            $subUser = $row['user'];
                            $subProb = $row['problem'];
                            $subLang = $row['lang'];
                            $subResult = $row['result'] != 'W' ? $row['result']: 'รอผลตรวจ...';
                            $subRuntime = $row['runningtime']/1000;
                            $subUploadtime = $row['uploadtime']; 
                            $i++; ?>
                            <tr style="cursor: pointer;" class='launchModal' <?php echo $me;?> id='sub<?php echo $subID;?>' onclick='javascript:;' data-toggle='modal' data-target='#modalPopup' data-title='Submission #<?php echo $subID; ?>' data-id='<?php echo $subID; ?>' data-uid='<?php echo $subUser; ?>'>
                                <th scope='row' data-order='<?php echo $i; ?>'><?php echo $subID; ?></th>
                                <td data-order='<?php echo $i; ?>'><?php echo $subUploadtime; ?></td>
                                <td><?php echo getUserdata($subUser, 'username', $conn); ?></td>
                                <td><?php echo prob($subProb, $conn); ?></td>
                                <td><?php echo $subLang; ?></td>
                                <td <?php if ($row['result'] == 'W') echo "data-wait=true data-sub-id='$subID'"; ?>><code><?php echo $subResult . ' (' . $subRuntime . 's)';?></code></td>
                            </tr>
                        <?php }
                        $stmt->free_result();
                        $stmt->close();  
                    }
                }
            ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function () {
            var submission_table = $('#submissionTable').DataTable({
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"] ]
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
</div>
