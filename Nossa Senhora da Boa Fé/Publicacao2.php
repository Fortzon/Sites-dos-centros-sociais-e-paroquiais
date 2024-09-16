<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/BaseDados.php";

    $sql = "SELECT * FROM boafeadmin 
        WHERE id = {$_SESSION["user_id"]}";

    $resultado = $mysqli->query($sql);

    $user = $resultado->fetch_assoc();

    $Titulo = $_POST['titulo'];
    $Descricao = $_POST['descricao'];
    $Imagem = $_POST['imagem'];

    if ($Titulo != "" and $Descricao != "" and $Imagem != null) {
        $Imagem = "./Imagens/Noticias/$Imagem";
        $result = "INSERT INTO noticias (Titulo,Descricao,Imagem) VALUES ('.$Titulo.','.$Descricao.','.$Imagem.')";
    }

$html = null;
    
$html .= '<!DOCTYPE html>';
$html .= '<html lang="pt">';
$html .= '<head>';
$html .= '<meta charset="UTF-8">';
$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '<title>' . $Titulo . '</title>';
$html .= '<link rel="icon" href="Imagens/Logo.ico">';

// Bootstrap CSS
$html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';

// Bootstrap JS
$html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>';

// CSS
$html .= '<link rel="stylesheet" href="style.css">';

// BoxIcons
$html .= '<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">';

$html .= '</head>';
$html .= '<body>';
$html .= '<header>';
$html .= '<header id="LogoHeader">';
$html .= '<img src="imagens/Logo.png" alt="Logo" id="ImgLogo">';
$html .= '</header>';
$html .= '<div class="MenuDiv">';
$html .= '<button class="Menu">';
$html .= '<i class="bx bx-menu"></i>';
$html .= '</button>';
$html .= '</div>';
$html .= '<nav class="navbar">';
$html .= '<button class="Fechar">';
$html .= '<i class="bx bx-x"></i>';
$html .= '</button>';
$html .= '<div class="nav-links">';
$html .= '<ul class="links">';
$html .= '<li><a href="index.html" id="Home">Home</a></li>';
$html .= '<li>';
$html .= '<a href="#">Direção</a>';
$html .= '<i class="bx bxs-chevron-down arrow"></i>';
$html .= '<ul class="Direcao-sub-menu sub-menu">';
$html .= '<li><a href="Historia.html">Historia</a></li>';
$html .= '<li><a href="MensagemDoPresidente.html">Mensagem do Presidente</a></li>';
$html .= '<li><a href="OrgaosSociais.html">Orgãos Sociais</a></li>';
$html .= '<li><a href="ObjetivosPrincipais.html">Objetivos Principais</a></li>';
$html .= '<li><a href="MissaoVisaoValores.html">Missão/Visão/Valores</a></li>';
$html .= '</ul>';
$html .= '</li>';
$html .= '<li>';
$html .= '<a href="#">Informações</a>';
$html .= '<i class="bx bxs-chevron-down arrow"></i>';
$html .= '<ul class="Info-sub-menu sub-menu">';
$html .= '<li><a href="RH.html">Recursos Humanos</a></li>';
$html .= '<li><a href="RespostasSociais.html">Respostas Sociais</a></li>';
$html .= '<li><a href="ServicoSocial.html">Serviço Social</a></li>';
$html .= '<li><a href="AnimacaoSociocultural.html">Animação Sociocultural</a></li>';
$html .= '<li><a href="ServicoMedicoDeEnfermagem.html">Serviço Médico de Enfermagem</a></li>';
$html .= '</ul>';
$html .= '</li>';
$html .= '<li id="Documentos">';
$html .= '<a href="#">Documentos</a>';
$html .= '<i class="bx bxs-chevron-down arrow"></i>';
$html .= '<ul class="Documentos-sub-menu sub-menu">';
$html .= '<li><a href="Reclamacoes.html">Reclamações</a></li>';
$html .= '<li>';
$html .= '<a href="#">Plano de Atividades e Orçamentos</a>';
$html .= '<i class="bx bxs-chevron-left arrow-left"></i>';
$html .= '<ul class="PlanoAtividades-sub-menu sub-sub-menu">';
$html .= '<li><a href="#">Plano de Atividades e Orçamentos</a></li>';
$html .= '</ul>';
$html .= '</li>';
$html .= '<li>';
$html .= '<a href="#">Relatório de Gestão e Contas</a>';
$html .= '<i class="bx bxs-chevron-left arrow-left"></i>';
$html .= '<ul class="Relatorio-sub-menu sub-sub-menu">';
$html .= '<li><a href="#">2020</a></li>';
$html .= '</ul>';
$html .= '</li>';
$html .= '<li><a href="FichasDeInscricao.html">Fichas de</a></li>';
$html .= '</ul>';
$html .= '</li>';
$html .= '<li>';
$html .= '<a href="#">Notícias</a>';
$html .= '<i class="bx bxs-chevron-down arrow"></i>';
$html .= '<ul class="Noticias-sub-menu sub-menu">';
$html .= '</ul>';
$html .= '</li>';
$html .= '</ul>';
$html .= '</div>';
$html .= '</nav>';
$html .= '<div class="DivLog">';
$html .= '<div class="Logins">';
$html .= '</div>';
$html .= '</div>';
$html .= '</header>';
$html .= '<main>';
$html .= '<h1>' . $Titulo . '</h1>';
$html .= '<img src="' . $Imagem . '" alt="Imagem não encontrada">';
$html .= '<p>' . $Descricao . '</p>';
$html .= '</main>';
$html .= '</body>';
$html .= '</html>';

$file = "C:\Users\Fortzon\Desktop\Dados para enviar no email\ " . $Titulo . '.html';
    echo $file;
    if ($files == null){
        $files = [
            "path_to_file_1.html",
        ];
    }
file_put_contents($file, $html);
}