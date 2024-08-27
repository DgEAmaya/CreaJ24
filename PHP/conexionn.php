<?php
// Database credentials
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "biddingsure";

// Create connection
$conex = mysqli_connect($hostname, $username, $password, $database);

$myconn = new mysqli($hostname, $username, $password, $database);
if ($myconn->connect_error) {
    die("Error de conexión: " . $myconn->connect_error);
}


// Check connection
if (!$conex) {
    die("Connection failed: " . mysqli_connect_error());
}

class DB_CONNECT {
    var $myconn;

    /**
     * Funcion para conectar a la base de datos
     */
    function connect() {
        global $hostname, $username, $password, $database;
        
        // Conectar a la base de datos mySQL
        $this->myconn = mysqli_connect($hostname, $username, $password, $database);

        if (!$this->myconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

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
