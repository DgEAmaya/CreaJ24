<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial Inspector</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .containerSoli {
      margin-top: 40px;
    }
    h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }
    .table {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .table thead th {
      background-color: #57070c;
      color: #ffffff;
      font-weight: bold;
    }
    .table tbody tr {
      transition: background-color 0.3s ease;
    }
    .table tbody tr:hover {
      background-color: #f8f9fa; /* Cambia el color de fondo en el hover si lo deseas */
    }
    .table td, .table th {
      vertical-align: middle;
      padding: 12px;
    }
    .btn-sm {
      border-radius: 5px;
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
    }
    .btn-success:hover, .btn-danger:hover {
      opacity: 0.8;
    }
    .img-fluid {
      max-width: 100%;
      height: auto;
    }
  </style>
</head>

<body class="sb-nav-fixed">

  <nav>
    <?php
    include ("menu_Inspec.php");
    ?>
  </nav>

  <img src="../Imagenes/historialInsp.png" width="100%" class="img-fluid" alt="Imagen de Inspecciones">

  <div class="containerSoli">
    <h1 class="text-center">Solicitudes de Donación</h1>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Ubicación</th>
            <th>Teléfono</th>
            <th>Categoría</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Donado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include_once('conexionn.php');

          // Consulta modificada para obtener todas las solicitudes de donación
          $sql = "SELECT * FROM solicitardonacion";
          $result = $myconn->query($sql);

          if ($result === false) {
            echo "Error en la consulta: " . mysqli_error($conex);
          } else {
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["idReceptor"] . "</td>";
                echo "<td>" . $row["nomReceptor"] . "</td>";
                echo "<td>" . $row["emailReceptor"] . "</td>";
                echo "<td>" . $row["direccionReceptora"] . "</td>";
                echo "<td>" . $row["telReceptor"] . "</td>";
                echo "<td>" . $row["CategoriaReceptor"] . "</td>";
                echo "<td>" . $row["producSolicitar"] . "</td>";
                echo "<td>" . $row["cantSolicitar"] . "</td>";
                echo "<td>" . $row["estado"] . "</td>";
                echo "<td>" . $row["donado"] . "</td>"; 
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='10'>No hay solicitudes de donación.</td></tr>";
            }
          }
          mysqli_close($myconn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <footer>
    <?php
    include ('footer.php');
    ?>
  </footer>
</body>
</html>
