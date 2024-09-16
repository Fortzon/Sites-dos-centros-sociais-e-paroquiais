<?php

$invalido = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/BaseDados.php";

    $sql = sprintf(
        "SELECT * FROM boafeadmin
        WHERE Email = '%s'",
        $mysqli->real_escape_string($_POST["Email"])
    );

    $resultado = $mysqli->query($sql);

    $user = $resultado->fetch_assoc();

    if ($user) {

        if ($_POST["Password"] == $user["Password"]) {
            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["Id"];

            header("Location: Publicacao.php");
            exit;
        }
    }

    $invalido = true;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Social e Paroquial de Nossa Senhora da Boa Fé</title>
    <link rel="icon" href="Imagens/Logo.ico">

    <!-- CSS: -->
    <link rel="stylesheet" href="Logins.css">
</head>

<body id="BodLog">
    <form method="post" id="DivLog">
        <div id="DivLogSub">
            <div id="DivSub">
                <img src="Imagens/logo.png" alt="Logo">
                <h1>Inicie sessão</h1>
                <?php if ($invalido) : ?>
                <em>Login Inválido</em>
                <?php endif ?>

                <div class="DivInfo">
                    <label for="Email" class="EmailLB1">Email</label>
                    <br>
                    <input type="text" name="Email" id="Email" value="<?= htmlspecialchars($_POST["Email"] ?? "") ?>">
                    <label for="Password" id="Pass">Palavra-passe</label>
                    <br>
                    <input type="password" name="Password" id="PasswordTB">
                    <br>
                    <input type="checkbox" name="Check" id="Check"><label id="LabelCheck" for="Check">Mostrar
                        palavra-passe</l>
                </div>
            </div>
        </div>
        <button id="Seguinte">Seguinte</button>
    </form>
    <script src="Cresce.js"></script>
</body>

</html>