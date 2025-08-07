<?php if (isset($user)) : ?>
    <header id="BemVindo">
        <header id="LogoHeader">
            <a class="logo-link" href="index.php"><img src="Imagens/Logo.jpg" alt="Logo" id="ImgLogo"></a>
        </header>
        <div class="MenuDiv">
            <button class="Menu">  
                <i class='bx bx-menu'></i>
            </button>
        </div>
        <h1>Bem-vindo <?= htmlspecialchars($user["name"]) ?></h1>
        <nav class="navbar">
            <button class="Fechar">
                <i class="bx bx-x"></i>
            </button>
            
            <ul class="links">
                <li><a class="nav-admin-link" href="AdminDashboard.php" id="Home">Admin</a></li>
                <li><a class="nav-admin-link" href="PublicacaoTitulos.php">Notícias</a></li>
                <li><a class="nav-admin-link" href="PublicacaoRelatorios.php">Relatórios</a></li>
                <li><a class="nav-admin-link" href="PainelNoticias.php">Verificar Noticias</a></li>
                <?if($_SESSION["level"] === "super_admin") {?>          
                    <li><a class="nav-admin-link" href="CriarAdmin.php">Criar admins</a></li>
                <?}?>
            </ul>
        </nav>
        <div id="DivLink">
            <a href="Logout.php">LOGOUT</a>
        </div>
    </header> 
<?php endif; ?>