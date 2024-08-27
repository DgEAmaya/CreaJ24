<?php
session_start();
require_once '../PHP/conexionn.php';

if (!isset($_SESSION['idCliente'])) {
    die('Usuario no autenticado.');
}
$iduser = $_SESSION['idCliente'];

$sql_get = "SELECT PrimerNombre, PrimerApellido, email, telefono, direccion FROM cliente WHERE idCliente = $iduser";
$result = mysqli_query($conex, $sql_get);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $PrimerNombre = $row['PrimerNombre'];
    $PrimerApellido = $row['PrimerApellido'];
    $email = $row['email'];
    $telefono = $row['telefono'];
    $direccion = $row['direccion'];
} else {
    $PrimerNombre = $PrimerApellido = $email = $telefono = $direccion = ''; 
}

if (isset($_POST['btn_enviar'])) {
    $mensaje = trim($_POST['mensaje']);
    $fecha = date('Y-m-d');

    $sql = "INSERT INTO reclamos (idCliente, PrimerNombre, PrimerApellido, correo, telefono, direccion, mensaje, fecha) 
            VALUES ('$idCliente','$PrimerNombre', '$PrimerApellido', '$email', '$telefono', '$direccion', '$mensaje', '$fecha')";
    $resultado = mysqli_query($conex, $sql);

    if ($resultado) {
        echo "<script>alert('Su reclamo ha sido enviado.');</script>";
    } else {
        echo "<script>alert('Error en el envío de su reclamo');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reclamos</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <style>
    .margenesdelformulario {
      margin-bottom: 5rem;
      margin-top: 80px;
    }
    .FormReclamos {
      border: 3px solid #57070c; 
      border-radius: 0.75rem; 
      padding: 2rem; 
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
      max-width: 600px; 
      margin: 0 auto;
    }
    .form-group {
      margin-bottom: 1.5rem; 
    }
    .form-group label {
      font-weight: 600; 
      color: #495057;
    }
    .form-control {
      border-radius: 0.5rem; 
      font-size: 1.2em; 
      padding: 0.75rem; 
      border: 1px solid #ced4da; 
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
      border-color: #0056b3; 
    }
    .my-form__button {
      background-color: #57070c;
      color: #fff;
      border: none;
      border-radius: 0.5rem;
      padding: 0.1rem 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 1.3rem;
      width: 25%;
      font-weight: 600;
      justify-content: center;
      margin-left: 200px;
    }
    .my-form__button:hover {
      background-color: #3e0408;
    }
    
  </style>
</head>
<body class="sb-nav-fixed">

  <?php include('header.php'); ?>  

  
  <div class="BannerTraducReclamos d-flex justify-content-center align-items-center">
        <h1 class="BannerTraducTexto">RECLAMOS</h1>
   </div>

  <section class="margenesdelformulario">
    <div class="FormReclamos text-black mx-auto d-flex flex-column justify-content-center">
      <form class="Formularios" method="POST">
        <div class="d-flex align-items-center mb-3 pb-1 text-black">
          <h1>Formulario de Reclamos</h1>
        </div>

        <div class="form-group">
          <label class="form-label" for="PrimerNombre">Primer Nombre</label>
          <input type="text" id="PrimerNombre" name="PrimerNombre" class="form-control" value="<?php echo htmlspecialchars($PrimerNombre); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label" for="PrimerApellido">Primer Apellido</label>
          <input type="text" id="PrimerApellido" name="PrimerApellido" class="form-control" value="<?php echo htmlspecialchars($PrimerApellido); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label" for="correo">Correo Electrónico</label>
          <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label" for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($telefono); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label" for="direccion">Dirección</label>
          <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo htmlspecialchars($direccion); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label" for="mensaje">Mensaje</label>
          <textarea id="mensaje" name="mensaje" class="form-control form-control-lg border"></textarea>
        </div>
                 
        <input class="my-form__button" type="submit" name="btn_enviar" value="Enviar">
      </form>
    </div>
  </section>

  <div class="container-fluid bg-dark text-white mt-5">
    <footer>
      <?php include('footer.php'); ?>
    </footer>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>
  <script src="../js/mood_oscuro.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
