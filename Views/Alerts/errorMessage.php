<?php if (isset($errorMsg) && !empty($errorMsg)) :?>
    <?php if (isset($errorMsg)){
        unset($_SESSION["success"]);
    }?>
    <div class="alert alert-danger w-100">
        <?php echo $errorMsg; ?>
    </div>

<?php endif; ?>