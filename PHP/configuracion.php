<?php


function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}


/**
 * Clase para conectar a la base de datos 
 */
class DB_CONNECT {
    
    var $myconn;
  
    /**
     * Funcion para conectar a la base de datos
     */
    function connect() {
        // importar las variables de conexion a la base de datos
        require_once __DIR__ . '/conexionn.php';

        // Conectar a la base de datos mySQL
        $con = mysqli_connect($hostname, $username, $password, $database) or die(mysqli_error($con));
        $this->myconn = $con;

        // devuelve el cursor de conexion
        return $this->myconn;
    }

    /**
     * Funcion para cerrar la conexion a la base de datos
     */
    function close() {
        // cerrando la conexion
        mysqli_close($this->myconn);
    }

}

?>