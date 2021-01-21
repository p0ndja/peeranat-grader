<?php 
    require_once '../static/functions/connect.php';
    require_once '../static/functions/function.php';
?>

<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">

<head>
    <?php require_once '../static/functions/head.php'; ?>
</head>
<?php require_once '../static/functions/navbar.php'; ?>
<body>
    <?php if (isset($_GET['target']) && file_exists($_GET['target'])) require_once $_GET['target']; ?>
    <?php require_once '../static/functions/popup.php'; ?>
    <?php require_once '../static/functions/footer.php'; ?>
    <!--div id="watermark" class="text-right text-danger"><small>Happy birthday Grader.ga!</small><br>♪ (｡´＿●`)ﾉ┌iiii┐ヾ(´○＿`*) ♪</div-->
    <div id="watermark" class="text-right"><div class="animated bounce slow delay-1s infinite"><i class="fas fa-flask"></i></div><h4 class="font-weight-bold">Closed Beta Version!</h4>We're so glad to see you here!<br><small><a href="//m.me/p0ndja" target="_blank">Report a bug & suggestion <i class="fas fa-bug"></i></a></small></div>
</body>

</html>