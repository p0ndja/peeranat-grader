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
    <div id="watermark" class="text-right text-muted">Beta Version!<br><small>We're so glad to see you here!</small></div>
</body>

</html>