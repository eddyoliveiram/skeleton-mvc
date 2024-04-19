<?php
// Capturando todos os parâmetros GET atuais, exceto 'page'
$queryParams = $_GET;
unset($queryParams['page']);
$queryString = http_build_query($queryParams);

if(isset($paginacao)):
    $totalPages = $paginacao['__totalPaginas'];
    $currentPage = $paginacao['__paginaAtual'];
    $range = 3;
    $initialNum = $currentPage - $range;
    $conditionLimitNum = ($currentPage + $range) + 1;

    if ($totalPages > 1): ?>
        <nav style="background-color: white">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=1">Primeira</a></li>
                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $currentPage - 1 ?>">Anterior</a></li>
                <?php endif; ?>

                <?php for ($i = $initialNum; $i < $conditionLimitNum; $i++): ?>
                    <?php if (($i > 0) && ($i <= $totalPages)): ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>"><a class="page-link" href="?<?= $queryString ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $currentPage + 1 ?>">Próximo</a></li>
                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $totalPages ?>">Última</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif;
endif;
?>
