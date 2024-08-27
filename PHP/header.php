<?php

require_once '../PHP/conexionn.php';
$id = $_SESSION['idCliente'];


if ((!$id == null)) {


    $sql = $conex->prepare("SELECT * FROM cliente WHERE PrimerNombre = ?");
    $sql->bind_param("s", $PrimerNombre);
    $sql->execute();
    $result = $sql->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['PrimerNombre'] ?? '';
        $foto = $row['foto'] ?? '';
    } else {
        $nombre = '';
        $foto = '';
    }

    $sql->close();
    include("Menulogueado.php");
} else {
    include("MenuDeslogueado.php");
}

?>
