<?php if(isset($_SESSION['__ERRORS']) && count($_SESSION['__ERRORS']) > 0): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php foreach ($_SESSION['__ERRORS'] as $k => $fieldErrors): ?>
                <?= htmlspecialchars($fieldErrors) ?>
            <?php if (($k + 1) != count($_SESSION['__ERRORS'])): ?>
                <br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['__ERRORS']); ?>
<? endif; ?>

<?if(isset($_SESSION['__SUCCESS']) && ($_SESSION['__SUCCESS'] != '')) {?>
    <div class="alert alert-success text-center" role="alert">
        <?=$_SESSION['__SUCCESS'];?>
    </div>
    <?php unset($_SESSION['__SUCCESS']); ?>
    <?php unset($_SESSION['__OLD']);?>
<?}?>
