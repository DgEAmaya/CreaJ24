<?php
session_start();
require_once '../PHP/conexionn.php';

// Verificar si el usuario ha iniciado sesión
if (!($_SESSION == null)){
    @$PrimerNombre = $_SESSION['cliente']['PrimerNombre'];
    @$PrimerApellido = $_SESSION['cliente']['PrimerApellido'];
    @$email = $_SESSION['cliente']['email'];
    // consulta para que se muestre el usuario en el header
    $sql=$conex->query("select * from cliente where PrimerNombre='$PrimerNombre'");
    $row = $sql->fetch_assoc();
    @$nombre = $row['PrimerNombre'];
    @$foto = $row['foto'];

    $mensajeBienvenida = "Bienvenido, $nombre";
   
} else {
    echo "<script>
        alert('Debes registrarte o iniciar sesión para ver los detalles de la subasta.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

// Inicializar variables
$nombre_producto = $tamano_producto = $color_producto = $telefono = $categoria_producto = "";
$estado_producto = $tiempo_subasta = $cantidad_inicial = $imagen_producto = "";

// Validar y obtener detalles de la subasta según el ID recibido por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM subastas WHERE id = ?";
    $stmt = $conex->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_producto = $row['nombre_producto'];
        $descripcion = $row['descripcion'];
        $tamano_producto = $row['tamano_producto'];
        $color_producto = $row['color_producto'];
        $telefono = $row['telefono'];
        $categoria_producto = $row['categoria_producto'];
        $estado_producto = $row['estado_producto'];
        $tiempo_subasta = $row['tiempo_subasta'];
        $cantidad_inicial = $row['cantidad_inicial'];
        $imagen_producto = $row['imagen_producto'];
        $tipo_mime = $row['tipo_mime'];
        $idCreador = $row['usuario'];

        $imagen2 = $row['imagen2'];
        $tipo_mime2 = $row['tipo_mime2'];
        $imagen3 = $row['imagen3'];
        $tipo_mime3 = $row['tipo_mime3'];
        $imagen4 = $row['imagen4'];
        $tipo_mime4 = $row['tipo_mime4'];
        $imagen5 = $row['imagen5'];
        $tipo_mime5 = $row['tipo_mime5'];
        @$sesion = $_SESSION['$email'];
        $resultado = $conex->query("SELECT * FROM cliente where PrimerNombre= '$sesion'");
        while ($rowNuevo = $resultado->fetch_array()) {
            $idUsuario = $rowNuevo['id'];
        }
    } else {
        echo "<script>
            alert('No se encontraron detalles para la subasta seleccionada.');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('ID de subasta inválido.');
        window.location.href = 'index.php';
    </script>";
    exit();
}
// establecer la variable del id del usuario 
$idCliente = $_SESSION['idCliente'];
$conex->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Subasta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .carousel-item img {
            width: 100%;
            height: 400px;

        }
        
        .contador {
            font-size: 1.5rem;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <nav>
        <?php include ("Menulogueado.php"); ?>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4 text-center">Detalles de la Subasta</h1>
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <!-- Carrusel de imágenes -->
                            <div id="carouselExampleControls" class="carousel slide">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="data:<?php echo $tipo_mime; ?>;base64,<?php echo base64_encode($imagen_producto); ?>" class="d-block w-100 h-100 img-fluid" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="data:<?php echo $tipo_mime2; ?>;base64,<?php echo base64_encode($imagen2); ?>" class="d-block w-100 h-100 img-fluid" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="data:<?php echo $tipo_mime3; ?>;base64,<?php echo base64_encode($imagen3); ?>" class="d-block w-100 h-100 img-fluid" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="data:<?php echo $tipo_mime4; ?>;base64,<?php echo base64_encode($imagen4); ?>" class="d-block w-100 h-100 img-fluid" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="data:<?php echo $tipo_mime5; ?>;base64,<?php echo base64_encode($imagen5); ?>" class="d-block w-100 h-100 img-fluid" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                                    </div>
                                </div>
                                <!-- Botones de navegación (flechas) -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                <!-- Indicadores -->
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="background-color: black;"></button>
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="1" aria-label="Slide 2" style="background-color: black;"></button>
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="2" aria-label="Slide 3" style="background-color: black;"></button>
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="3" aria-label="Slide 4" style="background-color: black;"></button>
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="4" aria-label="Slide 5" style="background-color: black;"></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($nombre_producto); ?></h5>
                                <h4>Descripción:</h4>
                                <p class="card-text"><?php echo htmlspecialchars($descripcion); ?></p>
                                <p class="card-text"><strong>Tamaño del Producto:</strong> <?php echo htmlspecialchars($tamano_producto); ?></p>
                                <p class="card-text fs-5"><strong>Color del Producto:</strong>
                                    <span style="display: inline-block; width: 30px; height: 30px; background-color: <?php echo htmlspecialchars($color_producto); ?>; border: 2px solid #000; border-radius: 50%;"></span>
                                </p>
                                <p class="card-text"><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                                <p class="card-text"><strong>Categoría del Producto:</strong> <?php echo htmlspecialchars($categoria_producto); ?></p>
                                <p class="card-text"><strong>Estado del Producto:</strong> <?php echo htmlspecialchars($estado_producto); ?></p>
                                <h4 class="mt-4 mb-2 text-dark">La puja finaliza en:</h4>
                                <div id="contador-<?php echo $row['id']; ?>" class="contador fs-5">
                                    <span id="dias-<?php echo $row['id']; ?>"></span>
                                    <span id="horas-<?php echo $row['id']; ?>"></span>
                                    <span id="minutos-<?php echo $row['id']; ?>"></span>
                                    <span id="segundos-<?php echo $row['id']; ?>"></span>
                                </div>
                                <div id="mensaje-<?php echo $row['id']; ?>" class="mensaje mt-2"></div>
                                <script>
                                    const fechaFinal<?php echo $row['id']; ?> = new Date('<?php echo $row['tiempo_subasta']; ?>');
                                    let intervalo<?php echo $row['id']; ?>;

                                    function actualizarContador<?php echo $row['id']; ?>() {
                                        const ahora = new Date();
                                        let diferencia = fechaFinal<?php echo $row['id']; ?> - ahora;

                                        if (diferencia > 0) {
                                            const segundos = Math.floor(diferencia / 1000) % 60;
                                            const minutos = Math.floor(diferencia / (1000 * 60)) % 60;
                                            const horas = Math.floor(diferencia / (1000 * 60 * 60)) % 24;
                                            const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

                                            document.getElementById('dias-<?php echo $row['id']; ?>').textContent = dias + ' días ';
                                            document.getElementById('horas-<?php echo $row['id']; ?>').textContent = horas + ' horas ';
                                            document.getElementById('minutos-<?php echo $row['id']; ?>').textContent = minutos + ' minutos ';
                                            document.getElementById('segundos-<?php echo $row['id']; ?>').textContent = segundos + ' segundos ';
                                            document.getElementById('mensaje-<?php echo $row['id']; ?>').textContent = '';
                                            document.getElementById('mensaje-<?php echo $row['id']; ?>').style.color = '';
                                        } else {
                                            clearInterval(intervalo<?php echo $row['id']; ?>);
                                            document.getElementById('contador-<?php echo $row['id']; ?>').style.display = 'none';
                                            document.getElementById('mensaje-<?php echo $row['id']; ?>').textContent = 'SUBASTA FINALIZADA';
                                            document.getElementById('mensaje-<?php echo $row['id']; ?>').style.color = 'red';

                                            // Ocultar la tarjeta de la subasta cuando el tiempo haya terminado
                                            document.getElementById('subasta-<?php echo $row['id']; ?>').style.display = 'none';
                                        }
                                    }

                                    actualizarContador<?php echo $row['id']; ?>();
                                    intervalo<?php echo $row['id']; ?> = setInterval(actualizarContador<?php echo $row['id']; ?>, 1000);
                                </script>
                                <p class="card-text"><strong>Cantidad Inicial de la Subasta:</strong> <?php echo htmlspecialchars($cantidad_inicial); ?></p>

                                <?php if ($idCliente == $idCreador) : ?>
                                    <a href="editar_subasta.php?id=<?php echo $id; ?>" class="btn btn-custom" style="background: #57070c; color: #fff"><i class="fa-solid fa-edit"></i> Editar Subasta</a>
                                    <form action="eliminar_subasta.php?id=<?php echo $id; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta subasta?');" class="d-inline">
                                        <button type="submit" class="btn btn-custom" style="background: #57070c; color: #fff"><i class="fa-solid fa-trash"></i> Eliminar Subasta</button>
                                    </form>
                                <?php else : ?>
                                    <p>No tienes permiso para editar o eliminar esta subasta.</p>
                                <?php endif; ?>

                                <a href="misSubastas.php" class="btn btn-custom" style="background: #57070c; color: #fff"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
</body>

<footer>
    <?php include ('footer.php'); ?>
</footer>

</html>
