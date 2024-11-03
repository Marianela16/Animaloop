<?php
function obtenerNumeroRegistros($consulta)
{
    require "../../config/config.php";

    try {
        $stmt = $conn->query($consulta);
    
        if ($stmt === false) {
            throw new Exception("Error en la consulta: " . $conn->error);
        }
    
        $numero_registros = $stmt->num_rows;
        return $numero_registros;
    } catch (Exception $e) {
        die("Error en la consulta: " . $e->getMessage());
    } finally {
        $conn->close();
    }
    
}

function generarConsulta($query, $where, $otro_orden, $fila)
{
    $busqueda = $_POST["search"]["value"];
    // Aplicar filtros de búsqueda si se proporcionan
    if (isset($busqueda)) {
        $input_value = $busqueda;
        // Separar las partes de la cadena ingresada
        $parts = explode(' ', $input_value);
        // Construir el patrón para la consulta SQL
        $pattern = '';
        if (strpos($input_value, ' ') !== false) {
            // Si hay espacios, separamos las partes y construimos el patrón
            $parts = explode(' ', $input_value);
            $pattern = '';
            foreach ($parts as $part) {
                $pattern .= '%' . $part . '%';
            }
        } else {
            $pattern = '%' . $input_value . '%';
        }
        $query .= $where;
        $query .= " LIKE '%" . $pattern . "%' OR anime.id LIKE '%" . $pattern . "%' OR anime.nombre LIKE '%" . $pattern . "%' OR anime.gen LIKE '%" . $pattern . "%' ";
    }
    // Ordenar resultados si se especifica
    if (isset($_POST["order"])) {
        $column_index = $_POST['order']['0']['column'];
        // Ajusta el índice de la columna para que coincida con el índice esperado en tu consulta SQL
        $column_index_adjusted = $column_index + $fila;
        $query .= ' ORDER BY ' . $column_index_adjusted . ' ' . $_POST["order"][0]['dir'];
    } else {
        $query .= ' ORDER BY ' . $otro_orden . ' ';
    }

    return $query;
}
