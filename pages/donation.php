<div class="container" style="padding-top: 88px;">
    <div class="container mb-3" id="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <h1 class="font-weight-bold text-center">Donation</h1>
                <div class="d-flex justify-content-center"><img src="https://promptpay.io/0908508007/270x270"
                        class="z-depth-1" /></div><br>
                <div class="d-flex justify-content-center"><b>Promptpay</b> : Palapon Soontornpas
                    (<code>090-8508007</code>)</div><br>
            </div>
            <div class="col-12 col-md-4">
                <h4 class="font-weight-bold text-center">Donator (Last 10 records)</h4>
                <div class="table-responsive">
                    <table class="table table-hover w-100 d-block d-md-table" id="submissionTable">
                        <thead>
                            <tr class="text-nowrap me">
                                <th scope="col" class="font-weight-bold text-coe">User</th>
                                <th scope="col" class="font-weight-bold text-coe">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-nowrap">
                            <?php
                    $target = "../donator.txt";
                    if (file_exists($target)) {
                        $f = fopen("../donator.txt", "r");
                        $i = 0;
                        $total = 0;
                        while(!feof($f)) {
                            $i++;
                            $l = explode(" ", fgets($f));
                            $total += (double) $l[1];
                            if ($i <= 10) //Display only last 10
                                echo "<tr><th scope='row'>".$l[0]."</th><td>".$l[1]." ฿</td></tr>";
                        }
                        fclose($f);
                    }
                ?>
                        </tbody>
                    </table>
                </div>
                <?php $val = ($total / 150)*100;
                if ($val > 100) $val = 100; ?>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-coekku" role="progressbar" style="width: <?php echo $val;?>%" aria-valuenow="<?php echo $val;?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small><?php echo $total; ?>/150 THB (<?php echo $val; ?>%)</small>
            </div>
        </div>
    </div>
</div>