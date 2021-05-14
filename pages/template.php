<?php require_once '../static/functions/connect.php'; ?>

<div class="container" style="padding-top: 88px;">
    <div class="container mb-3" id="container">
        <?php print_r(latestIncrement('graderga', 'problem', $conn)); ?>
    </div>
</div>
