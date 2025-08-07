<?php
    session_start();

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
    <title>CSPBF - Publicação de relatórios</title>
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
        <form id="FormPub" action="Relatorio.php" method="POST" enctype="multipart/form-data">
            <div class="DivInfo">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="TituloI" required>
            </div>
            <div class="DivInfo">
                <label for="relatorio" class="Relatorio">Adicionar ficheiro do relatório</label>
                <input type="file" name="relatorio" class="Relatorio" accept="application/pdf" required>
            </div>
            <div class="DivInfo">
                <select name="TiposRelatoriosSelect" required>
                    <option value="PlanosOrcamentos">Planos de Atividades e Orçamentos</option>
                    <option value="RelatoriosGestao">Relatórios de Gestão e Contas</option>
                </select>
            </div>
            <div class="DivInfo" id="DivFinal">
                <input type="submit" value="Salvar ficheiro" id="Post">
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