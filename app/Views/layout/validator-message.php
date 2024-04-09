<!-- Verificação de Erros -->
<?php if (isset($_SESSION['__ERRORS']) && count($_SESSION['__ERRORS']) > 0): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Erro!',
                html: '<?php foreach ($_SESSION['__ERRORS'] as $error) { echo htmlspecialchars($error) . "<br>"; } ?>',
                icon: 'error',
                confirmButtonText: 'Fechar'
            });
        });
    </script>
    <?php
    unset($_SESSION['__ERRORS']);
endif;
?>
<!-- Verificação de Sucesso -->
<?php if (isset($_SESSION['__SUCCESS']) && $_SESSION['__SUCCESS'] != ''): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Sucesso!',
                text: '<?= htmlspecialchars($_SESSION['__SUCCESS']); ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    <?php
    unset($_SESSION['__SUCCESS']);
    unset($_SESSION['__OLD']);
endif;
?>

<?php //if(isset($_SESSION['__ERRORS']) && count($_SESSION['__ERRORS']) > 0): ?>
<!--    <div class="alert alert-danger text-center" role="alert">-->
<!--        --><?php //foreach ($_SESSION['__ERRORS'] as $k => $fieldErrors): ?>
<!--                --><?php //= htmlspecialchars($fieldErrors) ?>
<!--            --><?php //if (($k + 1) != count($_SESSION['__ERRORS'])): ?>
<!--                <br>-->
<!--            --><?php //endif; ?>
<!--        --><?php //endforeach; ?>
<!--    </div>-->
<!--    --><?php //unset($_SESSION['__ERRORS']); ?>
<?// endif; ?>
<!---->
<?//if(isset($_SESSION['__SUCCESS']) && ($_SESSION['__SUCCESS'] != '')) {?>
<!--    <div class="alert alert-success text-center" role="alert">-->
<!--        --><?php //=$_SESSION['__SUCCESS'];?>
<!--    </div>-->
<!--    --><?php //unset($_SESSION['__SUCCESS']); ?>
<!--    --><?php //unset($_SESSION['__OLD']);?>
<?//}?>
