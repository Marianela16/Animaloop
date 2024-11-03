<?php require "../php/head.php";
date_default_timezone_set('America/Lima');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Anime</title>
    <?php echo $css ?>
    <?php echo $css2 ?>
    <?php echo $js ?>
</head>
<style>
    .form-check.form-flex {
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
    }

    input[type="checkbox"] {
        accent-color: #f5d049;
    }
</style>

<body>
    <?php include "navbar2.php" ?>
    <div class="container mt-5">
        <h1 class="mb-4">Subir Información de Anime</h1>
        <div id="mensaje" class="alert alert-info" style="display: none;" role="alert"></div>

        <form id="subirAnimeForm" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre del Anime:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required>
            </div>

            <div class="col-md-6">
                <label for="calif" class="form-label">Calificacion:</label>
                <input type="text" class="form-control" id="calif" name="calif" autocomplete="off" required>
            </div>

            <div class="col-6">
                <label for="fecha" class="form-label">Fecha:</label>
                <input class="form-control" type="date" id="fecha" name="fecha" autocomplete="off" required>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label">Descripción del Anime:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <div class="col-12">
                <label for="gen" class="form-label">Gereno input:</label>
                <input type="text" class="form-control" id="genreInput" name="gen" autocomplete="off" required>
            </div>
            <div class="col-12">
                <label for="generos" class="form-label">Géneros:</label><br>
                <div class="form-check form-flex genres-container">
                    <label class="genre"><input type="checkbox" value="Accion"> Accion</label>
                    <label class="genre"><input type="checkbox" value="Aventura"> Aventura</label>
                    <label class="genre"><input type="checkbox" value="Ciencia Ficcion"> Ciencia Ficcion</label>
                    <label class="genre"><input type="checkbox" value="Fantasia"> Fantasia</label>
                    <label class="genre"><input type="checkbox" value="Misterio"> Misterio</label>
                    <label class="genre"><input type="checkbox" value="Psicologico"> Psicologico</label>
                    <label class="genre"><input type="checkbox" value="Terror"> Terror</label>
                    <label class="genre"><input type="checkbox" value="Sobrenatural"> Sobrenatural</label>
                    <label class="genre"><input type="checkbox" value="Drama"> Drama</label>
                    <label class="genre"><input type="checkbox" value="Comedia"> Comedia</label>
                    <label class="genre"><input type="checkbox" value="Romance"> Romance</label>
                    <label class="genre"><input type="checkbox" value="Mecha"> Mecha</label>
                    <label class="genre"><input type="checkbox" value="Isekai"> Isekai</label>
                    <label class="genre"><input type="checkbox" value="Gore"> Gore</label>
                    <label class="genre"><input type="checkbox" value="Ecchi"> Ecchi</label>
                    <label class="genre"><input type="checkbox" value="Slice of Life"> Slice of Life</label>
                    <label class="genre"><input type="checkbox" value="Shonen"> Shonen</label>
                    <label class="genre"><input type="checkbox" value="Seinen"> Seinen</label>
                    <label class="genre"><input type="checkbox" value="Shojo"> Shojo</label>
                    <label class="genre"><input type="checkbox" value="Josei"> Josei</label>
                    <label class="genre"><input type="checkbox" value="Harem"> Harem</label>
                    <label class="genre"><input type="checkbox" value="Deporte"> Deporte</label>
                    <label class="genre"><input type="checkbox" value="Yuri"> Yuri</label>
                    <label class="genre"><input type="checkbox" value="Yaoi"> Yaoi</label>
                    <label class="genre"><input type="checkbox" value="Musical"> Musical</label>
                </div>
            </div>

            <div class="col-md-6">
                <label for="imagen_portada_vertical" class="form-label">Imagen Portada Vertical:</label>
                <input type="file" class="form-control imagen-input" id="imagen_portada_vertical" name="imagen_portada_vertical" accept="image/*">
            </div>

            <div class="col-md-6">
                <label for="imagen_portada_horizontal" class="form-label">Imagen Portada Horizontal:</label>
                <input type="file" class="form-control imagen-input" id="imagen_portada_horizontal" name="imagen_portada_horizontal" accept="image/*">
            </div>

            <div class="col-12">
                <label for="Opciones" class="form-label">Opciones:</label><br>
                <div class="form-check">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="portada" name="opciones[]" value="portada">
                        <label class="form-check-label" for="portada">Portada</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tendencia" name="opciones[]" value="tendencia">
                        <label class="form-check-label" for="tendencia">Tendencia</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="reciente" name="opciones[]" value="reciente">
                        <label class="form-check-label" for="reciente">Reciente</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proximo" name="opciones[]" value="proximo">
                        <label class="form-check-label" for="proximo">Próximo</label>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <input type="submit" value="Subir Anime" class="btn btn-primary mb-5">
            </div>
        </form>
    </div>
    <script>
        // Referencias a los elementos
        const genreInput = document.getElementById('genreInput');
        const checkboxes = document.querySelectorAll('.genre input[type="checkbox"]');

        // Mantener una lista de géneros seleccionados en el orden de selección
        let selectedGenres = [];

        // Función para actualizar el input basado en los checkboxes marcados
        function updateInputFromCheckboxes() {
            // Recorremos los checkboxes para ajustar la lista de géneros seleccionados
            checkboxes.forEach(checkbox => {
                if (checkbox.checked && !selectedGenres.includes(checkbox.value)) {
                    // Si está marcado y no está en la lista, lo añadimos
                    selectedGenres.push(checkbox.value);
                } else if (!checkbox.checked && selectedGenres.includes(checkbox.value)) {
                    // Si está desmarcado y está en la lista, lo eliminamos
                    selectedGenres = selectedGenres.filter(genre => genre !== checkbox.value);
                }
            });

            // Actualizamos el valor del input
            genreInput.value = selectedGenres.join(', ');
        }

        // Función para actualizar los checkboxes basado en el input
        function updateCheckboxesFromInput() {
            const inputGenres = genreInput.value.trim() ? genreInput.value.split(',').map(genre => genre.trim()) : [];

            // Actualizamos los checkboxes según lo que hay en el input
            checkboxes.forEach(checkbox => {
                checkbox.checked = inputGenres.includes(checkbox.value);
            });

            // También actualizamos la lista `selectedGenres` para reflejar el nuevo orden
            selectedGenres = inputGenres;
        }

        // Evento para cuando se marcan o desmarcan los checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateInputFromCheckboxes);
        });

        // Evento para cuando se edita el input manualmente
        genreInput.addEventListener('input', updateCheckboxesFromInput);

        // Inicialización: actualizar checkboxes basado en el valor inicial del input
        document.addEventListener('DOMContentLoaded', updateCheckboxesFromInput);
    </script>
    <script>
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                if (this.files.length > 1) {
                    alert('Solo puedes subir un archivo a la vez.');
                    this.value = ''; // Elimina el contenido del input
                }
            });
        });
        $(document).ready(function() {
            let processedImages = {};
            $('input[type="file"]').on('change', function(event) {
                const inputFile = this;
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.src = e.target.result;
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            const maxHeight = 600;
                            let finalImage;

                            if (img.height > maxHeight) {
                                const scaleFactor = maxHeight / img.height;
                                canvas.height = maxHeight;
                                canvas.width = img.width * scaleFactor;
                            } else {
                                canvas.height = img.height;
                                canvas.width = img.width;
                            }
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                            finalImage = canvas.toDataURL('image/webp', 0.5);
                            processedImages[inputFile.name] = finalImage;
                        };
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#subirAnimeForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('form_crear', 'crear');

                $('.imagen-input').each(function() {
                    const inputFile = this;
                    if (processedImages[inputFile.name]) {
                        const byteString = atob(processedImages[inputFile.name].split(',')[1]);
                        const mimeString = 'image/webp'; // Siempre será WebP
                        const buffer = new ArrayBuffer(byteString.length);
                        const data = new Uint8Array(buffer);
                        for (let i = 0; i < byteString.length; i++) {
                            data[i] = byteString.charCodeAt(i);
                        }
                        const blob = new Blob([buffer], {
                            type: mimeString
                        });

                        const randomName = 'imagen_' + Math.random().toString(36).substring(2, 15) + '.webp';

                        formData.delete(inputFile.name);
                        formData.append(inputFile.name, blob, randomName);
                    }
                });

                $.ajax({
                    url: './funciones/fun-ajax.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#mensaje').html(response);
                        $('#mensaje').css('display', 'block');
                        setTimeout(function() {
                            $('#mensaje').css('display', 'none');
                        }, 3000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
</body>

</html>