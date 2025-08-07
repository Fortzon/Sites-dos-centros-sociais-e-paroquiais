<?php
    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "/BaseDados.php";

        $stmt = $mysqli->prepare("SELECT * FROM boafeadmin WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $user = $resultado->fetch_assoc();
    }
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSPBF - Titulo da noticia</title>
    <link rel="icon" href="Imagens/Logo.ico">

    <!-- CSS: -->
    <link rel="stylesheet" href="Admin.css">
    <script src="https://cdn.tiny.cloud/1/wu441monj2gv4bjh5el2b10en9q2lgdp0fohfb4jk7os8ts2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
        include('AdminHeader.php');
    ?>
    <?php if (isset($user)) : ?>
        <form id="FormPub" action="PublicacaoNoticia.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="DivInfo">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="TituloI" required>
            </div>
            <div class="DivInfo" id="DivFinal">
                <input type="submit" value="Escrever notícia" id="Post">
            </div>
        </form>
    <?php else : ?>
        <a class="admin-links" href="Login.php">Faça seu login aqui</a>
    <?php endif; ?>
    <?php
        include('scripts.html');
    ?>
</body>

</html>