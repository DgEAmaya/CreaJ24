<?php
// Incluir el archivo de conexión a la base de datos
include('conexionn.php');

// Obtener los parámetros de la URL
$action = isset($_GET['action']) ? $_GET['action'] : null;
$idReceptor = isset($_GET['idReceptor']) ? $_GET['idReceptor'] : null;

if (!empty($action) && !empty($idReceptor)) {
    // Determinar la nueva información de estado
    if ($action == 'donar') {
        $nuevoEstado = 'Donado';
    } else {
        echo "Acción no válida.";
        exit();
    }
    
    // Actualizar el estado en la base de datos
    $sql = "UPDATE solicitardonacion SET estado = '$nuevoEstado' WHERE idReceptor = $idReceptor";
    if ($conex->query($sql) === TRUE) {
        // Redirigir al usuario a una página de confirmación
        if ($action == 'aceptar') {
            header("Location: acepta-dona.php");
         }
    } else {
        echo "Error al actualizar el estado de la solicitud: " . $conex->error;
    }
} else {
    echo "Acción o ID no especificado.";
}

// Cerrar la conexión a la base de datos
$conex->close();
?>
