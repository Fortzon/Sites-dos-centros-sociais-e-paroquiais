<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Acesso negado.");
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token inválido.");
}

$id = $_POST['id'] ?? null;
if (!$id) {
    die("ID da notícia ausente.");
}

require __DIR__ . "/BaseDados.php";

$stmt = $mysqli->prepare("SELECT title FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$noticia = $resultado->fetch_assoc();

if (!$noticia) {
    die("Notícia não encontrada.");
}

$titulo = $noticia['Titulo'];
$slug = slugify($titulo);

$stmt = $mysqli->prepare("UPDATE news SET status = 'deleted' WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$htmlPath = __DIR__ . "/Noticias/" . $slug . ".html";
if (file_exists($htmlPath)) {
    unlink($htmlPath);
}

$imgFolder = __DIR__ . "/Imagens/Noticias/" . $slug;
if (is_dir($imgFolder)) {
    array_map('unlink', glob("$imgFolder/*"));
    rmdir($imgFolder);
}

echo "<script>alert('Notícia deletada com sucesso!'); window.location.href = 'PainelNoticias.php';</script>";
exit;


function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^a-zA-Z0-9-_]/', '_', $text);
    return $text;
}
