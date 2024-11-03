<?php require 'php/head.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Anime web">
    <title>AnimaLoop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php echo $css ?>
    <?php echo $css2 ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<style>
    .size {
        position: fixed;
        display: none;
        right: 0;
        background-color: red;
        z-index: 9999999999999999999;
        font-size: 3rem;
    }
</style>

<body>
    <!--Área de encabezado Inicio-->
    <?php include 'php/navbar2.php'; ?>
    <!--Fin del área de encabezado-->

    <!--Inicio del contenedor principal-->
    <div class="size"></div>
    <div class="main-wrapper overflow-hidden" id="main-wrapper">

        <!-- @c-red SLIDER-->
        <section class="banner style-1 banner-slider">
            <div class="swiper SwiperBanner">
                <div class="swiper-wrapper">
                    <?php
                    require "config/config.php";
                    $sql = "SELECT * FROM anime";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $animes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    foreach ($animes as $anime) {
                        $img_hv = !empty($anime['imagen_portada_horizontal']) ? $anime['imagen_portada_horizontal'] : $anime['imagen_portada_vertical'];
                        $img_vh = !empty($anime['imagen_portada_vertical']) ? $anime['imagen_portada_vertical'] : $anime['imagen_portada_horizontal'];
                        if ($anime['portada'] == 1) {
                    ?>
                            <div class="swiper-slide banner-block overflow-hidden style-1 position-relative">
                                <div class="bg-anime" style="background: url(<?php echo $webhost . $img_hv ?>); background-repeat: no-repeat; background-size: cover; background-position: center;"></div>
                                <div class="container">
                                    <div class="banner-content">
                                        <div class="row">
                                            <div class="col-lg col-12">
                                                <h2 class="title anime-nombre"><?php echo $anime['nombre']; ?></h2>
                                                <div class="mb-4 etiq">
                                                    <?php
                                                    $etiquetas_all = explode(',', $anime['gen']);
                                                    $etiquetas = array_slice($etiquetas_all, 0, 4);
                                                    foreach ($etiquetas as $etiqueta) {
                                                        $etiqueta = trim($etiqueta);
                                                        echo '<a href="streaming-season.html" class="btn btn-primary  fw-bold">' . $etiqueta . '</a> ';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="anime-descrip mt-1"><?php echo $anime['descripcion']; ?></div>
                                                <a class="anime-play play-butn sdw-5" href="#">VER AHORA</a>
                                            </div>
                                            <div class="col-lg-auto col-12">
                                                <img class="banner-img" src="<?php echo $webhost . $img_vh ?>" class="d-block w-100" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="sw-btn swiper-button-p"><i class="fa-solid fa-chevron-left"></i></div>
                <div class="sw-btn swiper-button-n"><i class="fa-solid fa-chevron-right"></i></div>
            </div>
        </section>


        <div class="page-content">
            <!-- @c-red GENEROS -->


            <!-- @c-red TENDENCIA -->
            <section class="cont-tendencia animes p-40">
                <div class="container">
                    <div class="d-flex justify-content-between mb-30 position-relative">
                        <h2 class="fw-bold f-24">Animes en tendencia</h2>
                        <div class="cont-btn">
                            <div class="sw-btn swiper-button-p"><i class="fa-solid fa-caret-left"></i></div>
                            <div class="ms-4 sw-btn swiper-button-n"><i class="fa-solid fa-caret-right"></i></div>
                        </div>
                    </div>
                    <div class="swiper tendencia">
                        <div class="swiper-wrapper">
                            <?php
                            // ordena por nombre
                            usort($animes, function ($a, $b) {
                                return strcmp($a['nombre'], $b['nombre']);
                            });
                            foreach ($animes as $anime) {
                                if ($anime['tendencia'] == 1) {
                                    $fecha = $anime['fecha'];
                                    $year = (new DateTime($fecha))->format('Y');
                            ?>
                                    <div class="swiper-slide card st-2">
                                        <div class="tarjeta-contenedor mb-12">
                                            <div class="tarjeta">
                                                <div class="cara frente">
                                                    <img src="<?php echo $webhost . $anime['imagen_portada_vertical']; ?>" alt="">
                                                </div>
                                                <div class="cara atras">
                                                    <div>
                                                        <h3><?php echo $anime['nombre']; ?></h3>
                                                        <div class="fecha-calif">
                                                            <div><?php echo $year; ?></div>
                                                            <div><i class="fa-solid fa-star"></i><?php echo $anime['calif']; ?></div>
                                                        </div>
                                                        <div class="generos">
                                                            <?php echo  $anime['gen']; ?>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-primary play" href="/detalle.php?anime=<?php echo $anime['nombre'] ?>"><i class="fa-solid fa-play"></i> Ver ahora</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="animeName text-white bold"><?php echo $anime['nombre'] ?></h4>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- TENDECIA FIN -->

            <!-- @c-red CONTINUAR VIENDO -->
            <section class="animes">
                <div class="container">
                    <div class="heading mb-30">
                        <h2 class="f-28 fw-bold">Lista de Animes</h2>
                        <a class="light-btn primary sdw-5" href="anime-listing.php">Ver todo<i class="fa fa-chevron-right"></i></a>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($animes as $anime) {
                            $img_hv = !empty($anime['imagen_portada_horizontal']) ? $anime['imagen_portada_horizontal'] : $anime['imagen_portada_vertical'];
                            $img_vh = !empty($anime['imagen_portada_vertical']) ? $anime['imagen_portada_vertical'] : $anime['imagen_portada_horizontal'];

                            $genero = isset($etiquetas[0]) ? trim($etiquetas[0]) : '';
                            $anio = isset($etiquetas[1]) ? trim($etiquetas[1]) : '';
                            $episodios = isset($etiquetas[2]) ? 'EP - ' . trim($etiquetas[2]) : '';
                            $calificacion = isset($etiquetas[3]) ? trim($etiquetas[3]) : '';
                            $fecha = $anime['fecha'];
                            $year = (new DateTime($fecha))->format('Y');
                        ?>
                            <div class="col-lg-2-4 col-md-3 col-sm-4 col-6">
                                <div class="item mb-40">
                                    <div class="card st-2 p-0 m-0">
                                        <div class="tarjeta-contenedor mb-12">
                                            <div class="tarjeta">
                                                <div class="cara frente">
                                                    <img src="<?php echo $webhost . $anime['imagen_portada_vertical']; ?>" alt="">
                                                </div>
                                                <div class="cara atras">
                                                    <div>
                                                        <h3><?php echo $anime['nombre']; ?></h3>
                                                        <div class="fecha-calif">
                                                            <div><?php echo $year; ?></div>
                                                            <div><i class="fa-solid fa-star"></i><?php echo $anime['calif']; ?></div>
                                                        </div>
                                                        <div class="generos">
                                                            <?php echo  $anime['gen']; ?>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-primary play" href="/detalle.php?anime=<?php echo $anime['nombre'] ?>"><i class="fa-solid fa-play"></i> Ver ahora</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="animeName text-white bold"><?php echo $anime['nombre'] ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <!--Próximamente Área de inicio-->
            <section class="comming-soon mt-4">
                <div class="container">
                    <div class="content">
                        <img alt="" src="assets/media/comming-soon/image.png" />
                        <div class="details">
                            <h4 class="h-20 bold text-primary mb-8">¡Muy pronto!</h4>
                            <ul class="timer countdown unstyled data-timer1">
                                <li>365<small>Días</small></li>
                                <li>24<small>Horas</small></li>
                                <li>60<small>Mínimo</small></li>
                                <li>60<small>Segundo</small></li>
                            </ul>
                            <h2 class="f-28 fw-bold text-white mb-12">Chainsawman</h2>
                            <p class="color-medium-gray mb-24">El cliente está muy contento de que lo sigan. Un poco más que un ullamcorper<br />almohada Los tintoreros del gato son también dos ollas para gatos. La decoración de la vida en la cama grande.</p>
                            <ul class="tag unstyled mb-24">
                                <li>Acción</li>
                                <li>2021</li>
                                <li>EP-24</li>
                                <li class="icon"><i class="fas fa-star"></i></li>
                                <li>8.5</li>
                            </ul>
                            <h4 class="h-20 bold text-white mb-16 mt-4">Personajes</h4>
                            <ul class="name unstyled mb-40">
                                <li>huyendo</li>
                                <li>Valioso</li>
                                <li>En la práctica</li>
                                <li>Fuerza</li>
                                <li>himen</li>
                                <li>Aki Hayakawa</li>
                            </ul>
                            <a class="cus-btn primary mt-4" data-bs-target="#videoModal" data-bs-toggle="modal" href="#"><i class="fa fa-play"></i>Ver tráiler</a>
                            <!-- <button class="btn btn-primary  br-12 btn-p px-4 py-2 f-24 sdw-5" data-bs-target="#videoModal" data-bs-toggle="modal"><i class="fa fa-play"></i>Ver tráiler</button> -->
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!--Área de inicio del pie de página-->
        <?php include "php/footter.php"; ?>

    </div>
    <!--Jquery JS-->
    <script src="assets/js/vendor/jquery-3.6.3.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="assets/js/vendor/jquery.countdown.min.js"></script>
    <script src="assets/js/vendor/slick.min.js"></script>
    <script src="assets/js/vendor/jquery-appear.js"></script>
    <script src="assets/js/vendor/jquery-validator.js"></script>
    <script src="assets/js/vendor/aksVideoPlayer.js"></script>
    <!--Guiones del sitio-->
    <script src="assets/js/app.js"></script>
    <script>
        var swiper1 = new Swiper(".SwiperBanner", {
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".SwiperBanner .swiper-button-n",
                prevEl: ".SwiperBanner .swiper-button-p",
            },
        });
    </script>
    <script>
        var swiper = new Swiper(".tendencia", {
            slidesPerView: 2,

            loop: true,
            autoplay: {
                delay: 7000,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: ".cont-tendencia .swiper-button-n",
                prevEl: ".cont-tendencia .swiper-button-p",
            },
            breakpoints: {
                576: {
                    loop: true,
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            },
        });
        swiper.el.addEventListener('mouseenter', function() {
            swiper.autoplay.stop();
        });
        swiper.el.addEventListener('mouseleave', function() {
            swiper.autoplay.start();
        });
    </script>
</body>


</html>