<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Erro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .error-container { text-align: center; }
        .details { margin-top: 20px; text-align: left; display: inline-block;}
        .details strong { font-size: 16px; }
        .details div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="error-container" style="color: #4d4d4d">
        <h1>Erro ao Processar a Solicitação</h1>
        <?php if ($showDetails): ?>
            <div class="details" style="border: 2px solid gray; padding: 15px; border-radius: 20px">
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
