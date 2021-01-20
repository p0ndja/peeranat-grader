<?php 
    require '../static/functions/connect.php';
    require '../static/functions/function.php';
?>

<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">

<head>
    <?php require '../static/functions/head.php'; ?>
</head>
<?php require '../static/functions/navbar.php'; ?>
<body>
    <?php if (isset($_GET['target']) && file_exists($_GET['target'])) include $_GET['target']; ?>
    <?php require '../static/functions/popup.php'; ?>
    <?php require '../static/functions/footer.php'; ?>
    <!--div id="watermark" class="text-right text-danger"><small>Happy birthday Grader.ga!</small><br>♪ (｡´＿●`)ﾉ┌iiii┐ヾ(´○＿`*) ♪</div-->
    <div id="watermark" class="text-right"><div class="animated bounce slow delay-1s infinite"><i class="fas fa-flask"></i></div><h4 class="font-weight-bold">Closed Beta Version!</h4>We're so glad to see you here!<br><small><a href="//m.me/p0ndja" target="_blank">Report a bug & suggestion <i class="fas fa-bug"></i></a></small></div>
</body>

</html>