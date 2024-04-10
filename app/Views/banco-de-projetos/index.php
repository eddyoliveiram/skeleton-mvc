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
    <input type="hidden" id="public_path" value="<?=PUBLIC_PATH;?>">
    <div class="container" style="background-color: #f2f2f2;">
        <?php require_once VIEW_PATH.'/layout/header.php'; ?>
        <?php require_once VIEW_PATH.'/layout/navbar.php'; ?>
        <?php require_once VIEW_PATH.'/layout/filtros.php';  ?>
        <?php require_once VIEW_PATH.'/layout/validator-message.php';  ?>

        <button type="button" id="btnCadastrarNovo" class="btn btn-success h45">
            Cadastrar Novo
        </button>
        <div class="card mt8" style="box-shadow: 3px 6px 6px rgba(0, 0, 0, 0.2);">
            <h5 class="card-header text-center">
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
                            <th>Data de Nascimento</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?if(isset($users))
                            foreach ($users as $user){?>
                                <tr>
                                    <td><?=$user['cd_inscricao']?></td>
                                    <td><?=$user['nome']?></td>
                                    <td><?=$user['dt_nascimento']?></td>
                                    <td>
                                        <button type="button" class="btn btn-intranet btn-edit"
                                                data-cd-inscricao="<?=$user['cd_inscricao']?>" data-nome="<?=$user['nome']?>"
                                                data-dt-nascimento="<?=$user['dt_nascimento']?>">
                                            Editar
                                        </button>
                                        <form method="POST" action="<?=PUBLIC_PATH;?>/projetos/deletar" >
                                            <input type="hidden" name="id" value="<?=$user['cd_inscricao']?>">
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <? }?>
                        </tbody>
                    </table>
                </p>
                <?php require_once VIEW_PATH.'/layout/pagination.php';  ?>
            </div>
        </div>

        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm" method="POST" action="<?=PUBLIC_PATH;?>/projetos/inserir">
                            <input type="hidden" id="cd_inscricao" name="cd_inscricao">
                            <div class="form-group">
                                <label for="nome">Name:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?=isset($_SESSION['__OLD']['nome'])? $_SESSION['__OLD']['nome'] : null;?>">
                            </div>
                            <div class="form-group">
                                <label for="dt_nascimento">Data:</label>
                                <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?=isset($_SESSION['__OLD']['cpf'])? $_SESSION['__OLD']['cpf'] : null;?>">
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-intranet h45 w125">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php //require_once VIEW_PATH.'/layout/footer.php';  ?>
        <BR>
        <div class="row text-center w-75 mx-auto">
            <small style="margin: 0 auto;">Copyright &copy; Secretaria de Estado de Educa&ccedil;&atilde;o - PAR&Aacute;. Todos os direitos reservados.</small>
        </div>
        <BR>

    </div>
    <script>
        $(document).ready(function() {
            var public_path = $("#public_path").val();
            $('#btnCadastrarNovo').click(function() {
                $('#cd_inscricao').val('');
                $('#nome').val('');
                $('#dt_nascimento').val('');
                $("#frm").attr('action', public_path+'/projetos/inserir')
                $('#formModal').modal('show');
            });
            $('.btn-edit').click(function() {
                $('#cd_inscricao').val($(this).attr('data-cd-inscricao'));
                $('#nome').val($(this).attr('data-nome'));
                $('#dt_nascimento').val($(this).attr('data-dt-nascimento'));
                $("#frm").attr('action', public_path+'/projetos/atualizar')
                $('#formModal').modal('show');
            });
        });
    </script>
</body>
</html>




