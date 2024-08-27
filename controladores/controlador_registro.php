<?php

if (!empty($_POST["Btn-Ingresar"] )) {
    if (empty($_POST["nombre"]) or empty($_POST["email"]) or empty($_POST["ubi"]) or empty($_POST["telefono"]) or empty($_POST["dui"]) or empty($_POST["tarjeta"]) or empty($_POST["clave"])) {
        echo "Campos vacios";
    }else {
        $nombre=$_POST["nombre"];
        $email=$_POST["email"];
        $ubi=$_POST["ubi"];
        $telefono=$_POST["telefono"];
        $dui=$_POST["dui"];
        $tarjeta=$_POST["tarjeta"];
        $clave=$_POST["clave"];
        $sql = $con -> query("insert into cliente (nombre, email, dui, direccion, tarjetaCredito, telefono, contraseña) values ('$nombre','$email','$ubi','$telefono','$dui','$tarjeta','$clave')");
        if ($sql==1){
            echo "Usuario Registrado Correctamente";
        }else{
            echo "Error al registrarse";
        }

    }

}

?>