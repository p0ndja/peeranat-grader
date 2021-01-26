<div class="homepage">
    <div class="container-fluid h-100 w-100">
        <div class="h-100 w-100 row align-items-center">
            <div class="d-none d-md-block col-md-1"></div>
            <div class="col-12 col-md-5">
                <div class="bounceInDown animated">
                    <h1 class="font-weight-bold text-coe display-4">Grader.ga</h1>
                    <h4 class="font-weight-normal">The Computer Engineering of <b class="text-nowrap">Khon Kaen University</b><br>Student-Made grader.</h4>
                    <a class="btn btn-coe" href="../problem/">เริ่มทำโจทย์กันเลย !</a>
                    <a class="btn btn-coe" target="_blank" href="https://drive.google.com/file/d/19aNSPCPxMvg8BQVI9z_P9ELP4OmLSEtO/view?usp=drivesdk">วิธีการใช้งาน Grader.ga</a>
                </div>
                <div class="fadeIn animated">
                    <?php
                        $files = glob("../static/elements/index/*.*", GLOB_BRACE);
                        $targetSrc = $files[rand(0,count($files)-1)];
                    ?>
                    <img src="<?php echo $targetSrc; ?>" class="mt-3 img-fluid w-100 d-block d-md-none">
                </div>
            </div>
            <div class="col-12 col-md-6 d-none d-md-block">
                <div class="fadeIn animated">
                    <img src="<?php echo $targetSrc; ?>" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</div>
