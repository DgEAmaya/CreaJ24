<?php
session_start();
require_once 'conexionn.php';

if (isset($_POST['password'])) {
    $idCliente = $_SESSION['idCliente'];
    $password = $_POST['password'];

    // Consulta para obtener la contraseña actual del usuario
    $query = $conex->query("SELECT contraseña FROM cliente WHERE idCliente='$idCliente'");
    $row = $query->fetch_assoc();
    $hashedPassword = $row['contraseña'];

    // Verificar la contraseña ingresada
    if (password_verify($password, $hashedPassword)) {
        // Eliminar la cuenta
        $deleteQuery = $conex->query("DELETE FROM cliente WHERE idCliente='$idCliente'");
        
        if ($deleteQuery) {
            // Destruir la sesión y redirigir a la página de inicio
            session_destroy();
            echo "<script>
                    alert('Cuenta eliminada correctamente.');
                    window.location.href = 'index.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hubo un error al eliminar la cuenta.');
                    window.location.href = 'perfil-actualizar.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Contraseña incorrecta. No se pudo eliminar la cuenta.');
                window.location.href = 'perfil-actualizar.php';
            </script>";
    }
} else {
    header("Location: perfil.php");
    exit();
}
exit();
?>