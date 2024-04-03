<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once VIEW_PATH.'/layout/scripts.php';  ?>
</head>
<body style="background-color: lightgray">
<?php require_once VIEW_PATH.'/layout/navbar.php';  ?>
<?php require_once VIEW_PATH.'/layout/validator-message.php';  ?>

<div style="padding:20px;">
    <div class="container">
    </div>
    <h1>INDEX</h1>
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
        <?if(isset($_SESSION['pagination']['users']))
            foreach ($_SESSION['pagination']['users'] as $user){?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['name']?></td>
                <td><?=$user['remember_token']?></td>
                <td><?=$user['email']?></td>
            </tr>
        <? }?>
        </tbody>
    </table>
    <div class="container mt-5">

        <div class="row">
            <div class="col-sm-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?=BASE_PATH;?>/index/store">
                            <div class="form-group">
                                <label for="nome">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?=$_SESSION['__OLD']['name'];?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?=$_SESSION['__OLD']['email'];?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require_once VIEW_PATH.'/layout/pagination.php';  ?>


<?php //require_once VIEW_PATH.'/layout/footer.php';  ?>
</body>
</html>




