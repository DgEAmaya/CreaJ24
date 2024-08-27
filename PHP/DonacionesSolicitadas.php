<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donaciones Solicitadas</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <script>
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            // Realizar la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "eliminar_donacion.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Si la eliminación fue exitosa, recargar la página
                    if (xhr.responseText == "success") {
                        location.reload();
                    } else {
                        alert("Error al eliminar el registro");
                    }
                }
            };
            xhr.send("id=" + id);
        }
    }
  </script>
</head>
<body class="sb-nav-fixed">

<img src="../Imagenes/9.png" width="100%" class="img-fluid max-width: 100%;" alt="imgDonaciones">

<section>
<div class="usuariosVista">
    <h2>Solicitudes de Donaciones</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col"># Solicitudes</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Categoria</th>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Estado</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            include('menuAdmin.php');  
            include('conexionn.php'); 
            if ($conex==true) {
                $sql = "SELECT * FROM solicitardonacion";
                $resultado = $conex->query($sql);
                if ($sql){
                    while ($row = $resultado->fetch_array()){
                        $idReceptor         = $row['idReceptor'];
                        $nomReceptor        = $row['nomReceptor'];
                        $emailReceptor      = $row['emailReceptor'];
                        $direccionReceptora = $row['direccionReceptora'];
                        $telReceptor        = $row['telReceptor'];
                        $categoriaReceptor  = $row['CategoriaReceptor'];
                        $producSolicitar    = $row['producSolicitar'];
                        $cantSolicitar      = $row['cantSolicitar'];
                        $estado             = $row['estado'];
        ?>
            <tr>
                <th><?php echo $idReceptor; ?></th>
                <th><?php echo $nomReceptor; ?></th>
                <th><?php echo $emailReceptor; ?></th>
                <th><?php echo $direccionReceptora; ?></th>
                <th><?php echo $telReceptor; ?></th>
                <th><?php echo $categoriaReceptor; ?></th>
                <th><?php echo $producSolicitar; ?></th>
                <th><?php echo $cantSolicitar; ?></th>
                <th><?php echo $estado; ?></th>
                <th class="d-flex">
                    <!-- Llamada a la función de confirmación de eliminación -->
                    <button class="btn reseñasbtn btn-danger" onclick="confirmarEliminacion('<?php echo $idReceptor; ?>')">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </th>
            </tr>
        <?php 
                    }
                }
            } 
        ?>
        </tbody>
    </table>
  </div>
</section>
</body>

<footer>
  <?php include('footer.php'); ?>
</footer>
</html>
