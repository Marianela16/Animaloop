<?php
require "../../config/config.php";
require('funciones.php');
$query = "SELECT anime.id, anime.nombre, anime.gen, anime.calif, anime.portada, anime.tendencia, anime.reciente, anime.proximo FROM anime";
$consulta = "SELECT anime.id, anime.nombre, anime.gen, anime.calif, anime.portada, anime.tendencia, anime.reciente, anime.proximo FROM anime";
$where = " WHERE anime.nombre";
$query = generarConsulta($query, $where, "1 ASC", "1");
$stmt = $conn->prepare($query);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$filtered_rows = count($resultado);
$resultado_paginado = array_slice($resultado, $_POST["start"], $_POST["length"]);

$datos = array();

foreach ($resultado_paginado as $fila) {
    $sub_array = array();
    $sub_array[] = $fila["id"];
    $sub_array[] = $fila["nombre"];
    $sub_array[] = $fila["gen"];
    $sub_array[] = $fila["calif"];
    $sub_array[] = $fila["portada"];
    $sub_array[] = $fila["tendencia"];
    $sub_array[] = $fila["reciente"];
    $sub_array[] = $fila["proximo"];
    $sub_array[] = '
    <button type="button" class="btn m-1 btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="valor_modal(' . $fila["id"] . ')"> Detalles </button>
    <a class="btn m-1 btn-success" href="capitulos.php?id=' . $fila["id"] . '">Capitulos</a>
    <a class="btn m-1 btn-dark" href="editar.php?id=' . $fila["id"] . '">Editar</a>
    <button type="button" class="btn m-1 btn-danger" onclick="el_anime(' . $fila["id"] . ', `' . $fila["nombre"] . '`)"> Eliminar </button>
    ';
    $datos[] = $sub_array;
}
$salida = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => obtenerNumeroRegistros($consulta),
    "recordsFiltered" => $filtered_rows,
    "query" => $query,
    "data" => $datos
);
// echo $query;
error_log("Query: " . print_r($query, true));
echo json_encode($salida);
