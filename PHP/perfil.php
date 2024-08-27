<?php
session_start();

require_once '../PHP/conexionn.php';
$id = $_SESSION['idCliente'];
if (!($_SESSION == null)) {
    // Consulta para que se muestre el usuario en el header
    $sql = $conex->query("SELECT * FROM cliente WHERE idCliente='$id '");
    $row = $sql->fetch_assoc();
    $nombre = $row['PrimerNombre'];
    @$foto = $row['foto'];
    $direccion = $row['direccion'];
    $telefono = $row['telefono'];
    $dui = $row['dui'];
    $PrimerNombre1 = $row['PrimerNombre'];
    $SegundoNombre1 = $row['SegundoNombre'];
    $PrimerApellido1 = $row['PrimerApellido'];
    $SegundoApellido1 = $row['SegundoApellido'];
} else {
    echo "<script>
        alert('Debes registrarte o iniciar sesión para ver los detalles del Articulo.');
        window.location.href = 'index.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
    <?php include("Menulogueado.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6 col-12 text-center mb-4">
                <?php if ($foto == null) { ?>
                    <img src="https://cdn-icons-png.flaticon.com/512/552/552721.png" class="rounded-circle img-thumbnail" alt="User Image" style="width: 400px; height: 400px;">
                <?php } else { ?>
                    <img src="data:image/jpg;base64,<?php echo base64_encode($foto); ?>" class="rounded-circle img-thumbnail" alt="User Image" style="width: 400px; height: 400px; object-fit: cover;">
                <?php } ?>
            </div>
            <div class="col-lg-8 col-md-6 col-12">
                <div class="card shadow-sm border-2" style="border-color: #57070c;">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Perfil de Usuario</h4>
                        <div class="mb-3">
                            <label for="PrimerNombre" class="form-label fw-bold">Primer Nombre</label>
                            <p id="PrimerNombre" class="form-control border-1" style="border-color: #57070c;"><?php echo $PrimerNombre1; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="SegundoNombre" class="form-label fw-bold">Segundo Nombre</label>
                            <p id="SegundoNombre" class="form-control border-1" style="border-color: #57070c;"><?php echo $SegundoNombre1; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="PrimerApellido" class="form-label fw-bold">Primer Apellido</label>
                            <p id="PrimerApellido" class="form-control border-1" style="border-color: #57070c;"><?php echo $PrimerApellido1; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="SegundoApellido" class="form-label fw-bold">Segundo Apellido</label>
                            <p id="SegundoApellido" class="form-control border-1" style="border-color: #57070c;"><?php echo $SegundoApellido1; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="Correo" class="form-label fw-bold">Correo</label>
                            <p id="Correo" class="form-control border-1" style="border-color: #57070c;"><?php echo $email; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="Direccion" class="form-label fw-bold">Domicilio</label>
                            <p id="Direccion" class="form-control border-1" style="border-color: #57070c;"><?php echo $direccion; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="Telefono" class="form-label fw-bold">Número Telefónico</label>
                            <p id="Telefono" class="form-control border-1" style="border-color: #57070c;"><?php echo $telefono; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="Dui" class="form-label fw-bold">DUI o Pasaporte</label>
                            <p id="Dui" class="form-control border-1" style="border-color: #57070c;"><?php echo $dui; ?></p>
                        </div>
                        <a href="perfil-actualizar.php" class="btn btn-block text-white d-block mx-auto" style="background-color: #57070c; max-width: 200px;">
                            <i class="fas fa-edit"></i> Cambiar Datos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <?php include ('footer.php'); ?>
</footer>

</html>
