<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Erro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .error-container { text-align: center; }
        .details { margin-top: 20px; text-align: left; display: inline-block; text-align: left; }
        .details strong { font-size: 16px; }
        .details div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Erro ao Processar a Solicitação</h1>
        <?php if ($showDetails): ?>
            <div class="details" style="border: 1px solid black; padding: 15px">
                <div><strong>Mensagem de Erro:</strong> <?= htmlspecialchars($errorMessage); ?></div>
                <div><strong>Arquivo:</strong> <?= htmlspecialchars($errorFile); ?></div>
                <div><strong>Linha:</strong> <?= htmlspecialchars($errorLine); ?></div>
            </div>
        <?php else: ?>
            <p>Desculpe, algo deu errado. Informe o setor responsável e tente mais tarde.</p>
        <?php endif; ?>
    </div>
</body>
</html>
