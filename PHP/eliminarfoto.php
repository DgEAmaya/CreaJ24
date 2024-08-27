<?php
include("conexionn.php");
$id = $_GET['idCliente'];
echo $id;
$delete = $conex->query("UPDATE cliente set foto=null where idCliente='$id'");
// despues de hacer el update y quitar la foto, hacer la actualizacion y despues llevar a la pagina otra vez
header("Location:perfil-actualizar.php");