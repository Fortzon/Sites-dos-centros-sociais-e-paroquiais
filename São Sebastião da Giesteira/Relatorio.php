<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["user_id"])) {
        header("Location: Login.php");
        exit;
    }

    if (!isset($_FILES["relatorio"]) || $_FILES["relatorio"]["error"] !== UPLOAD_ERR_OK) {
        die("Erro ao carregar o ficheiro.");
    }

    $titulo = trim($_POST["titulo"]);
    if (empty($titulo)) {
        die("O título não pode estar vazio.");
    }

    $tituloSanitizado = preg_replace('/[^a-zA-Z0-9-_]/', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $titulo));
    $tipo = $_POST["TiposRelatoriosSelect"];

    if ($tipo === "PlanosOrcamentos") {
        $pastaDestino = __DIR__ . "/Documentos/Orcamentos/";
    } elseif ($tipo === "RelatoriosGestao") {
        $pastaDestino = __DIR__ . "/Documentos/Relatorios/";
    } else {
        die("Tipo de relatório inválido.");
    }

    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }

    $fileType = mime_content_type($_FILES["relatorio"]["tmp_name"]);
    if ($fileType !== "application/pdf") {
        die("Apenas ficheiros PDF são permitidos.");
    }

    $nomeFinal = $tituloSanitizado . ".pdf";
    $caminhoFinal = $pastaDestino . $nomeFinal;

    if (move_uploaded_file($_FILES["relatorio"]["tmp_name"], $caminhoFinal)) {
        echo "Ficheiro enviado com sucesso!";
        echo "<br><a href='AdminDashboard.php'>Voltar ao dashboard</a>";
    } else {
        echo "Erro ao guardar o ficheiro.";
    }
}
?>
