<?php

    include("conexionn.php");
    $id = $_GET['idCliente'];
    $eliminar = "DELETE FROM cliente WHERE idCliente='$id'";
    $resultado = $conex->query($eliminar);
    if ($resultado) {
    echo '<script>alert("Usuario eliminado con exito")</script>';
    header("Location:usuarios.php");
    }

?>