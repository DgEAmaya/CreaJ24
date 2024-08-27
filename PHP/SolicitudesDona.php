<?php
session_start(); // Inicia la sesión

require_once '../PHP/conexionn.php';

if (!$conex) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['idCliente'])) {
    echo "
    <script>
      alert('Debes iniciar sesión para enviar solicitudes.');
      window.location.href = 'InicioSesion.php';
    </script>";
    exit();
}

$userID = $_SESSION['idCliente'];
$sql = "SELECT PrimerNombre, PrimerApellido, email, direccion, telefono FROM cliente WHERE idCliente = ?";
$stmt = $conex->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conex));
}

$user = $result->fetch_assoc();

if (!$userID) {
    die("Usuario No Encontrado");
}

if (isset($_POST['BtnSolicitar'])) {
    $nombreReceptor = trim($_POST['nombreReceptor']);
    $apellidoReceptor = trim($_POST['apellidoReceptor']);
    $emailReceptor = trim($_POST['emailReceptor']);
    $ubiReceptor = trim($_POST['ubiReceptor']);
    $telefonoReceptor = trim($_POST['telefonoReceptor']);
    $categoriaReceptor = trim($_POST['categoriaReceptor']);
    $productoReceptor = trim($_POST['productoReceptor']);
    $cantidadReceptor = trim($_POST['cantidadReceptor']);

    $sql = "INSERT INTO solicitardonacion (nomReceptor, emailReceptor, direccionReceptora, telReceptor, CategoriaReceptor, producSolicitar, cantSolicitar, estado, donado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pendiente', 'No')";
    $stmt = $conex->prepare($sql);
    $stmt->bind_param("sssssss", $nombreReceptor, $emailReceptor, $ubiReceptor, $telefonoReceptor, $categoriaReceptor, $productoReceptor, $cantidadReceptor);

    if ($stmt->execute()) {
        echo '<script>alert("Su solicitud ha sido enviada")</script>';
    } else {
        echo '<script>alert("Error en el envío de su solicitud: ' . $stmt->error . '")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Donación</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/cssdepura.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .form-container {
            display: flex;
            justify-content: space-between;
        }
        .form-container .form-column {
            flex: 1;
            margin-right: 20px;
        }
        .form-container .image-column {
            flex: 0.6;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .image-column img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="sb-nav-fixed">

    <nav>
        <?php include ("header.php"); ?>
    </nav>

    <div id="layoutSidenav_content">
        <img src="../Imagenes/5.png" width="100%" class="img-fluid max-width: 100%;" alt="imgDonaciones">  
        <main class="contaiiner">
        <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header text-center" style="background-color: #57070C;">
                            <h4 class="text-white">Solicitar Donaciones</h4>
                        </div>
                        <div class="card-body p-5 form-container">
                            <div class="form-column">
                            <p class="mb-4 text-center fw-bold text-body" style="font-size: 1.25rem;">Datos del Solicitante</p>
                            <form action="" method="post" onsubmit="return validateForm()">
                                    <div class="mb-3">
                                        <label for="nombreReceptor" class="form-label">Nombre</label>
                                        <input type="text" id="nombreReceptor" class="form-control" name="nombreReceptor" value="<?php echo htmlspecialchars($user['PrimerNombre']); ?>" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidoReceptor" class="form-label">Apellido</label>
                                        <input type="text" id="apellidoReceptor" class="form-control" name="apellidoReceptor" value="<?php echo htmlspecialchars($user['PrimerApellido']); ?>" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailReceptor" class="form-label">Correo Electrónico</label>
                                        <input type="email" id="emailReceptor" class="form-control" name="emailReceptor" value="<?php echo htmlspecialchars($user['email']); ?>" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ubiReceptor" class="form-label">Dirección</label>
                                        <input type="text" id="ubiReceptor" class="form-control" name="ubiReceptor" value="<?php echo htmlspecialchars($user['direccion']); ?>" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefonoReceptor" class="form-label">Teléfono</label>
                                        <input type="tel" id="telefonoReceptor" class="form-control" name="telefonoReceptor" value="<?php echo htmlspecialchars($user['telefono']); ?>" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoriaReceptor" class="form-label">Categoría de Donación</label>
                                        <select id="categoriaReceptor" class="form-select" name="categoriaReceptor" required>
                                            <option value="Entretenimiento">Entretenimiento</option>
                                            <option value="Moda">Moda</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productoReceptor" class="form-label">Producto</label>
                                        <input type="text" id="productoReceptor" class="form-control" name="productoReceptor" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cantidadReceptor" class="form-label">Cantidad</label>
                                        <input type="number" id="cantidadReceptor" class="form-control" name="cantidadReceptor" required>
                                    </div>
                                    <button type="submit" name="BtnSolicitar" class="btn" style="background-color: #57070C; color: white; width: 20%; padding: 8px 10px; margin-left: 400px; margin-top: 20px;">Enviar Solicitud</button>
                                    </form>
                            </div>
                            <div class="image-column">
                                <img src="../Imagenes/file.png" alt="Imagen de Donación">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
    function validateForm() {
        var nombre = document.getElementById("nombreReceptor").value.trim();
        var apellido = document.getElementById("apellidoReceptor").value.trim();
        var email = document.getElementById("emailReceptor").value.trim();
        var direccion = document.getElementById("ubiReceptor").value.trim();
        var telefono = document.getElementById("telefonoReceptor").value.trim();
        var categoria = document.getElementById("categoriaReceptor").value;
        var producto = document.getElementById("productoReceptor").value.trim();
        var cantidad = document.getElementById("cantidadReceptor").value;

        if (nombre === "" || apellido === "" || email === "" || direccion === "" || telefono === "" || producto === "" || cantidad === "") {
            alert("Por favor, complete todos los campos.");
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert("Por favor, ingrese un correo electrónico válido.");
            return false;
        }
        if (isNaN(cantidad) || cantidad <= 0) {
            alert("Por favor, ingrese una cantidad válida.");
            return false;
        }
        return true;
    }
</script>

    <footer>
        <?php include ('footer.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/mood_oscuro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
