<?php 
    require '../static/functions/connect.php';
?>

<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">

<head>
    <?php require '../static/functions/head.php'; ?>
</head>
<?php require '../static/functions/navbar.php'; ?>

<body>
    <div class="container-fluid h-100 w-100">
        <div class="h-100 w-100 row align-items-center">
            <div class="d-none d-md-block col-md-1"></div>
            <div class="col-12 col-md-5">
                <h1 class="font-weight-bold text-coe">Grader.ga</h1>
                <h4 class="font-weight-normal">The Computer Engineering of <b class="text-nowrap">Khon Kaen University</b> Student-Made grader.</h4>
                <a class="btn btn-coe" href="../problem/">เริ่มทำโจทย์กันเลย !</a>
                <img src="../static/elements/index/3255466.png" class="mt-3 img-fluid w-100 d-block d-md-none">
                
            </div>
            <div class="col-12 col-md-6 d-none d-md-block">
                <img src="../static/elements/index/3255466.png" class="img-fluid w-100">
            </div>
        </div>
    </div>
    <?php require '../static/functions/popup.php'; ?>
    <?php require '../static/functions/footer.php'; ?>
</body>

</html>