<?php
include $_SERVER['DOCUMENT_ROOT'] . "/php/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

$anime_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Inicializar variables
$episodios = [];
$nombre_anime = '';
$año_anime = ''; // Variable para el año

// Obtener el nombre del anime y el año
if ($anime_id > 0) {
    // Obtener el nombre del anime y el año
    $stmt = $conn->prepare("SELECT nombre, YEAR(fecha) AS anio FROM anime WHERE id = ?");
    $stmt->bind_param("i", $anime_id);
    $stmt->execute();
    $stmt->bind_result($nombre_anime, $año_anime); // Asignar ambas variables
    $stmt->fetch();
    $stmt->close();


    // Obtener episodios
    $stmt = $conn->prepare("SELECT e.id, e.numero_episodio, e.iframe
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nombre_anime); ?> - Gestionar Capítulos</title> <!-- Título actualizado -->
    <?php echo $css ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    /* Elimina el estilo para el select ya que ya no se utiliza */
</style>

<body>
    <?php include "navbar2.php" ?>
    <div class="container mt-5">
        <h2 class="mb-4"><?php echo htmlspecialchars($nombre_anime) . " - " . $año_anime; ?></h1> <!-- Título de la página -->
            <div id="mensaje" class="alert" style="display: none;" role="alert"></div>
            <form id="editarAnimeForm" class="row g-3">
                <input type="hidden" id="anime_id" value="<?php echo $anime_id; ?>">
                <div id="capitulos">
                    <?php foreach ($episodios as $episodio): ?>
                        <div class="col-12 mb-3 capitulo-container">
                            <label>Capítulo <?php echo htmlspecialchars($episodio['numero_episodio']); ?></label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2 iframe-input" name="capitulo[<?php echo $episodio['id']; ?>][iframe]" value='<?php echo $episodio['iframe']; ?>' autocomplete="off">
                                <input type="hidden" name="capitulo[<?php echo $episodio['id']; ?>][numero]" value='<?php echo $episodio['numero_episodio']; ?>' class="numero-capitulo">
                                <button type="button" class="btn btn-danger eliminar-capitulo">Eliminar</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-12 mb-5">
                    <button type="button" id="agregarCapitulo" class="btn btn-primary">Agregar Capítulo</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
    </div>

    <script>
        $(document).ready(function() {
            let contadorCapitulos = <?php echo count($episodios); ?>;

            function renumerarCapitulos() {
                $('.capitulo-container').each(function(index) {
                    let nuevoNumero = index + 1;
                    $(this).find('label').text(`Capítulo ${nuevoNumero}`);
                    $(this).find('.numero-capitulo').val(nuevoNumero);
                });
                contadorCapitulos = $('.capitulo-container').length;
            }

            $('#agregarCapitulo').click(function() {
                contadorCapitulos++;
                let nuevoCapitulo = `
                    <div class="col-12 mb-3 capitulo-container">
                        <label>Capítulo ${contadorCapitulos}</label>
                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control me-2 iframe-input" name="capitulo[nuevo_${contadorCapitulos}][iframe]" autocomplete="off">
                            <input type="hidden" name="capitulo[nuevo_${contadorCapitulos}][numero]" value='${contadorCapitulos}' class="numero-capitulo">
                            <button type="button" class="btn btn-danger eliminar-capitulo">Eliminar</button>
                        </div>
                    </div>
                `;
                $('#capitulos').append(nuevoCapitulo);
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            });

            $(document).on('click', '.eliminar-capitulo', function() {
                $(this).closest('.capitulo-container').remove();
                renumerarCapitulos();
            });

            $('#editarAnimeForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('anime_id', $('#anime_id').val());
                formData.append('subircap', 'subircap');
                $.ajax({
                    url: '/admin/funciones/fun-ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let data = JSON.parse(response);
                        $('#mensaje').removeClass('alert-danger alert-success')
                            .addClass(data.success ? 'alert-success' : 'alert-danger')
                            .text(data.message).show();
                        setTimeout(function() {
                            $('#mensaje').css('display', 'none');
                        }, 3000);
                    },
                    error: function() {
                        $('#mensaje').removeClass('alert-success')
                            .addClass('alert-danger')
                            .text('Error al guardar los cambios').show();
                    }
                });
            });

        });
    </script>
</body>

</html>
<?php
$conn->close();
?>