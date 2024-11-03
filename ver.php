<?php
require 'php/head.php';
require 'config/config.php';

$nombre_anime = isset($_GET['anime']) ? $_GET['anime'] : '';
$n_episodio = isset($_GET['episodio']) ? $_GET['episodio'] : '';
$nombre_anime = str_replace('-', ' ', $nombre_anime);
$iframe = null;

if (!empty($nombre_anime) && !empty($n_episodio)) {
    $stmt = $conn->prepare("SELECT * FROM anime WHERE nombre = ?");
    $stmt->bind_param("s", $nombre_anime);
    $stmt->execute();
    $result = $stmt->get_result();
    $anime = $result->fetch_assoc();
    $stmt->close();

    if ($anime && isset($anime['id']) && $anime['id'] > 0) {
        $anime_id = $anime['id'];
        $año_anime = $anime['fecha'] ? date('Y', strtotime($anime['fecha'])) : null;

        $stmt = $conn->prepare("SELECT e.iframe
                                FROM episodios e
                                WHERE e.anime_id = ? AND e.numero_episodio = ?");
        $stmt->bind_param("ii", $anime_id, $n_episodio);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $iframe = $row['iframe'];
        }
        $stmt->close();

        $stmt = $conn->prepare("SELECT e.numero_episodio
        FROM episodios e
        JOIN anime a ON e.anime_id = a.id
        WHERE a.id = ?
        ORDER BY e.numero_episodio");
        $stmt->bind_param("i", $anime_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $episodios[] = $row;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Anime web">
    <title><?php echo $nombre_anime ?> - AniUTP Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php echo $css ?>
    <?php echo $css2 ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <!--Área de encabezado Inicio-->
    <?php include 'php/navbar2.php'; ?>
    <!--Fin del área de encabezado-->
    <div class="overflow-hidden">
        <section class="anime-video">
            <div class="container">
                <div class="row">
                    <div class="col-12 my-4 nombreAnime"><?php echo $nombre_anime; ?></div>
                    <div class="col-auto contVideo">
                        <div id="listServers" class="mb-4"></div>
                        <div id="cont-videoPlayer">
                            <iframe id="videoPlayer" src="" scrolling="no" allowfullscreen=""></iframe>
                            <div class="preventor">
                                <i class="fa-regular fa-face-vomit"></i>
                                <div>Esta opción puede contener publicidad o ventanas emerjentes</div>
                                <div class="hidePreventor btn btn-primary"> Ocultar aviso</div>
                            </div>
                        </div>
                    </div>
                    <div class="col contCaps">
                        <div class="Caps">
                            <h2>Capitulos</h2>
                            <div class="mt-3">
                                <?php foreach ($episodios as $episodio): ?>
                                    <div class="episodio">
                                        <i class="fa-solid fa-circle-play"></i>
                                        <a href="/ver.php?anime=<?php echo $nombre_anime ?>&episodio=<?php echo $episodio['numero_episodio']; ?>">Episodio <?php echo $episodio['numero_episodio']; ?></a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include "php/footter.php"; ?>
    <script src="/assets/js/vendor/jquery-3.6.3.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        var videos = <?php echo $iframe ?>;

        $(document).ready(function() {
            var listServers = $('#listServers');

            var ordenPersonalizado = ['yourupload', 'sw'];

            var servidores = videos.SUB;

            servidores.sort(function(a, b) {
                var indiceA = ordenPersonalizado.indexOf(a.title.toLowerCase());
                var indiceB = ordenPersonalizado.indexOf(b.title.toLowerCase());

                if (indiceA === -1) indiceA = Infinity;
                if (indiceB === -1) indiceB = Infinity;

                return indiceA - indiceB;
            });

            servidores.forEach(function(servidor) {
                var div = $('<div>').addClass('video-link');

                var boton = $('<div>').text(servidor.title).addClass('video-button btn btn-primary').click(function() {
                    var urlIncrustada = servidor.code || servidor.url;
                    $('#videoPlayer').attr('src', urlIncrustada);

                    if (servidor.ads === 1) {
                        $('.preventor').css('display', 'flex');
                    } else {
                        $('.preventor').css('display', 'none');
                    }
                });

                div.append(boton);
                listServers.append(div);
            });
            $(".hidePreventor").click(function() {
                $('.preventor').css('display', 'none');
            });
        });
    </script>
</body>


</html>