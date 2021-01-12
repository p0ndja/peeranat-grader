
    <?php $incoming = false; $contest = true; ?>
    <div class="container" style="padding-top: 88px;">
        <?php if ($contest) { ?>
        <div align="center">
            <h3 class="font-weight-bold text-coe">Contest Name</h3>
            <h1 class="display-1 font-weight-bold">12:00:00</h1>
            <p>2021/01/01 00.01 GMT+7 to 2021/12/31 23.59 GMT+7<br></p>
        </div>
        <table class="table table-responsive w-100 d-block d-md-table">
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
                <tr onclick="window.location='../problem/1'">
                    <th scope="row">1</th>
                    <td>Welcome to Grader.ga</td>
                    <td class="text-secondary">Peaceful</td>
                    <td>1 Second</td>
                    <td>1 Megabyte</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>โรงแรมในฝัน</td>
                    <td class="text-success">Easy</td>
                    <td>1 Second</td>
                    <td>1 Megabyte</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>ตัวเลขที่สวยงาม</td>
                    <td class="text-warning">Normal</td>
                    <td>1 Second</td>
                    <td>4 Megabyte</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>พ่อสั่งน้องขอ</td>
                    <td class="text-danger">Hard</td>
                    <td>1.5 Second</td>
                    <td>4 Megabyte</td>
                </tr>
            </tbody>
        </table>
        
        
        <?php } else if ($incoming) { ?>
        <div class="center" align="center">
            <h4>มีการแข่งขันที่กำลังจะเริ่มขึ้น...</h4>
            <h3 class="font-weight-bold text-coe">Contest Name</h3>
            <h1 class="display-1 font-weight-bold">12:00:00</h1>
            <p>2021/01/01 00.01 GMT+7 to 2021/12/31 23.59 GMT+7<br><small class="text-muted">(364 Days 23 Hours 58 Minute)<small></p>
            <a href="../scoreboard/" class="btn btn-coe">ดูประวัติการแข่งขัน</a>
        </div>
        <?php } else { ?>
        <div class="center" align="center">
            <h1 class="font-weight-bold text-coe">Contest</h1>
            <h4>ไม่มีการแข่งขันที่กำลังจะเกิดขึ้น</h4>
            <p>อย่าลืมฝึกทำโจทย์ด้วยแหละ !</p>
            <a href="../scoreboard/" class="btn btn-coe">ดูประวัติการแข่งขัน</a>
        </div>
        <?php } ?>
    </div>
