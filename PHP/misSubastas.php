<?php
session_start();
require_once '../PHP/conexionn.php';
$id = $_SESSION['idCliente'];
// Asegúrate de que $bd esté correctamente definida
$bd = new mysqli('localhost', 'root', 'root', 'biddingsure');
if (!isset($_SESSION["idCliente"])) {
    die("La variable de sesión 'idCliente' no está definida.");
} else {
    echo "idCliente: " . $_SESSION["idCliente"];
}


// Verifica la conexión
if ($bd->connect_error) {
    die("Connection failed: " . $bd->connect_error);
}

// Función para ejecutar la consulta y manejar errores
function ejecutarConsulta($bd, $query) {
    $result = $bd->query($query);
    if (!$result) {
        die("Error en la consulta SQL: " . $bd->error);
    }
    return $result;
}
// Count para productos en mi cesta
$res_count = ejecutarConsulta($bd, "SELECT count(*) as total FROM subastas WHERE postor = $id");
$data = mysqli_fetch_array($res_count);
$count_cesta = $data['total']; // Total de productos en cesta

// Count para las subastas propias activas
$res_count = ejecutarConsulta($bd, "SELECT count(*) as total FROM subastas WHERE estado=0 AND creador='$id'");
$data = mysqli_fetch_array($res_count);
$count_sub_act = $data['total']; // Total de subastas propias activas

// Count para las subastas propias cerradas
$res_count = ejecutarConsulta($bd, "SELECT count(*) as total FROM subastas WHERE estado=1 AND creador=".$_SESSION["idCliente"]);
$data = mysqli_fetch_array($res_count);
$count_sub_cerr = $data['total']; // Total de subastas propias cerradas
?>

<!DOCTYPE html>
<html lang="es">

<head>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Subastas</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
</head>

<body class="sb-nav-fixed">
    <nav>
        <?php include('Menulogueado.php'); ?>
    </nav>

    <style>
        .imagenes {
            height: 40px;
            width: 40px;
            margin-right: 5px;
        }

        .card-body h3 {
            margin-top: 10px;
            font-size: 2rem;
        }

        .card-body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 30px;
        }

        .card-title {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
    </style>

<div class="container mt-5">
    <h1 class="mb-5 text-center">Mis Subastas</h1>
    <div class="row text-center">
        <!-- Card 1: Subastas Ganadas -->
        <!-- Card 1: Mis Subastas Ganadas -->
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card shadow-sm" style="border-color: #28a745;">
        <div class="card-body bg-success text-white d-flex flex-column align-items-center">
            <i class="fas fa-trophy fa-3x mb-3"></i>
            <h5 class="card-title">Mis Subastas Ganadas</h5>
            <h3 class="display-4"><?php echo $count_cesta; ?></h3>
        </div>
        <div class="card-footer bg-light">
            <a href="cesta.php" class="btn btn-outline-success btn-block d-flex align-items-center justify-content-between">
                <span>Ver detalles</span>
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Card 2: Mis Subastas Activas -->
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card shadow-sm" style="border-color: #57070c;">
        <div class="card-body text-white d-flex flex-column align-items-center" style="background-color: #57070c;">
            <i class="fas fa-clock fa-3x mb-3"></i>
            <h5 class="card-title">Mis Subastas Activas</h5>
            <h3 class="display-4"><?php echo $count_sub_act; ?></h3>
        </div>
        <div class="card-footer bg-light">
            <a href="cuenta1.php" class="btn btn-outline-dark btn-block d-flex align-items-center justify-content-between" style="border-color: #57070c; color: #57070c;">
                <span>Ver detalles</span>
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Card 3: Mis Subastas Cerradas -->
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card shadow-sm" style="border-color: #000000;">
        <div class="card-body bg-dark text-white d-flex flex-column align-items-center">
            <i class="fas fa-lock fa-3x mb-3"></i>
            <h5 class="card-title">Mis Subastas Cerradas</h5>
            <h3 class="display-4"><?php echo $count_sub_cerr; ?></h3>
        </div>
        <div class="card-footer bg-light">
            <a href="cuenta2.php" class="btn btn-outline-dark btn-block d-flex align-items-center justify-content-between">
                <span>Ver detalles</span>
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

    </div>
</div>


    <!-- Scripts de JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

<footer>
    <?php include('footer.php'); ?>
</footer>

</html>
