<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Social e Paroquial de São Sebastião da Giesteira</title>

    <link rel="icon" href="Imagens/Logo.ico">
    
    <!-- Bootstraps: -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- CSS: -->
    <link rel="stylesheet" href="style.css">
    
    <!-- BoxIcons: -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <?php
        include('header.php');
    ?>

    <main>
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="Imagens/TrabalhoCampo.jpeg" class="ImagensCar" class="d-block w-100" alt="Igreja e a Cruz">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoFrontalLonge.jpeg" class="ImagensCar" class="d-block w-100" alt="Igreja e a Cruz">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoFrontal.jpeg" class="ImagensCar" class="d-block w-100" alt="Exterior da Igreja">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoPlaca.jpeg" class="ImagensCar" class="d-block w-100" alt="Igreja próxima">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoEntrada.jpeg" class="ImagensCar" class="d-block w-100" alt="Exterior da Igreja Aproximado">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoInterior.jpeg" class="ImagensCar" class="d-block w-100" alt="Igreja próxima">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoQuarto.jpeg" class="ImagensCar" class="d-block w-100" alt="Interior da Igreja">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="Imagens/AssociaçãoBalneário.jpeg" class="ImagensCar" class="d-block w-100" alt="Interior da Igreja">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"data-bs-slide="next">
            </button>
        </div>

        <div id="DivMain">
            <h2>Madre Teresa de Calcutá </h2>
            <br>
            <h4>Texto Inspirador</h4>
            <br>
            <p id="PMain">“Enquanto estiver vivo, sinta-se vivo. Se sentir saudades do que fazia, volte a fazê-lo. Não viva de fotografias amareladas… Continue, quando todos esperam que desista. Não deixe que enferruje o ferro que existe em si. Faça com que em vez de pena, tenham respeito por si. Quando não conseguir correr, caminhe. Quando não conseguir caminhar, use uma bengala. Mas nunca se detenha.” </p>
        </div>

        <div id="DivNoticias">
            <h2 style="text-align: center;">Noticias</h2>
            <div class="DivNoticiasSub">
                <?php
                    $conn = require 'BaseDados.php';

                    $sql = "SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC";
                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {

                            echo '<div class="news-container">';
                            while ($linha = $resultado->fetch_assoc()) {
                                $tituloSlug = preg_replace('/[^a-zA-Z0-9-_]/', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $linha['title']));
                                $href = 'Noticias/' . $tituloSlug . '.php';
                                echo '<a class="link-nondeco" href="' . $href . '">';
                                    echo '<div class="news-box">';
                                    echo '<h3>' . htmlspecialchars($linha['title']) . '</h3>';
                                    echo '<div>' . $linha['new'] . '</div>';
                                    $data = new DateTime($linha['created_at']);
                                    $dataFormatada = $data->format('d/m/Y');;
                                    echo '<small>Publicado em: ' . $dataFormatada . '</small>';
                                    echo '</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                    } else {
                        echo '<p>Nenhuma notícia publicada encontrada.</p>';
                    }

                    $conn->close();
                ?>
            </div>
        </div>

    </main>
    
    <?php
        include('footer.html');
    ?>
    
    <?php
        include('scripts.html');
    ?>
</body>
</html>