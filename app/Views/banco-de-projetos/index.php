<?php
//echo '<pre>';print_r($users);echo '</pre>';
//dd($paginacao,false);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once VIEW_PATH.'/layout/scripts.php';  ?>
</head>
<body class="bg-intranet container">
    <div class="container" style="background-color: #f2f2f2;">
        <?php require_once VIEW_PATH.'/layout/header.php'; ?>
        <?php require_once VIEW_PATH.'/layout/navbar.php'; ?>
        <?php require_once VIEW_PATH.'/layout/validator-message.php';  ?>
        <div class="card mt8" style="box-shadow: 3px 6px 6px rgba(0, 0, 0, 0.2);">
            <h5 class="card-header text-center">
                Percurso de Aprofundamento e Integração de Estudos | Configuração Cadastro de Projetos
                <hr style="background-color: white">
                Projetos
            </h5>
            <div class="card-body">
                <h5 class="card-title">
                </h5>
                <p class="card-text">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Token</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?if(isset($users))
                            foreach ($users as $user){?>
                                <tr>
                                    <td><?=$user['cd_inscricao']?></td>
                                    <td><?=$user['nome']?></td>
                                    <td><?=$user['dt_nascimento']?></td>
                                    <td><?=$user['rg']?></td>
                                </tr>
                            <? }?>
                        </tbody>
                    </table>
                </p>
                <?php require_once VIEW_PATH.'/layout/pagination.php';  ?>
            </div>
        </div>

        <?php //require_once VIEW_PATH.'/layout/footer.php';  ?>
        <BR>
        <div class="row text-center w-75 mx-auto">
            <small style="margin: 0 auto;">Copyright &copy; Secretaria de Estado de Educa&ccedil;&atilde;o - PAR&Aacute;. Todos os direitos reservados.</small>
        </div>
        <BR>

    </div>
</body>
</html>




