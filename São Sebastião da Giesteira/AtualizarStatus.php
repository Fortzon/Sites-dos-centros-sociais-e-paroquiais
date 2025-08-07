<?php
session_start();
$mysqli = require __DIR__ . '/BaseDados.php';

if (!isset($_SESSION["user_id"])) {
    die("Acesso negado. Login inválido");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? null;
    $novoStatus = $_POST["status"] ?? null;

    if ($id && in_array($novoStatus, ["draft", "published", "deleted"])) {
        $stmt = $mysqli->prepare("UPDATE news SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $novoStatus, $id);
        $stmt->execute();
    }
}

header("Location: PainelNoticias.php");
exit;
