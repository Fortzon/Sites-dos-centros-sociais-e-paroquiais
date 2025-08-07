<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
}

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/BaseDados.php";

    $stmt = $mysqli->prepare("SELECT * FROM giesteiraadmin WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    $Titulo = $_POST['titulo'];
    $Noticia = $_POST['noticia'];
    $Status = $_POST['status'];
    
    if (empty($Titulo) || empty($Noticia)) {
        die("Título e descrição são obrigatórios.");
    }

    if ($Titulo != "" and $Noticia != "") {
        $stmt = $mysqli->prepare("INSERT INTO news (title,new,status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $Titulo, $Noticia, $Status);
        if (!$stmt->execute()) {
            die("Erro ao salvar notícia no banco de dados.");
        }
    }

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

    $simplesTitulo = slugify($Titulo);

    $noticiasDir = __DIR__ . "/Noticias/";
    if (!is_dir($noticiasDir)) {
        mkdir($noticiasDir, 0777, true);
    }

    $ficheiro = $noticiasDir . $simplesTitulo . ".php";

    if (file_put_contents($ficheiro, $html) === false) {
        die("Erro ao criar o ficheiro HTML em: " . $ficheiro);
    }

    file_put_contents($ficheiro, $html);
}

function slugify($texto) {
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); 
    $texto = preg_replace('/[^a-zA-Z0-9-_]/', '_', $texto);
    return $texto;
}

echo "<script>alert('Notícia publicada com sucesso!'); window.location.href = 'PainelNoticias.php';</script>";

$pasta = slugify($Titulo);
$pastaCaminho = __DIR__ . "/Imagens/Noticias/$pasta";

if (is_dir($pastaCaminho)) {
    $arquivos = array_diff(scandir($pastaCaminho), ['.', '..']);
    
    foreach ($arquivos as $arquivo) {
        $caminhoRelativo = "../Imagens/Noticias/$pasta/$arquivo";

        if (strpos($Noticia, $caminhoRelativo) === false) {
            unlink($pastaCaminho . "/" . $arquivo); 
        }
    }

    $restantes = array_diff(scandir($pastaCaminho), ['.', '..']);
    if (empty($restantes)) {
        rmdir($pastaCaminho);
    }
}
exit;