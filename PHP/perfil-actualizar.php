<?php
// CONSULTA 
include("conexionn.php");
session_start();
$id = $_SESSION['idCliente'];
$consul = $myconn->query("SELECT * FROM cliente where idCliente = '$id'");
$row = $consul->fetch_array();
$foto1 = $row['foto'];

if (isset($_POST['actualizar'])) {
    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $correo = $_POST['correo'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $dui = $_POST['dui'];
    $contraseña = $_POST['contraseña'];
    
    // Manejo de la foto
    if (isset($_POST['eliminarFoto']) && $_POST['eliminarFoto'] == '1') {
        $foto = null;
    } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    } else {
        $foto = $foto1; // Mantener la foto actual si no se carga una nueva
    }

    // Actualizar datos en la base de datos
    $sql = "UPDATE cliente SET 
                PrimerNombre = '$primerNombre', 
                SegundoNombre = '$segundoNombre', 
                PrimerApellido = '$primerApellido',
                SegundoApellido = '$segundoApellido',
                email = '$correo',
                direccion = '$domicilio',
                telefono = '$telefono',
                dui = '$dui',
                foto = '$foto',
                contraseña = '$contraseña'
            WHERE idCliente = '$id'";
    $resultado = $myconn->query($sql);

    if ($resultado) {
        echo "<script>
                alert('Perfil actualizado correctamente.');
                window.location.href = 'perfil.php';
              </script>";
    } else {
        echo "<script>
                alert('Hubo un error al actualizar el perfil: " . $myconn->error . "');
                window.location.href = 'perfil.php';
              </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PERFIL</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
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
      max-width: 800px;
      margin: 20px auto;
      padding: 0 20px;
    }

    .main-content {
      text-align: center;
      margin-top: 50px;
    }

    .auction-item {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      text-align: left;
    }

    .auction-item img {
      max-width: 100%;
      height: auto;
    }
    .input-group .btn-outline-secondary {
    border-left: none;
}

.input-group .form-control {
    border-right: none;
}

  </style>
  <?php
  include("Menulogueado.php");
  ?>
  <!--formulario de la cuenta de el usuario-->
  <form class="my-auto" method="post" action="" enctype="multipart/form-data">

    <div class="container-fluid my-5">
        <div class="row py-5 w-100 justify-content-center mx-auto">
            <!-- Sección de foto de perfil -->
            <div class="col-12 col-lg-4 text-primary bg-light border border-3 rounded-3 p-5" style="border-color: #57070c;">
                <div class="text-center mb-3">
                <?php
                if ($foto1 == null) {
                  echo '<img id="preview" src="https://cdn-icons-png.flaticon.com/512/552/552721.png" class="rounded-circle my-auto border border-1 border-black mx-1" alt="" height="400px" width="400px">';
                } else {
                ?>
                  <img id="preview" src="data:image/jpg;base64,<?php echo base64_encode($foto1) ?>" class="rounded-circle my-auto border border-1 border-black mx-1" alt="" height="400px" width="400px" style="object-fit: cover;">
                <?php
                }
                ?>
                </div>
                <div class="card-body">
                  <!-- Botón para cambiar foto -->
                  <label for="foto">
                    <a type="button" class="btn ms-5" style="background-color: #57070c; color: white; border: none " aria-label="Cambiar foto">
                      <i class="fas fa-camera"></i> Cambiar foto
                    </a>
                    <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(event)">
                  </label>
                  
                  <!-- Botón para eliminar foto -->
                  <label for="eliminarFoto">
                    <a type="button" class="btn ms-5" style="background-color: #57070c; color: white; border: none;" onclick="resetPreview(), deleteFoto()" aria-label="Eliminar foto">
                      <i class="fas fa-trash"></i> Eliminar foto
                    </a>
                    <input type="checkbox" id="eliminarFoto" name="eliminarFoto" value="1" class="d-none">
                  </label>
                </div>
            </div>

            <!-- Sección de información del usuario -->
            <div class="col-lg-7 col-12 bg-light border border-3 rounded-3 p-5" style="border-color: #57070c;">
                <div class="mb-3">
                    <label for="primerNombre" class="form-label"><b>Primer Nombre</b></label>
                    <input type="text" name="primerNombre" class="form-control" id="primerNombre" value="<?php echo $row['PrimerNombre'] ?>">
                </div>
                <div class="mb-3">
                    <label for="segundoNombre" class="form-label"><b>Segundo Nombre</b></label>
                    <input type="text" name="segundoNombre" class="form-control" id="segundoNombre" value="<?php echo $row['SegundoNombre'] ?>">
                </div>
                <div class="mb-3">
                    <label for="primerApellido" class="form-label"><b>Primer Apellido</b></label>
                    <input type="text" name="primerApellido" class="form-control" id="primerApellido" value="<?php echo $row['PrimerApellido'] ?>">
                </div>
                <div class="mb-3">
                    <label for="segundoApellido" class="form-label"><b>Segundo Apellido</b></label>
                    <input type="text" name="segundoApellido" class="form-control" id="segundoApellido" value="<?php echo $row['SegundoApellido'] ?>">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label"><b>Correo</b></label>
                    <input type="email" name="correo" class="form-control" id="correo" value="<?php echo $row['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="domicilio" class="form-label"><b>Domicilio</b></label>
                    <input type="text" name="domicilio" class="form-control" id="domicilio" value="<?php echo $row['direccion'] ?>">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label"><b>Número telefónico</b></label>
                    <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo $row['telefono'] ?>">
                </div>
                <div class="mb-3">
                    <label for="dui" class="form-label"><b>DUI o Pasaporte</b></label>
                    <input type="text" name="dui" class="form-control" id="dui" value="<?php echo $row['dui'] ?>">
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label"><b>Ingresar nueva contraseña</b></label>
                    <input type="password" name="contraseña" class="form-control" id="contraseña">
                </div>

                <button type="submit" class="btn" style="background-color: #57070c; color: white;" name="actualizar">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
                
                <button type="button" class="btn ms-2" style="background-color: #57070c; color: white;" onclick="window.location.href='perfil.php'">
                    <i class="fas fa-arrow-left"></i> Regresar al perfil
                </button>
                
            </div>
        </div>
    </div>
</form>


  <!-- Botón para eliminar cuenta -->       
  <form id="deleteAccountForm" method="post" action="eliminar_cuenta.php">
    <input type="hidden" name="password" id="passwordInput">
    <button type="button" class="btn btn-danger" onclick="showPasswordModal()">Eliminar cuenta</button>
  </form>
<!-- Modal para ingresar la contraseña -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="modalPasswordInput" class="form-label">Ingrese su contraseña:</label>
          <div class="input-group">
            <input type="password" class="form-control" id="modalPasswordInput" aria-describedby="togglePassword">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="fa fa-eye-slash" id="toggleIcon"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>
function showPasswordModal() {
    // Mostrar el modal
    var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
    passwordModal.show();
}

document.getElementById('togglePassword').addEventListener('click', function () {
    var passwordInput = document.getElementById('modalPasswordInput');
    var toggleIcon = document.getElementById('toggleIcon');

    // Cambiar el tipo de input entre "password" y "text"
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
});

function confirmDelete() {
    var password = document.getElementById('modalPasswordInput').value;

    if (password !== "") {
        // Colocar la contraseña en el campo oculto y enviar el formulario
        document.getElementById("passwordInput").value = password;
        document.getElementById("deleteAccountForm").submit();
    } else {
        alert("Debe ingresar su contraseña para eliminar la cuenta.");
    }
}
</script>

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('preview');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }

    function resetPreview() {
      var output = document.getElementById('preview');
      var defaultSrc = "https://cdn-icons-png.flaticon.com/512/552/552721.png"; // Ruta de la imagen por defecto
      output.src = defaultSrc;
      document.getElementById('foto').value = ""; // Limpiar el input file
      document.getElementById('eliminarFoto').checked = true; // Marcar eliminar foto
    }
  </script>


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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  // proceso para eliminar ft de perfil
  function deleteFoto() {
    let res = confirm("¿Esta seguro que desea eliminar esta fotografía?");
    if (res) {
      window.location.href = "eliminarfoto.php?idCliente=<?php echo $id?>";
    }
  }
</script>


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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  // proceso para eliminar ft de perfil
  function deleteFoto() {
    let res = confirm("¿Esta seguro que desea eliminar esta fotografía?");
    if (res) {
      window.location.href = "eliminarfoto.php?idCliente=<?php echo $id?>";
    }
  }
</script>

</html>
