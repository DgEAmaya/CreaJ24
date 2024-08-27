<?php
// CONSULTA 
include("conexionn.php");
session_start();
$id = $_SESSION['idCliente'];
$consul = $conex->query("SELECT * FROM cliente where idCliente = '$id'");
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
                foto = '$foto'
            WHERE idCliente = '$id'";

    $resultado = $conex->query($sql);

    if ($resultado) {
        echo "<script>
                alert('Perfil actualizado correctamente.');
                window.location.href = 'perfil.php';
              </script>";
    } else {
        echo "<script>
                alert('Hubo un error al actualizar el perfil: " . $conex->error . "');
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
    .profile-image {
      width: 400px;
      height: 400px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid black;
    }


    .container-form {
      max-width: 900px;
      margin-top: 50px;
      background-color: #f7f7f7;
      padding: 30px;
      border-radius: 10px;
      border: 1px solid #57070c;
    }

    .form-label {
      font-weight: bold;
    }

    .btn-outline-secondary {
      border-color: #57070c;
      color: #57070c;
    }

    .btn-outline-secondary:hover {
      background-color: #57070c;
      color: white;
    }
  </style>

  <?php include("Menulogueado.php"); ?>

  <!-- Formulario de la cuenta del usuario -->
  <form class="my-auto" method="post" action="" enctype="multipart/form-data">
    <div class="container container-form">
      <div class="row justify-content-center">
        <div class="col-md-4 text-center">
          <?php if ($foto1 == null) { ?>
            <img id="preview" src="https://cdn-icons-png.flaticon.com/512/552/552721.png" class="profile-image mb-4" alt="Foto de perfil">
          <?php } else { ?>
            <img id="preview" src="data:image/jpg;base64,<?php echo base64_encode($foto1) ?>" class="profile-image mb-4" alt="Foto de perfil">
          <?php } ?>
          <div class="d-flex justify-content-center">
            <label for="foto" class="me-2">
              <a class="btn btn-custom mb-2" style="background-color: #57070c; color: white;"><i class="fa-solid fa-camera"></i> Cambiar foto</a>
              <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(event)">
            </label>
            <label for="eliminarFoto">
              <a class="btn btn-danger text-white mb-2" style="background-color: #57070c; color: white;" onclick="resetPreview(), deleteFoto()"><i class="fa-solid fa-trash"></i> Eliminar foto</a>
              <input type="checkbox" id="eliminarFoto" name="eliminarFoto" value="1" class="d-none">
            </label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="mb-3">
            <label for="primerNombre" class="form-label">Primer Nombre</label>
            <input type="text" name="primerNombre" class="form-control" id="primerNombre" value="<?php echo $row['PrimerNombre'] ?>">
          </div>
          <div class="mb-3">
            <label for="segundoNombre" class="form-label">Segundo Nombre</label>
            <input type="text" name="segundoNombre" class="form-control" id="segundoNombre" value="<?php echo $row['SegundoNombre'] ?>">
          </div>
          <div class="mb-3">
            <label for="primerApellido" class="form-label">Primer Apellido</label>
            <input type="text" name="primerApellido" class="form-control" id="primerApellido" value="<?php echo $row['PrimerApellido'] ?>">
          </div>
          <div class="mb-3">
            <label for="segundoApellido" class="form-label">Segundo Apellido</label>
            <input type="text" name="segundoApellido" class="form-control" id="segundoApellido" value="<?php echo $row['SegundoApellido'] ?>">
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" id="correo" value="<?php echo $row['email'] ?>">
          </div>
          <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" name="domicilio" class="form-control" id="domicilio" value="<?php echo $row['direccion'] ?>">
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Número Telefónico</label>
            <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo $row['telefono'] ?>">
          </div>
          <div class="mb-3">
            <label for="dui" class="form-label">DUI</label>
            <input type="text" name="dui" class="form-control" id="dui" value="<?php echo $row['dui'] ?>">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-custom btn-lg mt-3 mb-2" style="background-color: #57070c; color: white;" name="actualizar"><i class="fa-solid fa-cloud-arrow-up"></i> ACTUALIZAR</button>
            <a href="../PHP/perfil.php" class="btn btn-outline-secondary btn-lg mt-3 mb-2" style="background-color: #57070c; color: white;"><i class="fa-solid fa-right-from-bracket"></i> REGRESAR</a>
            <form id="deleteAccountForm" method="post" action="eliminar_cuenta.php">
            <input type="hidden" name="password" id="passwordInput">
            <button type="button" class="btn btn-danger" style="background-color: #57070c; color: white;" onclick="showPasswordModal()" class="fa-solid fa-trash">Eliminar cuenta</button>
          </form>
        </div>
      </div>
    </div>
  </form>
  <!-- Botón para eliminar cuenta -->


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
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function () {
        var output = document.getElementById('preview');
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }

    function resetPreview() {
      var output = document.getElementById('preview');
      output.src = 'https://cdn-icons-png.flaticon.com/512/552/552721.png';
    }

    function deleteFoto() {
      document.getElementById('eliminarFoto').checked = true;
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

<footer>
    <?php include ('footer.php'); ?>
</footer>

</html>
