<?php
include('conexionn.php');

if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
    $sql = "SELECT * FROM cliente WHERE idCliente = $idCliente";
    $result = $conex->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
    } else {
        echo "No user found with the given ID.";
        exit;
    }
}

if (isset($_POST['Actualizar'])) {
    $idCliente = $_POST['idCliente'];
    $Rol = $_POST['Rol']; // Only update the Rol field

    // Update only the Rol field
    $sql = "UPDATE cliente SET Rol='$Rol' WHERE idCliente=$idCliente";
    if ($conex->query($sql) === TRUE) {
        header("Location: usuarios.php");
    } else {
        echo "Error updating record: " . $conex->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="BoddyDos">
    <div class="form-wrapper">
        <main class="form-side">
            <a href="../HTML/index.html" title="Logo">
                <img src="../Imagenes/Logo_grande_negro.png" alt="Laplace Logo" class="logo">
            </a>

            <form class="my-form" method="POST" action="">
                <input type="hidden" name="idCliente" value="<?php echo $row['idCliente'] ?>">
                <div class="form-welcome-row">
                    <h1 style="color: black; font-family:Bebas neue; font-size:2.5rem;">Editar Usuario</h1>
                </div>

                <div class="bloquepadredeRegistro" style="display: flex; margin-left: -20%;">

                    <div class="PrimerBloqueRegistro" style="margin-left: -25%; margin-right: 20px;">
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="PrimerNombre">Primer Nombre</label>
                            <input type="text" id="PrimerNombre" name="PrimerNombre" value="<?php echo $row['PrimerNombre']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="SegundoNombre">Segundo Nombre</label>
                            <input type="text" id="SegundoNombre" name="SegundoNombre" value="<?php echo $row['SegundoNombre']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="PrimerApellido">Primer Apellido</label>
                            <input type="text" id="PrimerApellido" name="PrimerApellido" value="<?php echo $row['PrimerApellido']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="SegundoApellido">Segundo Apellido</label>
                            <input type="text" id="SegundoApellido" name="SegundoApellido" value="<?php echo $row['SegundoApellido']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" value="<?php echo $row['email']?>" readonly>
                        </div>
                    </div>

                    <div class="segundoBloqueRegistro">
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="dui">DUI o Pasaporte</label>
                            <input type="password" id="dui" name="dui" value="<?php echo $row['dui']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="telefono">Número de teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="<?php echo $row['telefono']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="contraseña">Contraseña</label>
                            <input type="password" id="contraseña" name="contraseña" value="<?php echo $row['contraseña']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="verificar_contraseña">Confirmar Contraseña</label>
                            <input type="password" id="verificar_contraseña" name="verificar_contraseña" value="<?php echo $row['contraseña']?>" readonly>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="Rol">Rol</label>
                            <input type="number" id="Rol" name="Rol" value="<?php echo $row['Rol']?>">
                        </div>
                    </div>
                </div>

                <button name="Actualizar" class="my-form__button" type="submit">
                    Actualizar
                </button>
            </form>
        </main>
        <aside class="info-side"></aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
