<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: Login.php");
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token inválido.");
}

$mysqli = require __DIR__ . "/BaseDados.php";

$id = $_POST['id'] ?? null;
$Titulo = trim($_POST['titulo'] ?? '');
$Noticia = $_POST['noticia'] ?? '';

if (!$id || !$Titulo || !$Noticia) {
    die("Todos os campos são obrigatórios.");
}

$stmt = $mysqli->prepare("SELECT title FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$original_result = $stmt->get_result();
$original = $original_result->fetch_assoc();

if (!$original) {
    die("Notícia não encontrada.");
}

$TituloAntigo = $original['title'];
$slugAntigo = slugify($TituloAntigo);
$slugNovo = slugify($Titulo);

$stmt = $mysqli->prepare("UPDATE news SET title = ?, new = ? WHERE id = ?");
$stmt->bind_param("ssi", $Titulo, $Noticia, $id);
if (!$stmt->execute()) {
    die("Erro ao atualizar notícia.");
}

$htmlPathAntigo = __DIR__ . "/Noticias/" . $slugAntigo . ".php";
$htmlPathNovo = __DIR__ . "/Noticias/" . $slugNovo . ".php";

$header = file_get_contents("noticiaHeader.php");
$footer = file_get_contents("noticiaFooter.html");
$scripts = file_get_contents("scripts.html");

$html = null;
        
$html .= '<!DOCTYPE html>';
$html .= '<html lang="pt">';
$html .= '<head>';
$html .= '<meta charset="UTF-8">';
$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '<title>' . $Titulo . '</title>';
$html .= '<link rel="icon" href="../Imagens/Logo.ico">';

$html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';

$html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>';

$html .= '<link rel="stylesheet" href="../style.css">';

$html .= '<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">';

$html .= '</head>';
$html .= '<body>';
$html .= $header;
$html .= '<main class="main-noticia">';
$html .= '<h1>' . htmlspecialchars($Titulo) . '</h1>';
$html .= $Noticia;
$html .= '</main>';
$html .= $footer;
$html .= $scripts;
$html .= '</body>';
$html .= '</html>';

if ($slugAntigo !== $slugNovo && file_exists($htmlPathAntigo)) {
    unlink($htmlPathAntigo); 
    $filePath = $htmlPathNovo;
} else {
    $filePath = $htmlPathAntigo;
}

file_put_contents($filePath, $html);

$imgFolderOld = __DIR__ . "/Imagens/Noticias/" . $slugAntigo;
$imgFolderNew = __DIR__ . "/Imagens/Noticias/" . $slugNovo;

if ($slugAntigo !== $slugNovo && is_dir($imgFolderOld)) {
    rename($imgFolderOld, $imgFolderNew);
}

if ($slugAntigo !== $slugNovo) {
    $Noticia = str_replace(
        "Imagens/Noticias/$slugAntigo/",
        "Imagens/Noticias/$slugNovo/",
        $Noticia
    );
}

echo "<script>alert('Notícia atualizada com sucesso!'); window.location.href = 'PainelNoticias.php';</script>";
exit;


function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^a-zA-Z0-9-_]/', '_', $text);
    return $text;
}
