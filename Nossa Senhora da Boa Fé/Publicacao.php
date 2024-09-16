<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/BaseDados.php";

    $sql = "SELECT * FROM boafeadmin 
        WHERE id = {$_SESSION["user_id"]}";

    $resultado = $mysqli->query($sql);

    $user = $resultado->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local de publicação</title>

    <!-- CSS: -->
    <link rel="stylesheet" href="Publicacao.css">
</head>

<body>
    <?php if (isset($user)) : ?>
    <header id="BemVindo">
        <h1>Bem vindo <?= htmlspecialchars($user["Nome"]) ?></h1>
        <div id="DivLink">
            <a href="Logout.php">LOGOUT</a>
        </div>
    </header>
    <form id="FormPub" action="Publicacao2.php" method="POST">
        <div class="DivInfo">
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="TituloI">
        </div>
        <div class="DivInfo">
            <label for="descricao" id="Descricao">Descrição</label>
            <textarea type="text" name="descricao" id="DescricaoTA"></textarea>
        </div>
        <div class="DivInfo">
            <label for="imagem" class="Imagem">Adicionar imagem</label>
            <input type="file" name="imagem" class="Imagem">
        </div>
        <div class="DivInfo" id="DivFinal">
            <input type="submit" value="Adicionar Post" id="Post">
        </div>
    </form>
    <?php else : ?>
    <a href="Login.php">Faça seu login aqui</a>
    <?php endif; ?>
</body>

</html>