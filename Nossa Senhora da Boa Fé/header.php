<?php
    session_start();
?>
<header>
    <header id="LogoHeader">
        <a href="index.php"><img src="Imagens/Logo.png" alt="Logo" id="ImgLogo"></a>
    </header>
    <div class="MenuDiv">
        <button class="Menu">  
            <i class='bx bx-menu'></i>
        </button>
    </div>
    <nav class="navbar">
        <button class="Fechar">
            <i class="bx bx-x"></i>
        </button>
        <div class="nav-links">
            <ul class="links">
                <li><a href="index.php" id="Home">Home</a></li>
                <li>
                    <a href="#">Direção</a>
                    <i class='bx bxs-chevron-down arrow'></i>
                    <ul class="Direcao-sub-menu sub-menu">
                        <li><a href="Historia.php">Historia</a></li>
                        <li><a href="MensagemDoPresidente.php">Mensagem do Presidente</a></li>
                        <li><a href="OrgaosSociais.php">Orgãos Sociais</a></li>
                        <li><a href="ObjetivosPrincipais.php">Objetivos Principais</a></li>
                        <li><a href="MissaoVisaoValores.php">Missão/Visão/Valores</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Informações</a>
                    <i class='bx bxs-chevron-down arrow'></i>
                    <ul class="Info-sub-menu sub-menu">
                        <li><a href="RH.php">Recursos Humanos</a></li>
                        <li><a href="RespostasSociais.php">Respostas Sociais</a></li>
                        <li><a href="ServicoSocial.php">Serviço Social</a></li>
                        <li><a href="AnimacaoSociocultural.php">Animação Sociocultural</a></li>
                        <li><a href="ServicoMedicoDeEnfermagem.php">Serviço Médico de Enfermagem</a></li>
                    </ul>
                </li>
                <li id="Documentos">
                    <a href="#">Documentos</a>
                    <i class='bx bxs-chevron-down arrow'></i>
                    <ul class="Documentos-sub-menu sub-menu">
                        <li><a href="Reclamacoes.php">Reclamações</a></li>
                        <li>
                            <a href="#">Plano de Atividades e Orçamentos</a>
                            <i class='bx bxs-chevron-left arrow-left'></i>
                            <ul class="PlanoAtividades-sub-menu sub-sub-menu">
                                <?php
                                $pasta = __DIR__ . "/Documentos/Orcamentos/";
                                $webCaminho = "Documentos/Orcamentos/";

                                $ficheiros = glob($pasta . "*.pdf");

                                foreach ($ficheiros as $ficheiroCaminho):
                                    $nomeFicheiro = basename($ficheiroCaminho);
                                    $nomeDisplay = preg_replace('/\.pdf$/i', '', $nomeFicheiro); 
                                    $nomeDisplay = str_replace('_', ' ', $nomeDisplay); 
                                ?>
                                    <li><a href="<?= $webCaminho . $nomeFicheiro ?>" target="_blank"><?= htmlspecialchars($nomeDisplay) ?></a></li>
                                <?php endforeach; ?>
                            </ul>

                        </li>
                        <li>    
                            <a href="#">Relatório de Gestão e Contas</a>
                            <i class='bx bxs-chevron-left arrow-left'></i>
                            <ul class="Relatorio-sub-menu sub-sub-menu">
                                <?php
                                $pasta = __DIR__ . "/Documentos/Relatorios/";
                                $webCaminho = "Documentos/Relatorios/";

                                $ficheiros = glob($pasta . "*.pdf");

                                foreach ($ficheiros as $ficheiroCaminho):
                                    $nomeFicheiro = basename($ficheiroCaminho);

                                    if (preg_match('/^(\d{4})/', $nomeFicheiro, $matches)) {
                                        $nomeDisplay = $matches[1];
                                    } else {
                                        $nomeDisplay = preg_replace('/\.pdf$/i', '', $nomeFicheiro);
                                    }
                                ?>
                                    <li><a href="<?= $webCaminho . $nomeFicheiro ?>" target="_blank"><?= htmlspecialchars($nomeDisplay) ?></a></li>
                                <?php endforeach; ?>
                            </ul>

                        </li>
                        <li><a href="Documentos/FichaDeInscrição.pdf" target="_blank">Fichas de inscrição</a></li>
                    </ul>
                </li> 
                <li>
                    <a href="#">Notícias</a>
                    <i class='bx bxs-chevron-down arrow'></i>
                    <ul class="Noticias-sub-menu sub-menu">
                        <?php
                            $conn = require 'BaseDados.php';

                            $sql = "SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC";
                            $resultado = $conn->query($sql);

                            setlocale(LC_TIME, 'pt_PT.UTF-8'); 

                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    $tituloSlug = preg_replace('/[^a-zA-Z0-9-_]/', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $linha['title']));
                                    $href = 'Noticias/' . $tituloSlug . '.php';
                                    echo '<li> <a href="' . $href . '">' . htmlspecialchars($linha['title']) . '</a> </li>';
                                }
                            } else {
                                echo '<li>Nenhuma notícia publicada encontrada.</li>';
                            }

                            $conn->close();
                        ?>
                    </ul>
                </li>
            </ul>       
        </div>
    </nav>
    <div class="DivLog">
        <div class="Logins">
            <?php
                if (isset($_SESSION["user_id"])) {
                    $mysqli = require __DIR__ . "/BaseDados.php";

                    $stmt = $mysqli->prepare("SELECT * FROM boafeadmin WHERE id = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $user = $resultado->fetch_assoc();
                }
            ?>
            <?php if (isset($user)) : ?>
                <a href="AdminDashboard.php">Admin</a>
            <?php endif; ?>
        </div>
    </div>
</header>