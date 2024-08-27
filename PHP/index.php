<?php
require_once 'conexionn.php';
session_start();


error_reporting(0)
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>index</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
        }

        .header a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .main-content {
            text-align: center;
            margin-top: 50px;
        }

        .category {
            margin-bottom: 40px;
        }

        .category h2 {
            text-align: left;
            margin-bottom: 20px;
        }

        .auction-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .auction-item {
            border: 1px solid #ddd;
            padding: 10px;
            width: calc(25% - 20px);
            box-sizing: border-box;
            position: relative;
        }

        .auction-item img {
            max-width: 100%;
            height: auto;
        }

        .more-link {
            text-align: right;
            margin-top: 10px;
        }

        .more-link a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }

        .more-link a:hover {
            text-decoration: underline;
        }
        #imagenHola {
            width: 500000%;
            object-fit: cover;       
            
         }
    </style>
</head>


<body class="sb-nav-fixed">

   <nav>
        <?php
        include ("header.php");
        ?>
    </nav>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../Imagenes/1.png" class="d-block w-100" alt="Slide 1" style="object-fit: cover; height: 600px;">
            <div class="carousel-caption top-0 mt-4">
                <h1 class="display fw-normal LetrasBanersParaTraducir">
                “¡Competencia y Compasión, todo lo que buscas en un solo lugar!”
                </h1>
                <p class="LetrasBanersParaTraducirDescripcion5">BIDDING SURE</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="../Imagenes/2.png" class="d-block w-100" alt="Slide 2" style="object-fit: cover; height: 600px;">
            <div class="carousel-caption top-0 mt-4">
                <h1 class="display fw-normal LetrasBanersParaTraducirEntretenimiento">
                Entretenimiento
                </h1>
                <p class="LetrasBanersParaTraducirDescripcion2">Coleccionismo - subasta</p>
                <p class="LetrasBanersParaTraducirDescripcion1">Figuras, consolas, accesorios coleccionables</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="../Imagenes/3.png" class="d-block w-100" alt="Slide 3" style="object-fit: cover; height: 600px;">
            <div class="carousel-caption top-0 mt-4">
                <h1 class="display fw-normal LetrasBanersParaTraducirModa">
                Moda Urbana
                </h1>
                <p class="LetrasBanersParaTraducirDescripcion4">coleccionismo - subasta</p>
                <p class="LetrasBanersParaTraducirDescripcion3">Zapatos, chaquetas, sudaderas, <br> gorra y mucho más</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

    <div class="container">
    <div class="main-content">
        <?php if (!isset($_SESSION['usuario'])) : ?>
        <?php endif; ?>

        <?php
        $categorias = ["Entretenimiento", "Moda Urbana"];

        foreach ($categorias as $categoria) :
            $query = "SELECT * FROM subastas WHERE categoria_producto='$categoria' LIMIT 10";
            $result = $conex->query($query);
        ?>
            <div class="category">
                <h2><?php echo $categoria; ?></h2>
                <div class="auction-grid row">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>

                            <!-- Tarjeta de Subasta -->
                            <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
    <div class="card border-0 rounded-0 shadow" style="width: 100%;">
        <div class="card-img-top rounded-0 overflow-hidden">
            <?php if ($row['imagen_producto']) : ?>
                <div id="carousel-<?php echo $row['id']; ?>" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <?php if ($row['imagen2']) : ?>
                        <button type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <?php endif; ?>
                        <?php if ($row['imagen3']) : ?>
                        <button type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <?php endif; ?>
                        <?php if ($row['imagen4']) : ?>
                        <button type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <?php endif; ?>
                        <?php if ($row['imagen5']) : ?>
                        <button type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide-to="4" aria-label="Slide 5"></button>
                        <?php endif; ?>
                    </div>
                    <div class="carousel-inner" style="height: 250px;">
                        <div class="carousel-item active">
                            <img src="data:<?php echo htmlspecialchars($row['tipo_mime']); ?>;base64,<?php echo base64_encode($row['imagen_producto']); ?>" class="d-block w-100 img-fluid" alt="Imagen del Producto" style="height: 250px; object-fit: cover;">
                        </div>
                        <?php if ($row['imagen2']) : ?>
                        <div class="carousel-item">
                            <img src="data:<?php echo htmlspecialchars($row['tipo_mime2']); ?>;base64,<?php echo base64_encode($row['imagen2']); ?>" class="d-block w-100 img-fluid" alt="Imagen del Producto" style="height: 250px; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                        <?php if ($row['imagen3']) : ?>
                        <div class="carousel-item">
                            <img src="data:<?php echo htmlspecialchars($row['tipo_mime3']); ?>;base64,<?php echo base64_encode($row['imagen3']); ?>" class="d-block w-100 img-fluid" alt="Imagen del Producto" style="height: 250px; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                        <?php if ($row['imagen4']) : ?>
                        <div class="carousel-item">
                            <img src="data:<?php echo htmlspecialchars($row['tipo_mime4']); ?>;base64,<?php echo base64_encode($row['imagen4']); ?>" class="d-block w-100 img-fluid" alt="Imagen del Producto" style="height: 250px; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                        <?php if ($row['imagen5']) : ?>
                        <div class="carousel-item">
                            <img src="data:<?php echo htmlspecialchars($row['tipo_mime5']); ?>;base64,<?php echo base64_encode($row['imagen5']); ?>" class="d-block w-100 img-fluid" alt="Imagen del Producto" style="height: 250px; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $row['id']; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body d-flex flex-column">
            <h5 class="mb-3"><?php echo htmlspecialchars($row['nombre_producto']); ?></h5>
            <p class="mb-1"><strong>Estado:</strong> <?php echo htmlspecialchars($row['estado_producto']); ?></p>
            <p class="mb-1"><strong>Precio Inicial:</strong> $<?php echo htmlspecialchars($row['min']); ?></p>
            <p class="mb-1"><strong>Precio máximo:</strong> $<?php echo htmlspecialchars($row['max']); ?></p>
            <h6 class="mb-3 mt-4">La puja finaliza en:</h6>
            <div id="contador-<?php echo $row['id']; ?>" class="mb-2"></div>
            <div id="mensaje-<?php echo $row['id']; ?>" class="mensaje mb-4"></div>

            <script>
                // Configurar fechas de inicio y fin
                const fechaInicio<?php echo $row['id']; ?> = new Date('<?php echo $row['fecha_hora_inicio']; ?>');
                const fechaFinal<?php echo $row['id']; ?> = new Date('<?php echo $row['fecha_hora_final']; ?>');
                let intervalo<?php echo $row['id']; ?>;

                function actualizarContador<?php echo $row['id']; ?>() {
                    const ahora = new Date();
                    
                    if (ahora >= fechaInicio<?php echo $row['id']; ?>) {
                        let diferencia = fechaFinal<?php echo $row['id']; ?> - ahora;

                        if (diferencia > 0) {
                            const segundos = Math.floor(diferencia / 1000) % 60;
                            const minutos = Math.floor(diferencia / (1000 * 60)) % 60;
                            const horas = Math.floor(diferencia / (1000 * 60 * 60)) % 24;
                            const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

                            document.getElementById('contador-<?php echo $row['id']; ?>').textContent = `${dias}d ${horas}h ${minutos}m ${segundos}s`;
                        } else {
                            clearInterval(intervalo<?php echo $row['id']; ?>);
                            document.getElementById('contador-<?php echo $row['id']; ?>').textContent = '';
                            document.getElementById('mensaje-<?php echo $row['id']; ?>').textContent = 'SUBASTA FINALIZADA';
                            document.getElementById('mensaje-<?php echo $row['id']; ?>').style.color = 'red';
                            document.getElementById('subasta-<?php echo $row['id']; ?>').style.display = 'none';
                        }
                    } else {
                        document.getElementById('contador-<?php echo $row['id']; ?>').textContent = 'La subasta aún no ha comenzado';
                        document.getElementById('mensaje-<?php echo $row['id']; ?>').textContent = '';
                    }
                }

                actualizarContador<?php echo $row['id']; ?>();
                intervalo<?php echo $row['id']; ?> = setInterval(actualizarContador<?php echo $row['id']; ?>, 1000);
            </script>

            <div class="mt-auto text-center">
                <a href="detalle_subasta.php?id=<?php echo $row['id']; ?>" class="btn w-100" style="background-color: #57070c; color: white;">Ver Subasta</a>
            </div>
        </div>
    </div>
</div>


                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No hay subastas disponibles en esta categoría.</p>
                    <?php endif; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="moda.php" class="btn btn-outline-dark">Ver más</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

   


    <!-- Scripts de boostrap y js -->
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

<?php
$conex->close();
?>
