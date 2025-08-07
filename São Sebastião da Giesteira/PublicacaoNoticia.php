<?php
    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "/BaseDados.php";

        $stmt = $mysqli->prepare("SELECT * FROM giesteiraadmin WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $user = $resultado->fetch_assoc();

        $titulo = $_POST['titulo'] ?? $_GET['titulo'] ?? '';

        if (!$titulo) {
            die("Título não fornecido.");
        }

        $pasta = preg_replace('/[^a-zA-Z0-9-_]/', '_', $titulo);
        $pastaCaminho = __DIR__ . "/Imagens/Noticias/$pasta";

        if (!is_dir($pastaCaminho)) {
            mkdir($pastaCaminho, 0777, true);
        }

    }
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSPBF - Escrita da Noticia</title>
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
        <form id="FormPub" action="Noticia.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <input type="hidden" name="titulo" id="TituloI" value="<?= htmlspecialchars($titulo) ?>">
            <div class="DivInfo">
                <label for="noticia" id="noticia">Noticia:</label>
                <textarea name="noticia" id="noticiaTA"></textarea>
            </div>
            <select name="status" required>
                <option value="draft" selected>Rascunho</option>
                <option value="published">Publicado</option>
            </select>
            <div class="DivInfo" id="DivFinal">
                <input type="submit" value="Adicionar Post" id="Post">
            </div>
        </form>
    <?php else : ?>
        <a class="admin-links" href="Login.php">Faça seu login aqui</a>
    <?php endif; ?>
    <script src="editorTexto.js"></script>
    <script src="Rascunho.js"></script>
    <?php
        include('scripts.html');
    ?>
</body>

</html>