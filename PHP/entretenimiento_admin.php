<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entretenimiento</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="sb-nav-fixed">

  <nav>
    <?php
      include ('menuAdmin.php');
    ?>
  </nav>

 <!-- aqui termina el menu -->

 <!-- Imagen Entretenimiento -->
 <img src="../Imagenes/2.png" width="100%"  class="img-fluid max-width: 100%;" alt="imgDonaciones">  

 <!-- <div class="image-container">
  <img src="../Imagenes/Entretenimiento.png.png" class="full-page-image" alt="imgEntretenimiento">
</div> -->
<!-- Productos -->
 <section>
  <div class="container">
      <div class="top-bar">
        <h2 class="Entrete">
          Artículos en Subasta
        </h2>
      </div>
      <div id="Subastas">  
      </div>
  </div>
  <script src="script.js"></script>
</section>
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

<div class="container">
    <div class="main-content">
        <?php if (!isset($_SESSION['usuario'])) : ?>
        <?php endif; ?>

        <?php
        $categorias = ["Entretenimiento"]; // Ajusta las categorías según tu base de datos

        foreach ($categorias as $categoria) :
            $query = "SELECT * FROM subastas WHERE categoria_producto='Entretenimiento' LIMIT 4"; // Ajusta la consulta según tu base de datos
            $result = $conex->query($query);
        ?>
            <div class="category">
                <h2><?php echo $categoria; ?></h2>
                <div class="auction-grid">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>

                           <!-- Inicio de card -->
                           <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                            <div class="card border-2 rounded-3 shadow" style="width: 100%;">
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
                                    <p class="mb-1"><strong>Precio actual:</strong> $<?php echo htmlspecialchars($row['precio_actual']); ?></p>
                                    <h6 class="mb-3 mt-4">La puja finaliza en:</h6>
                                    <div id="contador-<?php echo $row['id']; ?>" class="mb-2"></div>
                                    <div id="mensaje-<?php echo $row['id']; ?>" class="mensaje mb-4"></div>

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

                                                document.getElementById('contador-<?php echo $row['id']; ?>').textContent = `${dias}d ${horas}h ${minutos}m ${segundos}s`;
                                            } else {
                                                clearInterval(intervalo<?php echo $row['id']; ?>);
                                                document.getElementById('contador-<?php echo $row['id']; ?>').textContent = '';
                                                document.getElementById('mensaje-<?php echo $row['id']; ?>').textContent = 'SUBASTA FINALIZADA';
                                                document.getElementById('mensaje-<?php echo $row['id']; ?>').style.color = 'red';
                                                document.getElementById('subasta-<?php echo $row['id']; ?>').style.display = 'none';
                                            }
                                        }

                                        actualizarContador<?php echo $row['id']; ?>();
                                        intervalo<?php echo $row['id']; ?> = setInterval(actualizarContador<?php echo $row['id']; ?>, 1000);
                                    </script>

                                    <div class="mt-auto text-center">
                                        <a href="detalles_subastasAdmin.php?id=<?php echo $row['id']; ?>" class="btn w-100" style="background-color: #57070c; color: white;">Ver Subasta</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!-- Fin de card -->

                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No hay subastas disponibles en esta categoría.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
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
  <
</footer>
</html>
