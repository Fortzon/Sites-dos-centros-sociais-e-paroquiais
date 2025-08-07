<?php
session_start();
$mysqli = require __DIR__ . '/BaseDados.php';

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

if($_SESSION["level"] === "super_admin") {
    $resultado = $mysqli->query("SELECT id, title, created_at, status FROM news ORDER BY id DESC");
}
else {
    $resultado = $mysqli->query("SELECT id, title, created_at, status FROM news WHERE status = 'active' ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSPBF - Painel de Notícias</title>
    <link rel="icon" href="Imagens/Logo.ico">

    <!-- CSS: -->
    <link rel="stylesheet" href="Admin.css">
    
    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php
        include('AdminHeader.php');
    ?>
    <main class="painel-main"> 
        <?php if($resultado || $resultado->num_rows > 0) { ?>
        <h1>Gerenciar Notícias</h1>
        <table class="painel-tabela" border="1">
            <thead class="painel-colunas"><tr><th>ID</th><th>Título</th><th>Status</th><th>Data de escrita</th><th>Ações</th></tr></thead>
            <tbody>
            <?php while ($linha = $resultado->fetch_assoc()): ?>
                <tr>
                    <td class="tabela-linha-v1"><?= htmlspecialchars($linha['id']) ?></td>
                    <td class="tabela-linha-v2"><?= htmlspecialchars($linha['title']) ?></td>
                    <td class="tabela-linha-v1"> 
                        <form method="POST" action="AtualizarStatus.php">
                            <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="draft" <?= $linha['status'] === 'draft' ? 'selected' : '' ?>>Rascunho</option>
                                <option value="published" <?= $linha['status'] === 'published' ? 'selected' : '' ?>>Publicado</option>
                                <?if($_SESSION["level"] === "super_admin") {              ?>          
                                    <option value="deleted" <?= $linha['status'] === 'deleted' ? 'selected' : '' ?>>Apagado</option>
                                <?}
                                ?>
                            </select>
                        </form>
                    </td>
                    <td class="tabela-linha-v2"> 
                        <?php
                            $data = new DateTime($linha['created_at']);
                            $dataFormatada = $data->format('d/m/Y');
                            echo $dataFormatada;
                        ?>
                    </td>
                    <td class="tabela-linha-v1">
                        <a class="admin-links" href="EditarNoticia.php?id=<?= $linha['id'] ?>">Editar</a> |
                        <form action="ExcluirNoticia.php" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza?')">
                            <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <button class="excluir-btn" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        
        <?php } 
        else{
            echo "<h1>Nenhuma notícia encontrada.</h1>";
        } ?>
    </main>
    <?php
        include('scripts.html');
    ?>
</body>
</html>
