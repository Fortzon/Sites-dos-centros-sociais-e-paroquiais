<?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "/BaseDados.php";

        $stmt = $mysqli->prepare("SELECT * FROM giesteiraadmin WHERE id = ?");
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
    <title>CSPSSG - Admin</title>
    <link rel="icon" href="Imagens/Logo.ico">

    <!-- CSS: -->
    <link rel="stylesheet" href="Admin.css">

    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
        include('AdminHeader.php');
    ?>
    <?php if (isset($user)) : ?>
        <h1 class="admin-h1">Bem-vindo <?= htmlspecialchars($user["name"]) ?></</h1>
        <h2 class="admin-h2">O que deseja fazer? Publicar <a class="admin-links" href="PublicacaoTitulos.php">Noticias</a>, <a class="admin-links" href="PublicacaoRelatorios.php">Documentos</a> ou <a class="admin-links" href="PainelNoticias.php">Verificar Noticias</a></h3>
        <?if($_SESSION["level"] === "super_admin") {?>          
            <h2 class="admin-h2"><a class="admin-links" href="CriarAdmin.php">Criar admins</a></h2>
        <?}?>
    <?php else : ?>
        <a class="admin-links" href="Login.php">Faça seu login aqui</a>
    <?php endif; ?>
    <?php
        include('scripts.html');
    ?>
</body>

</html>