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
    <?php if (isset($_GET['target']) && file_exists($_GET['target'])) include $_GET['target']; ?>
    <?php require '../static/functions/popup.php'; ?>
    <?php require '../static/functions/footer.php'; ?>
</body>

</html>