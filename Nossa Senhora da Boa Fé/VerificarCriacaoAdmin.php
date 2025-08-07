<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["level"] !== "super_admin") {
    header("Location: Login.php");
    exit;
}

$mysqli = require __DIR__ . "/BaseDados.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $name = trim($_POST["name"]);
    $level = $_POST["level"];

    if (empty($email) || empty($password) || empty($name) || empty($level)) {
        header("Location: CriarAdmin.php?error=Preencha todos os campos.");
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id FROM boafeadmin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: CriarAdmin.php?error=Email já está registado.");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO boafeadmin (email, password, name, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $email, $hashed_password, $name, $level);

    if ($stmt->execute()) {
        header("Location: CriarAdmin.php?success=1");
        exit;
    } else {
        header("Location: CriarAdmin.php?error=Erro ao criar administrador.");
        exit;
    }
} else {
    header("Location: CriarAdmin.php");
    exit;
}
