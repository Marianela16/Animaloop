<?php
require 'php/head.php';
require 'config/config.php';
$nombre_anime = isset($_GET['anime']) ? $_GET['anime'] : '';
$nombre_anime = str_replace('_', ' ', $nombre_anime);
if (!empty($nombre_anime)) {
    // Paso 1: Obtener el ID del anime basado en el nombre
    $stmt = $conn->prepare("SELECT * FROM anime WHERE nombre = ?");
    $stmt->bind_param("s", $nombre_anime); // 's' indica que es un string
    $stmt->execute();
    $result = $stmt->get_result();
    $anime = $result->fetch_assoc(); // Obtener datos como un array asociativo
    $stmt->close();

    // Si se encontró un ID válido para el anime, se procede a la segunda consulta
    if ($anime && isset($anime['id']) && $anime['id'] > 0) {
        $anime_id = $anime['id'];
        $año_anime = $anime['fecha'] ? date('Y', strtotime($anime['fecha'])) : null; // Extraer año de fecha

        // Paso 2: Obtener los episodios usando el ID del anime obtenido anteriormente
        $stmt = $conn->prepare("SELECT e.id, e.numero_episodio FROM episodios e
                                WHERE e.anime_id = ?
                                ORDER BY e.numero_episodio");
        $stmt->bind_param("i", $anime_id); // 'i' indica que es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        $episodios = $result->fetch_all(MYSQLI_ASSOC);
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
        <section class="img-h">
            <img src="<?php echo $webhost . $anime["imagen_portada_horizontal"]; ?>" alt="">
            <div class="bg-transparente"></div>
        </section>
        <section class="detalle-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-auto col-12">
                        <div class="img-v">
                            <img src="<?php echo $webhost . $anime["imagen_portada_vertical"] ?>" alt="">
                            <div class="btns-sm">
                                <div class="btn play"><i class="fa-solid fa-play"></i>Ver Ahora</div>
                                <div class="btn fav"><i class="fa-solid fa-heart"></i></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div>
                                <div class="anime-prop">Fecha</div>
                                <div class="anime-det"><?php echo $anime["fecha"]; ?></div>
                            </div>
                            <div>
                                <div class="anime-prop">Capítulos</div>
                                <div class="anime-caps"></div>
                            </div>
                            <div>
                                <div class="anime-prop">Calificación</div>
                                <div class="anime-det"><?php echo $anime["calif"]; ?></div>
                            </div>
                            <div>
                                <div class="anime-prop">Genero</div>
                                <div class="anime-det">
                                    <?php
                                    $etiquetas_all = explode(',', $anime['gen']);
                                    $etiquetas = array_slice($etiquetas_all, 0, 4);
                                    foreach ($etiquetas as $etiqueta) {
                                        $etiqueta = trim($etiqueta);
                                    ?>
                                        <div><?php echo $etiqueta; ?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div class="anime-prop">Estación</div>
                                <div class="anime-estacion"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="anime-titulo">
                            <div class="anime-nombre mb-4">
                                <div class=""><?php echo $nombre_anime ?></div>
                                <div class="calif"><?php echo $anime["calif"]; ?><i class="fa-solid fa-star"></i></div>
                            </div>
                            <div>
                                <?php
                                $etiquetas_all = explode(',', $anime['gen']);
                                $etiquetas = array_slice($etiquetas_all, 0, 4);
                                foreach ($etiquetas as $etiqueta) {
                                    $etiqueta = trim($etiqueta);
                                    echo '<a href="streaming-season.html" class="btn btn-primary  fw-bold">' . $etiqueta . '</a> ';
                                }
                                ?>
                            </div>
                            <div>
                                <?php echo $anime["descripcion"] ?>
                            </div>
                        </div>
                        <div class="anime-episodios">
                            <div>Lista de episodios</div>
                            <div class="lista">
                                <?php foreach ($episodios as $episodio) {
                                ?>
                                    <div class="episodio">
                                        <i class="fa-solid fa-circle-play"></i>
                                        <a href="/ver.php?anime=<?php echo $nombre_anime ?>&episodio=<?php echo $episodio['numero_episodio']; ?>">Episodio <?php echo $episodio['numero_episodio']; ?></a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <?php include "php/footter.php"; ?>
    </div>

    <script src="/assets/js/vendor/jquery-3.6.3.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        function obtenerEstacion(fecha) {
            const date = new Date(fecha);
            const dia = date.getDate();
            const mes = date.getMonth() + 1; // Los meses en JavaScript son de 0 a 11.

            if ((mes === 12 && dia >= 21) || (mes <= 3 && (mes !== 3 || dia < 20))) {
                return "Invierno";
            } else if ((mes === 3 && dia >= 20) || (mes <= 6 && (mes !== 6 || dia < 21))) {
                return "Primavera";
            } else if ((mes === 6 && dia >= 21) || (mes <= 9 && (mes !== 9 || dia < 23))) {
                return "Verano";
            } else if ((mes === 9 && dia >= 23) || (mes <= 12 && (mes !== 12 || dia < 21))) {
                return "Otoño";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Obtenemos la fecha desde PHP
            const fecha = "<?php echo $anime['fecha']; ?>";
            const estacion = obtenerEstacion(fecha);

            // Insertamos el resultado de la estación en el elemento correspondiente
            const estacionElemento = document.querySelector('.anime-estacion');
            if (estacionElemento) {
                estacionElemento.textContent = estacion;
            }

            // Contamos los elementos con la clase "episodio" dentro de ".lista"
            const episodios = document.querySelectorAll('.lista .episodio');
            const totalCaps = episodios.length;

            // Insertamos el total de capítulos en el elemento correspondiente
            const capsElemento = document.querySelector('.anime-caps');
            if (capsElemento) {
                capsElemento.textContent = totalCaps;
            }
        });
    </script>
</body>


</html>