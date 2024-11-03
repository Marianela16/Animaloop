<?php
// guardar_episodios.php

include $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

// Obtener el ID del anime
$anime_id = isset($_POST['anime_id']) ? intval($_POST['anime_id']) : 0;

if ($anime_id <= 0) {
    die(json_encode(['success' => false, 'message' => "ID de anime inválido"]));
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Obtener los episodios existentes
    $stmt = $conn->prepare("SELECT id FROM episodios WHERE anime_id = ?");
    $stmt->bind_param("i", $anime_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $episodios_existentes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $ids_existentes = array_column($episodios_existentes, 'id');
    $ids_actualizados = [];

    // Procesar los episodios enviados
    foreach ($_POST['capitulo'] as $id => $episodio) {
        $numero = intval($episodio['numero']);
        $iframe = $conn->real_escape_string($episodio['iframe']);

        if (strpos($id, 'nuevo_') === 0) {
            // Insertar nuevo episodio
            $stmt = $conn->prepare("INSERT INTO episodios (anime_id, numero_episodio, iframe) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $anime_id, $numero, $iframe);
        } else {
            // Actualizar episodio existente
            $id = intval($id);
            $stmt = $conn->prepare("UPDATE episodios SET numero_episodio = ?, iframe = ? WHERE id = ? AND anime_id = ?");
            $stmt->bind_param("isii", $numero, $iframe, $id, $anime_id);
            $ids_actualizados[] = $id;
        }

        $stmt->execute();
        $stmt->close();
    }

    // Eliminar episodios que ya no existen
    $ids_a_eliminar = array_diff($ids_existentes, $ids_actualizados);
    if (!empty($ids_a_eliminar)) {
        $ids_string = implode(',', $ids_a_eliminar);
        $conn->query("DELETE FROM episodios WHERE id IN ($ids_string) AND anime_id = $anime_id");
    }

    // Commit de la transacción
    $conn->commit();

    echo json_encode(['success' => true, 'message' => "Episodios guardados correctamente"]);
} catch (Exception $e) {
    // Rollback en caso de error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => "Error al guardar los episodios: " . $e->getMessage()]);
}

// Cerrar la conexión
$conn->close();
?>
