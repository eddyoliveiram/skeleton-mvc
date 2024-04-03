<?php if(isset($_SESSION['validation_errors']) && count($_SESSION['validation_errors']) > 0): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php foreach ($_SESSION['validation_errors'] as $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <?= htmlspecialchars($error) ?><br>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['validation_errors']); ?>
<? endif; ?>

<?if(isset($_SESSION['__SUCCESS']) && ($_SESSION['__SUCCESS'] != '')) {?>
    <div class="alert alert-success text-center" role="alert">
        <?=$_SESSION['__SUCCESS'];?>
    </div>
    <?php unset($_SESSION['__SUCCESS']); ?>
    <?php
//    $keys = array_keys($old);
//    foreach ($keys as $key) {
//        $old[$key] = null;
//    }
    ?>
<?}?>
