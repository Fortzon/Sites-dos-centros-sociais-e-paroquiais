<?php
session_start();
header('Content-Type: application/json');

$tokenHeader = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!isset($_SESSION['csrf_token']) || $tokenHeader !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['error' => 'CSRF token mismatch.']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or upload error.']);
    exit;
}

$titulo = $_GET['titulo'] ?? $_POST['titulo'] ?? null;
if (!$titulo) {
    http_response_code(400);
    echo json_encode(['error' => 'Título é obrigatório.']);
    exit;
}

$pastaNome = preg_replace('/[^a-zA-Z0-9-_]/', '_', $titulo);
$uploadDir = __DIR__ . "/Imagens/Noticias/" . $pastaNome . "/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
$uniqueName = uniqid('img_', true) . '.' . $ext;
$uploadFile = $uploadDir . $uniqueName;

$filename = basename($_FILES['file']['name']);

$permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];

if (!in_array($ext, $permitidos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato de ficheiro não permitido.']);
    exit;
}

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
    $url = "../Imagens/Noticias/" . $pastaNome . "/" . $uniqueName;
    echo json_encode(['location' => $url]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to move uploaded file.']);
}