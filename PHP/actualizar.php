<?php
session_start();
require_once '../PHP/conexionn.php';

// Obtener el ID del usuario desde la URL (GET)
$idCliente = $_GET["idCliente"];

// Verificar si se envió el formulario
if (isset($_POST['registro'])) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    
    // Verificar si se subió una foto
    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $query_foto = ", foto='$foto'";
    } else {
        $query_foto = "";
    }

    // Verificar si se ingresó una nueva contraseña
    if (!empty($pass)) {
        // Actualizar nombre de usuario, correo y contraseña
        $sql = "UPDATE usuarios SET nombre_usuario=?, correo=?, contrasena=? $query_foto WHERE id=?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $pass, $usuario_id);
    } else {
        // Actualizar nombre de usuario y correo sin cambiar la contraseña
        $sql = "UPDATE usuarios SET nombre_usuario=?, correo=? $query_foto WHERE id=?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $usuario_id);
    }

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado con éxito')</script>";
    } else {
        echo "<script>alert('Error al actualizar usuario')</script>";
    }

    // Redirigir a la página de perfil después de la actualización
    header('location: perfil.php');
    exit;
} else {
    // Si no se envió el formulario, redirigir a otra página o mostrar un mensaje de error
    header('location: error.php');
    exit;
}
?>
