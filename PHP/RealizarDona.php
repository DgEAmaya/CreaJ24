<?php
session_start(); // Inicia la sesión

require_once '../PHP/conexionn.php';

if (!$conex) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['idCliente'])) {
    echo "
    <script>
      alert('Debes iniciar sesión para realizar donaciones.');
      window.location.href = 'InicioSesion.php';
    </script>";
    exit();
  }

$userID = $_SESSION['idCliente'];

$emailQuery = "SELECT email FROM cliente WHERE idCliente = '$userID'";
$emailResult = mysqli_query($conex, $emailQuery);

if ($emailResult === false) {
    $errorMessage = "Error en la consulta del email: " . mysqli_error($conex);
} else {
    $userEmail = mysqli_fetch_assoc($emailResult)['email'];
}

if (isset($_POST['donar_id'])) {
    $idReceptor = mysqli_real_escape_string($conex, $_POST['donar_id']);

    $sqlUpdate = "UPDATE solicitardonacion SET Donado = 'Sí' WHERE idReceptor = '$idReceptor'";

    if (mysqli_query($conex, $sqlUpdate)) {
        $successMessage = "Donación realizada con éxito.";
    } else {
        $errorMessage = "Error al actualizar la solicitud de donación: " . mysqli_error($conex);
    }
    exit();
}
$sql = "SELECT * FROM solicitardonacion WHERE estado = 'Aprobado' AND Donado = 'No' AND emailReceptor != '$userEmail'";
$result = mysqli_query($conex, $sql);

if ($result === false) {
    $errorMessage = "Error en la consulta: " . mysqli_error($conex);
} else {
    $donaciones = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $donaciones[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Donación</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .table th, .table td {
            text-align: center;
        }
        .table th {
            background-color: #57070c;
            color: white;
        }
        .table td {
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #57070c;
            border: none;
            border-radius: 0.25rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="sb-nav-fixed">

    <nav>
        <?php include("header.php"); ?>
    </nav>

    <div class="conntainer-fluid mt-0">
        <img src="../Imagenes/RealizaDona.png" class="img-fluid" alt="Imagen Donaciones">
    </div>

    <div class="coontainer mt-4">
        <!-- Contenedor para mensajes de éxito o error -->
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Dirección de Envío</th>
                            <th>Teléfono</th>
                            <th>Categoría</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($donaciones) && !empty($donaciones)): ?>
                            <?php foreach ($donaciones as $donacion): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($donacion['idReceptor']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['nomReceptor']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['emailReceptor']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['direccionReceptora']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['telReceptor']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['CategoriaReceptor']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['producSolicitar']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['cantSolicitar']); ?></td>
                                    <td><?php echo htmlspecialchars($donacion['estado']); ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="donar_id" value="<?php echo htmlspecialchars($donacion['idReceptor']); ?>">
                                            <button type="submit" class="btn btn-primary" name="Btn-donar">Donar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No hay solicitudes de donaciones disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form button[type="submit"]').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const idReceptor = this.closest('form').querySelector('input[name="donar_id"]').value;

                    if (confirm('¿Estás seguro de que quieres realizar esta donación?')) {
                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                'donar_id': idReceptor
                            })
                        }).then(response => response.text()).then(data => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/subidaArchivos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<footer>
    <?php include('footer.php'); ?>
</footer>
</html>
