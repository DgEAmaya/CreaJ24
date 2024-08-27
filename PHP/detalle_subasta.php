<?php
  session_start();
  require_once '../PHP/conexionn.php';
  if (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
} else {
    $idCliente = null; 
}

  $id_subasta = $_GET["id"];  
  $idCliente = $_SESSION["idCliente"];

  $datetime_actual = date("Y-m-d H:i:s");
$sql_check = $myconn->query("SELECT fecha_hora_cierre, estado FROM subastas WHERE id = $id_subasta");
if ($sql_check === false) {
    echo "<script>alert('Error en la consulta SQL.');</script>";
    exit; 
}
$row_check = $sql_check->fetch_assoc();

if ($row_check) {
    $fin = $row_check["fecha_hora_cierre"];
    $estado = $row_check["estado"];
    
    if ($datetime_actual > $fin && $estado == 1) {
        $update_status = $myconn->query("UPDATE subastas SET estado = 1 WHERE id = $id_subasta");
        
        if ($update_status === false) {
            echo "<script>alert('No se pudo actualizar el estado de la subasta.');</script>";
        }
    }
} else {
    echo "<script>alert('No se encontraron datos para la subasta con ID: $id_subasta.');</script>";
}


  
  
  $sql= $myconn->query("SELECT * FROM cesta where id_Subasta='$id_subasta' and idCliente='$idCliente'");
  $filas = mysqli_num_rows($sql);
  if(!($filas)){
    $query= $myconn->query("INSERT INTO cesta VALUES (null, '$id_subasta','$idCliente')");
  }
      if (isset($_POST['comprar'])) {
        $oferta= $_POST['oferta'];
        $fecha_hora_actual = date("Y-m-d H:i:s");
        if (isset($_POST['comprar'])){
          $sql1 = $myconn->query("SELECT * FROM subastas where id='$id_subasta'");
          $rowMax = $sql1->fetch_array();
            $max1 =$rowMax['max'];;
          if((true)){
            $res_1 = $myconn->query("INSERT into oferta(oferta, estado, fecha, id_subasta, postor) values($oferta, 1, '$fecha_hora_actual',$id_subasta, $idCliente);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2 = $myconn->query("INSERT into cesta(id_subasta, idCliente) values($id_subasta, $idCliente);");
              if($res_2 == false){
                echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
              }else{
                $res_2_1 = $myconn->query("UPDATE subastas set estado = 1, max='$max1', postor = $idCliente where id=$id_subasta");
                $comp = $myconn->query("UPDATE oferta set oferta='$max1'  where postor=$idCliente and id_subasta=$id_subasta");
                if($res_2_1 == false){
                  echo "<script>alert('No se pudo actualizar la subasta');</script>";
                }else{
                  echo "<script>alert('1... 2... 3... ¡VENDIDO!');</script>";
                }
              }
            }
          }else{
            $res_1 = $myconn->query("INSERT into oferta(oferta, estado, fecha, id_subasta, postor) values($oferta, 0, '$fecha_hora_actual',$id_subasta, $idCliente);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2_1 = $myconn->query("UPDATE subastas set estado=1, postor=$idCliente where id=$id_subasta;");
              
              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('Oferta realizada con exito!');</script>";
              }
            }
          }
        }
          
      
      }elseif(isset($_POST["ofertar"])){
        $oferta= $_POST['oferta'];
        $oferta = $_POST["oferta"];
        $max = $_POST["max"];
        $fecha_hora_actual = date("Y-m-d h:i:s");

          $res_1 = $myconn->query("INSERT into oferta(oferta, estado, fecha, id_subasta, postor) values($oferta, 0, '$fecha_hora_actual',$id_subasta, $idCliente);");
          if($res_1 == false){
            echo "<script>alert('No se ha podido ofertar');</script>";
          }else{
            $res_2 = $myconn->query("INSERT into cesta(id_subasta, idCliente) values($id_subasta, $idCliente);");
            if($res_2 == false){
              echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
            }else{
              $res_2_1 = $myconn->query("UPDATE subastas set estado=0, postor=$idCliente where id=$id_subasta;");

              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('Oferta realizada con exito!'); window.location.href = 'detalle_subasta.php?id=$id_subasta';</script>";
                

              }
            }
          }
      }
  ?>

 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis detalles</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-btn {
            background-color: #57070c;
            color: white;
        }
        .custom-btn:hover {
            background-color: #7a070c;
        }
        .carousel-item img {
            object-fit: contain; 
            height: 400px;
            width: 100%
        }
        .carousel-container {
            max-width: 60%; 
            margin: 0 auto; 
        }
        .card {
            border-radius: 0.5rem;
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .text-danger {
            color: #dc3545 !important;
        }
        .text-warning {
            color: #ffc107 !important;
        }
        .container {
            max-width: 1000px; 
            margin: 0 auto;
        }
        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .color-circle {
        display: inline-block;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        border: 1px solid #000;
        vertical-align: middle;
        }

        .mensaje-vendido {
        font-size: 24px; 
        color: red; 
        font-weight: bold; 
        text-align: center;
        }

    </style>
</head>

<body class="sb-nav-fixed">
    <nav>
        <?php include ("header.php"); ?>
    </nav>
    <div class="container my-5" style="margin-top: 100px; vertical-align: middle;">
        <div class="row justify-content-center">
            <?php
                $res = $myconn->query("SELECT * FROM subastas WHERE id=$id_subasta");

                if($res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        $nombre_p = $row["nombre_producto"];
                        $descripcion_p = $row["descripcion"];
                        $tamano_p = $row["tamano_producto"];
                        $color_p = $row["color_producto"];
                        $telefono = $row["telefono"];
                        $categoria = $row["categoria_producto"];
                        $estado_producto = $row["estado_producto"];
                        $subastador = $row["postor"];
                        $creador = $row["creador"];
                        $min = $row["min"];
                        $max = $row["max"];
                        $estado = $row["estado"];
                        $fin = $row["fecha_hora_cierre"];
                        $fecha_inicio = $row["fecha_hora_inicio"];
                        $fecha_cierre = $row["fecha_hora_cierre"];
                        $imagen_producto = base64_encode($row["imagen_producto"]);
                        $imagen2 = base64_encode($row["imagen2"]);
                        $imagen3 = base64_encode($row["imagen3"]);
                        $imagen4 = base64_encode($row["imagen4"]);
                        $imagen5 = base64_encode($row["imagen5"]);

                        $datetime_actual = date("Y-m-d H:i:s");
                        $datetime1 = date_create($datetime_actual);
                        $datetime2 = date_create($fin);
                        $interval = $datetime1->diff($datetime2);

                        $res2 = $myconn->query("SELECT * FROM oferta WHERE id_subasta=$id_subasta ORDER BY id_oferta DESC LIMIT 1");
                        $count_ofert = $myconn->query("SELECT COUNT(*) AS total FROM oferta WHERE id_subasta='$id_subasta'")->fetch_assoc()['total'];

                        $res2 = $myconn->query("SELECT * from subastas where id='$id_subasta'");
                          if($res2->num_rows > 0){
                            while($row2 = $res2->fetch_assoc()){
                              $nombre_p = $row2["nombre_producto"];
                              $imagen_p = $row2["imagen_producto"];
                              $descripcion_p = $row2["descripcion"];
                              $categoria = $row2["categoria_producto"];

                              $res_count=$myconn->query("SELECT count(*) as total from oferta where id_subasta='$id_subasta'");
                              $data=$res_count->fetch_array();
                              $count_ofert = $data['total'];

                              $res3 = $myconn->query("SELECT * from oferta where id_subasta=$id_subasta order by id_oferta desc limit 1");
                              if($res3->num_rows > 0){
                                while($row3 = $res3->fetch_assoc()){
                                  $id_oferta = $row3["id_oferta"];
                                  $oferta = $row3["oferta"];
                                  $ofertante_comp = $row3["postor"];

                ?>
            <div class="col-md-6 mb-4 carousel-container">
                <div id="carouselExampleControls" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="data:image/jpeg;base64,<?php echo $imagen_producto; ?>" class="d-block w-100" alt="Imagen del producto">
                        </div>
                        <?php if ($imagen2) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen2; ?>" class="d-block w-100" alt="Imagen adicional 2">
                        </div>
                        <?php } ?>
                        <?php if ($imagen3) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen3; ?>" class="d-block w-100" alt="Imagen adicional 3">
                        </div>
                        <?php } ?>
                        <?php if ($imagen4) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen4; ?>" class="d-block w-100" alt="Imagen adicional 4">
                        </div>
                        <?php } ?>
                        <?php if ($imagen5) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen5; ?>" class="d-block w-100" alt="Imagen adicional 5">
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #57070c;"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #57070c;"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
                    
            <div class="col-md-6">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <?php if ($estado == 1) { ?>
                        <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-check-fill me-2" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.235.235 0 0 0-.336 0l-3 3a.235.235 0 0 0 .336.336l3-3a.235.235 0 0 0 0-.336zM7 1a.5.5 0 0 1 .5.5V2h4.586l1.243 2.25a.5.5 0 0 1-.43.75H6.96l-.276.69L4.76 2H2v1h2.36l1.276 3.18-.7 1.89A.5.5 0 0 1 4.5 8.5H2v1h2.5a.5.5 0 0 1 .49.6l-.3 1.5H2v1h2.33l.3 1.5a.5.5 0 0 1-.49.6H2v1h3.11a.5.5 0 0 1 .49-.6l-.3-1.5H11v1h1V13H6.89a.5.5 0 0 1-.49-.6l.3-1.5H11v-1H6.89a.5.5 0 0 1-.49-.6l.7-1.89L7 7h5.586a1.5 1.5 0 0 0 1.43-.93l1.243-2.25A1.5 1.5 0 0 0 12.586 2H7.5V1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v.5h1v-.5a1.5 1.5 0 0 0-1.5-1.5h-3A1.5 1.5 0 0 0 7 1.5V1z"/>
                            </svg>
                            <h1 class="mb-0">VENDIDO</h1>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="col-md-6">
                    <h5 class="card-title text-success"><?php echo htmlspecialchars($nombre_p); ?></h5>
                    <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($descripcion_p); ?></p>
                    <p><strong>Tamaño:</strong> <?php echo htmlspecialchars($tamano_p); ?></p>
                    <p><strong>Color:</strong> 
                        <span class="color-circle" style="background-color: <?php echo htmlspecialchars($color_p); ?>;"></span>
                    </p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($categoria); ?></p>
                    <p><strong>Estado del producto:</strong> <?php echo htmlspecialchars($estado_producto); ?></p>
                </div>
                
                <div class="col-md-6">
                    <?php 
                        $idCreador = $row['creador'];
                        $SQL = "SELECT PrimerNombre, PrimerApellido FROM cliente WHERE idCliente = ?";
                        $stmt = $myconn->prepare($SQL);
                        $stmt->bind_param("i", $idCreador);
                        $stmt->execute();
                        $stmt->bind_result($primerNombre, $primerApellido);
                        $stmt->fetch();
                        $stmt->close();
                        $nombre_creador = $primerNombre . ' ' . $primerApellido;
                    ?>
                    <p><strong>Creador:</strong> <?php echo htmlspecialchars($nombre_creador); ?></p>
                    <p><strong>Oferta mínima:</strong> $<?php echo htmlspecialchars($min); ?></p>
                    <p><strong>Oferta máxima:</strong> $<?php echo htmlspecialchars($max); ?></p>
                    <p><strong>Fecha de inicio:</strong> <?php echo htmlspecialchars($fecha_inicio); ?></p>
                    <p><strong>Fecha de cierre:</strong> <?php echo htmlspecialchars($fecha_cierre); ?></p>
                    <p><b>Tiempo restante:</b> <span id="countdown"></span></p>
                </div>
            </div>
            <input type="hidden" id="fin" value="<?php echo htmlspecialchars($fin); ?>">
            <p><b>Ofertantes:</b> <?php echo htmlspecialchars($count_ofert); ?></p>
            <h4>Oferta actual: <b class="text-danger"><?php echo "$$oferta"; ?></b></h4>

            <form action="" method="post">
                <input type="hidden" name="id_user" value="<?php echo $_SESSION['idCliente']; ?>">
                <input type="hidden" name="id_sub" value="<?php echo $id_subasta; ?>">
                <input type="hidden" name="max" value="<?php echo $max; ?>">
                <input type="hidden" name="fin" value="<?php echo $fin; ?>">
                <?php 
                    if ($estado == 1 || $_SESSION["idCliente"] == $ofertante_comp || $_SESSION["idCliente"] == $creador) { ?>
                        <div class="mb-3">
                            <input type="number" disabled name="oferta" max="<?php echo $max; ?>" min="<?php echo $oferta + 1; ?>" class="form-control" value="<?php echo $oferta + 1; ?>">
                        </div>
                        <button type="submit" disabled class="btn custom-btn" name="ofertar">Mejorar oferta</button>
                        <button type="submit" disabled class="btn custom-btn" name="comprar">Comprar ahora</button>
                    <?php 
                    } elseif ($estado == 0) { ?>
                        <div class="mb-3">
                            <input type="number" name="oferta" max="<?php echo $max; ?>" min="<?php echo $oferta + 1; ?>" class="form-control" value="<?php echo $min + 1; ?>">
                        </div>
                        <button type="submit" class="btn custom-btn" name="ofertar">Mejorar oferta</button>
                        <button type="submit" class="btn custom-btn" name="comprar">Comprar ahora</button>
                    <?php 
                } 
                ?>
            </form>
        </div>
    </div>
</div>

            <?php
                    }
                } else {
            ?>
       <div class="col-md-6 mb-4 carousel-container">
                <div id="carouselExampleControls" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="data:image/jpeg;base64,<?php echo $imagen_producto; ?>" class="d-block w-100" alt="Imagen del producto">
                        </div>
                        <?php if ($imagen2) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen2; ?>" class="d-block w-100" alt="Imagen adicional 2">
                        </div>
                        <?php } ?>
                        <?php if ($imagen3) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen3; ?>" class="d-block w-100" alt="Imagen adicional 3">
                        </div>
                        <?php } ?>
                        <?php if ($imagen4) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen4; ?>" class="d-block w-100" alt="Imagen adicional 4">
                        </div>
                        <?php } ?>
                        <?php if ($imagen5) { ?>
                        <div class="carousel-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen5; ?>" class="d-block w-100" alt="Imagen adicional 5">
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #57070c;"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #57070c;"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
        </div>

        <div class="col-md-6">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <?php if ($estado == 1) { ?>
                        <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-check-fill me-2" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.235.235 0 0 0-.336 0l-3 3a.235.235 0 0 0 .336.336l3-3a.235.235 0 0 0 0-.336zM7 1a.5.5 0 0 1 .5.5V2h4.586l1.243 2.25a.5.5 0 0 1-.43.75H6.96l-.276.69L4.76 2H2v1h2.36l1.276 3.18-.7 1.89A.5.5 0 0 1 4.5 8.5H2v1h2.5a.5.5 0 0 1 .49.6l-.3 1.5H2v1h2.33l.3 1.5a.5.5 0 0 1-.49.6H2v1h3.11a.5.5 0 0 1 .49-.6l-.3-1.5H11v1h1V13H6.89a.5.5 0 0 1-.49-.6l.3-1.5H11v-1H6.89a.5.5 0 0 1-.49-.6l.7-1.89L7 7h5.586a1.5 1.5 0 0 0 1.43-.93l1.243-2.25A1.5 1.5 0 0 0 12.586 2H7.5V1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v.5h1v-.5a1.5 1.5 0 0 0-1.5-1.5h-3A1.5 1.5 0 0 0 7 1.5V1z"/>
                            </svg>
                            <h1 class="mb-0">VENDIDO</h1>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6">
                    <h5 class="card-title text-success"><?php echo htmlspecialchars($nombre_p); ?></h5>
                    <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($descripcion_p); ?></p>
                    <p><strong>Tamaño:</strong> <?php echo htmlspecialchars($tamano_p); ?></p>
                    <p><strong>Color:</strong> 
                        <span class="color-circle" style="background-color: <?php echo htmlspecialchars($color_p); ?>;"></span>
                    </p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($categoria); ?></p>
                    <p><strong>Estado del producto:</strong> <?php echo htmlspecialchars($estado_producto); ?></p>
                </div>

                <div class="col-md-6">
                    <?php 
                        $idCreador = $row['creador'];
                        $SQL = "SELECT PrimerNombre, PrimerApellido FROM cliente WHERE idCliente = ?";
                        $stmt = $myconn->prepare($SQL);
                        $stmt->bind_param("i", $idCreador);
                        $stmt->execute();
                        $stmt->bind_result($primerNombre, $primerApellido);
                        $stmt->fetch();
                        $stmt->close();
                        $nombre_creador = $primerNombre . ' ' . $primerApellido;
                    ?>
                    <p><strong>Creador:</strong> <?php echo htmlspecialchars($nombre_creador); ?></p>
                    <p><strong>Oferta mínima:</strong> $<?php echo htmlspecialchars($min); ?></p>
                    <p><strong>Oferta máxima:</strong> $<?php echo htmlspecialchars($max); ?></p>
                    <p><strong>Fecha de inicio:</strong> <?php echo htmlspecialchars($fecha_inicio); ?></p>
                    <p><strong>Fecha de cierre:</strong> <?php echo htmlspecialchars($fecha_cierre); ?></p>
                    <p><b>Tiempo restante:</b> <span id="countdown"></span></p>
                </div>
            </div>

            <input type="hidden" id="fin" value="<?php echo htmlspecialchars($fin); ?>">
            <p><b>Ofertantes:</b> <?php echo htmlspecialchars($count_ofert); ?></p>

            <h4>Oferta actual: <b class="text-danger"><?php 
                error_reporting(0);
                if(!($oferta == null)){ echo "$$oferta";}else{
                echo "No hay ninguna oferta actualmente ";
            } ?></b></h4>

            <form action="" method="post">
                <input type="hidden" name="id_user" value="<?php echo $_SESSION['idCliente']; ?>">
                <input type="hidden" name="id_sub" value="<?php echo $id_subasta; ?>">
                <input type="hidden" name="max" value="<?php echo $max; ?>">
                <input type="hidden" name="fin" value="<?php echo $fin; ?>">

                <?php 
                    if($_SESSION["idCliente"] == $creador){ ?>
                        <div class="mb-3">
                            <input type="number" disabled name="oferta" max="<?php echo $max; ?>" min="<?php echo $min + 1; ?>" class="form-control" value="<?php echo $min + 1; ?>">
                        </div>
                        <button type="submit" disabled class="btn custom-btn" name="ofertar">Mejorar oferta</button>
                        <button type="submit" disabled class="btn custom-btn" name="comprar">Comprar ahora</button>
                    <?php 
                    } else { ?>
                        <div class="mb-3">
                            <input type="number" name="oferta" max="<?php echo $max; ?>" min="<?php echo $min; ?>" class="form-control" value="<?php echo $min; ?>">
                        </div>
                        <button type="submit" class="btn custom-btn" name="ofertar">Mejorar oferta</button>
                        <button type="submit" class="btn custom-btn" name="comprar">Comprar ahora</button>
                    <?php 
                } 
                ?>
            </form>
        </div>
    </div>
</div>

            </div>
            <?php

                }

            }

        }else{
            echo "<h4>Hubo un error al recuperar la subasta</h4>";
        }

        }
     }else{
        echo "<h3>Por el momento no existen subastas</h3>";
     }

    
    ?>
       
       <script>
    // Variables PHP para el estado y la oferta máxima
    const estadoSubasta = <?php echo json_encode($estado); ?>;
    const ofertaMax = <?php echo json_encode($max); ?>;

    // Función para actualizar el contador cada segundo
    function actualizarContador() {
        const fechaFinal = new Date('fecha_hora_cierre'); // Fecha y hora de finalización de la subasta
        const ahora = new Date(); // Fecha y hora actual

        // Calcula la diferencia en milisegundos entre la fecha final y ahora
        let diferencia = fechaFinal - ahora;

        // Calcula días, horas, minutos y segundos restantes
        const segundos = Math.floor(diferencia / 1000) % 60;
        const minutos = Math.floor(diferencia / (1000 * 60)) % 60;
        const horas = Math.floor(diferencia / (1000 * 60 * 60)) % 24;
        const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

        // Actualiza el DOM con los valores calculados
        document.getElementById('dias').textContent = dias + ' días ';
        document.getElementById('horas').textContent = horas + ' horas ';
        document.getElementById('minutos').textContent = minutos + ' minutos ';
        document.getElementById('segundos').textContent = segundos + ' segundos ';

        // Verifica si el estado de la subasta es 1 (comprado o máxima oferta alcanzada)
        if (estadoSubasta === 1) {
            clearInterval(intervalo);
            document.getElementById('contador').textContent = 'Subasta Finalizada exitosamente';
            alert('Subasta Finalizada exitosamente');
            return;
        }

        // Si la cuenta regresiva ha terminado, muestra un mensaje
        if (diferencia <= 0) {
            clearInterval(intervalo);
            document.getElementById('contador').textContent = 'La subasta ha finalizado.';
            alert('La subasta ha finalizado.');
            return;
        }
    }

    // Actualiza el contador inicialmente
    actualizarContador();

    // Actualiza el contador cada segundo
    const intervalo = setInterval(actualizarContador, 1000);
</script>




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
<footer>
    <?php
    
    include ('footer.php');
    
    ?>
</footer>
</html>