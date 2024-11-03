<?php require 'php/head.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Anime web">
    <?php echo $css ?>
    <?php echo $css2 ?>
    <title>AnimaLoop</title>

    
    
</head>

<body>
    <!-- Área de encabezado Inicio -->
    <?php include 'php/navbar2.php'; ?>
    <!-- Fin del área de encabezado -->

    <!-- Inicio del contenedor principal -->
    <div id="main-wrapper" class="main-wrapper overflow-hidden">
        <div class="page-content">
            <!-- 404 Inicio del área -->
            <section class="block-404">
                <div class="container-fluid">
                    <div class="content">
                        <img src="assets/media/404.png" class="mb-32" alt="">
                        <h4 class="h-32 font-sec-2 bold mb-32">Página no encontrada</h4>
                        <a href="index.php" class="cus-btn primary mb-5">Volver a inicio</a>
                    </div>
                </div>
            </section>
            <!-- 404 Fin del área -->
        </div>
        <!-- Contenido principal Fin -->
    </div>

    <!-- Jquery JS -->
    <script src="assets/js/vendor/jquery-3.6.3.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="assets/js/vendor/slick.min.js"></script>
    <script src="assets/js/vendor/jquery-appear.js"></script>
    <script src="assets/js/vendor/jquery-validator.js"></script>
    <script src="assets/js/vendor/aksVideoPlayer.js"></script>

    <!-- Guiones del sitio -->
    <script src="assets/js/app.js"></script>
</body>

</html>