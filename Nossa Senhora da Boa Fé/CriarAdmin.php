<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["level"] !== "super_admin") {
    header("Location: Login.php");
    exit;
}

$mysqli = require __DIR__ . "/BaseDados.php";

$stmt = $mysqli->prepare("SELECT * FROM boafeadmin WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$resultado = $stmt->get_result();
$user = $resultado->fetch_assoc();

$levels = [];
$result = $mysqli->query("SELECT id, level FROM admin_level");
while ($row = $result->fetch_assoc()) {
    $levels[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSPBF - Criar Administrador</title>
    <link rel="stylesheet" href="Admin.css">
    <link rel="icon" href="Imagens/Logo.ico">

    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include('AdminHeader.php'); ?>
    <main class="main-admin-create">
        <h1>Criar Novo Administrador</h1>

        <?php if (isset($_GET["success"])): ?>
            <p style="color: green;">Administrador criado com sucesso!</p>
        <?php elseif (isset($_GET["error"])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET["error"]) ?></p>
        <?php endif; ?>

        <form method="post" action="VerificarCriacaoAdmin.php" id="FormPub">
            <div class="DivInfo">
                <label for="email">Email:</label><br>
                <input type="email" name="email" required>
            </div>

            <div class="DivInfo">
                <label for="password">Palavra-passe:</label><br>
                <input type="password" name="password" required>
            </div>

            <div class="DivInfo">
                <label for="name">Nome:</label><br>
                <input type="text" name="name" required>
            </div>

            <div class="DivInfo">
                <label for="level">Nível:</label><br>
                <select name="level" required>
                    <option value="">Selecione o nível</option>
                    <?php foreach ($levels as $level): ?>
                        <option value="<?= $level['id'] ?>"><?= htmlspecialchars($level['level']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="DivInfo">
                <button type="submit">Criar Administrador</button>
            </div>
        </form>
    </main>
    <?php
        include('scripts.html');
    ?>
</body>
</html>
