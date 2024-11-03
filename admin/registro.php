<?php require "../php/head.php" ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de anime</title>
    <?php echo $cssdt; ?>
    <style>
        td>* {
            color: black;
            text-decoration: none
        }
    </style>
    <style id='customStyle'></style>
</head>
<body class="body">
    <?php include "navbar2.php" ?>
    <div class="container-sm py-4 ">
        <div class="cont_white">
            <h1 class="text-center py-4">Registro de anime</h1>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <!-- Button trigger modal -->
                        <a href="subir_anime.php" type="button" class="btn btn-dark float-end" id=btn_ag>
                            Agregar
                        </a>
                    </div>
                </div>
            </div>
            <div class="breakpoint">
                <table id="tablaUsuarios" class="table display responsive" width="100%">
                    <thead>
                        <tr>
                            <!-- <th class="never">ID Pedido</th> -->
                            <th class="not-mobile">ID</th>
                            <th class="">Nombre</th>
                            <th>Genero</th>
                            <th>Calificacion</th>
                            <th>Portada</th>
                            <th>Tendencia</th>
                            <th>Reciente</th>
                            <th>Proximo</th>
                            <th class="none">Accion</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="probando" class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="" id="redirect" type="button" class="btn btn-dark">Editar</a>
                </div>
            </div>
        </div>
    </div>

    <?php echo $js; ?>
    <?php echo $jsdt; ?>
    <script>
        var storedFontSize = localStorage.getItem('fontSize');
        if (storedFontSize) {
            document.getElementById('customStyle').textContent = ":root, [data-bs-theme='light'] { --bs-body-font-size: " + storedFontSize + " !important; }";
        }

        function valor_modal(id_modal) {
            $('#probando').html("Cargando...");
            console.log(id_modal);
            var parametros = {
                "id_modal": id_modal,
            };
            $.ajax({
                data: parametros,
                url: './funciones/fun-ajax.php',
                type: 'POST',
                success: function(mensaje) {
                    $('#probando').html(mensaje);
                    var urlEditar = 'editar.php?id=' + id_modal;
                    $('#redirect').attr('href', urlEditar);
                }
            });
        };
        $(document).ready(function() {
            var dataTable = $('#tablaUsuarios').DataTable({
                paging: true,
                responsive: true,
                language: {
                    url: '../config/Es.json',
                },
                "serverSide": true,
                autoWidth: false,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "./funciones/require-dt.php",
                    type: "POST",
                },
                "lengthMenu": [2, 5, 10],
                "pageLength": 10,
                columnDefs: [{
                    type: 'string',
                    targets: '_all'
                }]
            });

            // Evento para controlar el expandir y colapsar las filas
            $('#tablaUsuarios').on('click', 'tr td.dtr-control', function() {
                var tr = $(this).closest('tr');
                var row = dataTable.row(tr);

                // Si la fila clickeada está expandida, colapsarla
                if (!row.child.isShown()) {
                    row.child.hide();
                    console.log("xd");
                    tr.removeClass('dtr-expanded');
                } else {
                    // Cerrar todas las filas expandidas
                    dataTable.rows().every(function() {
                        if (this.child.isShown()) {
                            console.log("xd2");
                            this.child.hide();
                            $(this.node()).removeClass('dtr-expanded');
                        }
                    });

                    // Expandir la fila clickeada
                    row.child.show();
                    console.log("xd4");
                    tr.addClass('dtr-expanded');
                }
            });


            $(window).on('resize', function() {
                dataTable.columns.adjust().responsive.recalc();
            });
        });


        function el_anime(id, nombre) {
            var parametros = {
                "nm_el": nombre,
                "id_el": id,
            };
            if (confirm("¿Eliminar pedido de " + nombre + "?")) {
                $.ajax({
                    data: parametros,
                    url: './funciones/fun-ajax.php',
                    type: 'POST',
                    success: function(mensaje) {
                        $('#tablaUsuarios').DataTable().ajax.reload();
                        console.log(mensaje);
                    }
                });
            } else {
                return false;
            }
        }
    </script>

</body>

</html>