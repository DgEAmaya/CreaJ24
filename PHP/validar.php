<?php
$email=$_POST['email'];
$clave=$_POST['clave'];

//conectar a la base de datos 
$conexion=mysqli_connect("localhost","root","root","biddingsure");
session_start();
$_SESSION['email'] =$email;
$consulta= "SELECT * FROM cliente WHERE email='$email' and contraseña='$clave'";
$resultado= mysqli_query($conexion,$consulta);

$filas=mysqli_num_rows($resultado);
if($filas>0)  {
    ?>
    <script>alert("Ha iniciado sesion")</script>
    <?php
    header("location:index.php");

}
else{
    header("location:InicioSesion.php");
}
mysqli_free_result($resultado);
mysqli_close($conexion);


?>