<!-- /app/views/home.php -->
<?php //echo '<pre>'; print_r($_REQUEST); echo  '</pre>'?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?= $data['name']; ?>!</h1>
    <?require_once ("layout/menu.php")?>
    <form action="<?=BASE_PATH;?>/about/index" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br><br>
        <input type="submit" value="Enviar">
    </form>

</body>
</html>

