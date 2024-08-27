<?php
session_start();
require_once '../PHP/conexionn.php';
$idCliente = $_SESSION["idCliente"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mi Cuenta</title>
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
        <?php include ('Menulogueado.php') ?>
    </nav>

    <div id="wrapper">
        <div id="page-wrapper">
        <div class="container-fluid mt-5">
            <!-- Tabla para Subastas Abiertas -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive shadow-sm p-4 bg-white rounded">
                        <h2 class="mb-5 text-center text-black ">Subastas Abiertas</h2>
                        <hr>
                        <table class="table table-hover table-striped align-middle">
                            <thead class=" table-dark">
                                <tr>
                                    <th class=" h4 fw-bold text-center">Imagen</th>
                                    <th class=" h4 fw-bold ">Nombre</th>
                                    <th class=" h4 fw-bold ">Categoría</th>
                                    <th class=" h4 fw-bold ">Oferta Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Subastas Abiertas del Usuario
                                $res = $conex->query("SELECT * FROM subastas WHERE estado=0 AND creador=$idCliente");
                                if ($res && $res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                        $id_subasta = $row["id"];
                                        $nombre_p = $row["nombre_producto"];
                                        $categoria = $row["categoria_producto"];
                                        $imagen_producto = base64_encode($row["imagen_producto"]);
                                        $fin = $row["fecha_hora_cierre"];

                                        $datetime_actual = new DateTime();
                                        $datetime2 = new DateTime($fin);
                                        $interval = $datetime_actual->diff($datetime2);

                                        // Query last offer
                                        $res3 = $conex->query("SELECT * FROM oferta WHERE id_subasta=$id_subasta ORDER BY id_oferta DESC LIMIT 1");
                                        if ($res3 && $res3->num_rows > 0) {
                                            while ($row3 = $res3->fetch_assoc()) {
                                                $oferta = $row3["oferta"];
                                            }
                                        } else {
                                            $oferta = 0;
                                        }

                                        // Display active auction
                                        ?>
                                        <tr>
                                            <td class="text-center" width="400px" >
                                                <a href="subasta.php?id=<?php echo $id_subasta; ?>" class="d-block">
                                                    <img src="data:image/jpeg;base64,<?php echo $imagen_producto; ?>" class="img-fluid rounded" style="height: 200px; object-fit: cover;">
                                                </a>
                                            </td>
                                            <td class="align-middle fs-4"><b class="text-success"><?php echo $nombre_p; ?></b></td>
                                            <td class="align-middle fs-4"><?php echo $categoria; ?></td>
                                            <td class="align-middle fs-4"><b class="text-danger">$<?php echo $oferta; ?>.00</b></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center text-muted'>No hay subastas abiertas.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <!-- /.container-fluid -->
        </div>
    </div>

    <footer>
        <?php include ('../PHP/footer.php') ?>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
