<?php require 'php/head.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Anime web">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php echo $css ?>
    <?php echo $css2 ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <title>AnimaLoop</title>


</head>

<body>
    <!-- Inicio del área de encabezado -->
    <?php include 'php/navbar2.php'; ?>

    <!-- Inicio del contenedor principal -->
    <div id="main-wrapper" class="main-wrapper overflow-hidden">

        <!-- @c-red Filtros -->
        <section class="listing-filter p-40">
            <div class="container">
                <form id="GEN" method="get" class="d-flex align-items-center">

                    <!-- Dropdown para géneros -->
                    <div class="cont-filter">
                        <div class="mb-2">Generos</div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownGeneros" data-bs-toggle="dropdown" aria-expanded="false">
                                Todo
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownGeneros">
                                <li><label class="dropdown-item"><input type="checkbox" class="genero form-check-input" value="accion"> Acción</label></li>
                                <li><label class="dropdown-item"><input type="checkbox" class="genero form-check-input" value="aventura"> Aventura</label></li>
                                <li><label class="dropdown-item"><input type="checkbox" class="genero form-check-input" value="comedia"> Comedia</label></li>
                            </ul>
                        </div>
                        <?php 
                        if (isset($_GET['search'])){
                            echo '<input type="hidden" name="search" id="search" value="'.$_GET['search'].'">';
                        }
                        ?>
                        <input type="hidden" name="generos" id="generos">
                    </div>


                    <!-- Input oculto para los géneros seleccionados -->

                    <!-- Select de fecha -->
                    <div class="cont-filter">
                        <div class="mb-2">Fecha</div>
                        <select class="form-select me-2 custom-select" name="fecha" aria-label="Selecciona fecha">
                            <option selected value="">Todo</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2019">2019</option>
                            <option value="2013">2013</option>
                        </select>
                    </div>

                    <!-- Select de orden -->
                    <div class="cont-filter">
                        <div class="mb-2">Ordenar por</div>
                        <select class="form-select me-2 custom-select" name="orderby" aria-label="Ordenar por">
                            <option selected value="">Todo</option>
                            <option value="calif">Calificación</option>
                            <option value="fecha">Fecha</option>
                            <option value="id">ID</option>
                        </select>
                    </div>

                    <!-- Botón de submit -->
                    <button type="submit" id="subir" class="btn cont-filter align-self-end"><i class="fa-solid fa-filter"></i> Filtrar</button>
                </form>
            </div>
        </section>
        <section class="animes pb-0">
            <div class="container">
                <div id="content-container" class="row">

                </div>
            </div>
        </section>
        <section class="pagination-cont p-40 pt-2">
            <div id="pagination-container"></div>
        </section>


        <!-- Inicio del área de pie de página -->
        <?php include "php/footter.php"; ?>
    </div>

    <!-- jquery js -->
    <script src="assets/js/vendor/jquery-3.6.3.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="assets/js/vendor/slick.min.js"></script>
    <script src="assets/js/vendor/jquery-appear.js"></script>
    <script src="assets/js/vendor/jquery-validator.js"></script>
    <script src="assets/js/vendor/aksVideoPlayer.js"></script>
    <script>
        document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
            dropdown.addEventListener('click', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') {
                    e.stopPropagation();
                }
            });
        });
    </script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            function cargarPagina(page = 1) {
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', page);

                $.ajax({
                    url: '/admin/funciones/fun-ajax.php',
                    method: 'post',
                    data: urlParams.toString(),
                    dataType: 'json',
                    success: function(response) {
                        $('#content-container').html(response.content);
                        $('#pagination-container').html(response.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    }
                });
            }

            function inicializarFormulario() {
                const urlParams = new URLSearchParams(window.location.search);
                const generosSeleccionados = urlParams.get('generos') ? urlParams.get('generos').split(',') : [];

                $('input.genero').prop('checked', false);
                generosSeleccionados.forEach(genero => {
                    $(`input.genero[value="${genero}"]`).prop('checked', true);
                });

                $('select[name="fecha"]').val(urlParams.get('fecha') || '');
                $('select[name="orderby"]').val(urlParams.get('orderby') || '');
            }

            $('#subir').on('click', function(e) {
                const generosSeleccionados = $('input.genero:checked').map(function() {
                    return $(this).val();
                }).get().join(',');
                $('#generos').val(generosSeleccionados);
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                cargarPagina($(this).data('page'));
            });

            function createCustomSelect($select) {
                const $wrapper = $('<div>').addClass('custom-select-wrapper');
                const $selected = $('<div>').addClass('custom-select-selected btn btn-secondary dropdown-toggle');
                const $optionsList = $('<div>').addClass('custom-select-options');

                function updateSelectedText() {
                    $selected.text($select.find('option:selected').text());
                }

                updateSelectedText();

                $select.find('option').each(function() {
                    const $option = $(this);
                    const $optionElement = $('<div>')
                        .addClass('custom-select-option')
                        .text($option.text())
                        .data('value', $option.val())
                        .on('click', function() {
                            $select.val($(this).data('value')).trigger('change');
                            $optionsList.hide();
                        });
                    $optionsList.append($optionElement);
                });

                $wrapper.append($selected, $optionsList);
                $select.after($wrapper).hide();

                $selected.on('click', function() {
                    $optionsList.toggle();
                });

                $(document).on('click', function(e) {
                    if (!$wrapper[0].contains(e.target)) {
                        $optionsList.hide();
                    }
                });

                $select.on('change', updateSelectedText);
            }

            function createCustomSelects() {
                $('select.custom-select').each(function() {
                    createCustomSelect($(this));
                });
            }

            inicializarFormulario();
            createCustomSelects();
            cargarPagina();
        });
    </script>
</body>


</html>