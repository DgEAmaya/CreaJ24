<?php
session_start();

require_once '../PHP/conexionn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
  // Consulta SQL para eliminar la subasta
  $sql_delete = "DELETE FROM subastas WHERE id=?";
  $stmt = $conex->prepare($sql_delete);
  $stmt->bind_param("i", $_GET['id']);

  if ($stmt->execute()) {
    // Redirige a la página de subastas con un mensaje de éxito
    header("Location: misSubastas.php?eliminado=true");
    exit();
  } else {
    echo "Error al eliminar la subasta: " . $stmt->error;
  }

  $stmt->close();
  $conex->close();
}
?>
