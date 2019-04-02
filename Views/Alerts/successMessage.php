<?php if (isset($successMsg) && !empty($successMsg)) : ?>
    <div class="alert alert-success w-100">
        <?php echo $successMsg; ?>
    </div>
<?php elseif (isset($_SESSION["success"])) :?>
    <div class="alert alert-success w-100">
        <?php echo $_SESSION["success"]; ?>
    </div>
<?php endif; ?>