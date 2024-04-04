<?php
if(isset($_SESSION['pagination']['totalPages'])):
    $totalPages = $_SESSION['pagination']['totalPages'];
    $currentPage = $_SESSION['pagination']['currentPage'];
    if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $currentPage - 1 ?>">Anterior</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $currentPage + 1 ?>">Próximo</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif;
endif;
?>