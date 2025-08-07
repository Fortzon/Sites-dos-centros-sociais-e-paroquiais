<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: Login.php");
    exit;
}

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/BaseDados.php";

    $stmt = $mysqli->prepare("SELECT * FROM boafeadmin WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();
}

$mysqli = require __DIR__ . "/BaseDados.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID da notícia não fornecido.");
}

$stmt = $mysqli->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

$noticia = $resultado->fetch_assoc();

if (!$noticia) {
    die("Notícia não encontrada.");
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="Admin.css">
    <script src="https://cdn.tiny.cloud/1/wu441monj2gv4bjh5el2b10en9q2lgdp0fohfb4jk7os8ts2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

<?php include 'AdminHeader.php'; ?>

<form id="FormPub" action="AtualizarNoticia.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <div class="DivInfo">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="TituloI" value="<?= htmlspecialchars($noticia['title']) ?>" required>
    </div>

    <div class="DivInfo">
        <label for="noticia">Notícia:</label>
        <textarea name="noticia" id="noticiaTA" required><?= htmlspecialchars($noticia['new']) ?></textarea>
    </div>

    <div class="DivInfo" id="DivFinal">
        <input type="submit" value="Atualizar Notícia">
    </div>
</form>

<script src="Rascunho.js"></script>
<script src="editorTexto.js"></script>
<?php
    include('scripts.html');
?>
</body>
</html>
