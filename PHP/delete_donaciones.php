<?php

    include("conexionn.php");
    $idReceptor = $_GET['idReceptor'];
    $eliminar = "DELETE FROM solicitardonacion WHERE idReceptor='$idReceptor'";
    $resultado = $conex->query($eliminar);
    if ($resultado) {
    echo '<script>alert("Usuario eliminado con exito")</script>';
    header("Location:DonacionesSolicitadas.php");
    }else{
        echo '<script>alert("error al eliminar el dato")</script>';
    }

?>