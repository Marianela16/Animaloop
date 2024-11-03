<?php

$host = 'autorack.proxy.rlwy.net';
$port = '22439';
$dbname = 'railway';
$username = 'root';
$password = 'KCsgbSvvqIYrbLbPeLYpmoULtmMoonIy';

$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Listar tablas
    echo "<h2>Tablas en la base de datos '$dbname':</h2>";
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        echo "<h3>Tabla: $table</h3>";
        
        // Consultar datos de cada tabla
        $table_sql = "SELECT * FROM $table";
        $table_result = $conn->query($table_sql);

        if ($table_result->num_rows > 0) {
            echo "<table border='1'><tr>";
            // Obtener los nombres de las columnas
            while ($field_info = $table_result->fetch_field()) {
                echo "<th>{$field_info->name}</th>";
            }
            echo "</tr>";

            // Obtener los datos de cada fila
            while ($row = $table_result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No hay datos en la tabla $table.<br>";
        }
    }
} else {
    echo "No se encontraron tablas en la base de datos.";
}
$conn->close();
?>
