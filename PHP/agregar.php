<?php
// Incluir la clase db_connect
require_once __DIR__ . '/conexionn.php';

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conectar a la base de datos
    $bs = new DB_CONNECT();
    $conn = $bs->connect();     

    // Validar y sanitizar los datos recibidos
    $PrimerNombre = validate($_POST['PrimerNombre']);
    $SegundoNombre = validate($_POST['SegundoNombre']);
    $PrimerApellido = validate($_POST['PrimerApellido']);
    $SegundoApellido = validate($_POST['SegundoApellido']);
    $email = validate($_POST['email']);
    $contraseña = $_POST['contraseña'];
    $verificar_contraseña = validate($_POST['verificar_contraseña']);
    $Rol = $_POST['Rol'];

    // Validaciones de los campos
    if (!preg_match("/^[a-zA-Z]+$/", $PrimerNombre)) {
        $errors[] = "El primer nombre solo debe contener caracteres alfabéticos.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $SegundoNombre)) {
        $errors[] = "El segundo nombre solo debe contener caracteres alfabéticos.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $PrimerApellido)) {
        $errors[] = "El primer apellido solo debe contener caracteres alfabéticos y tildes.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $SegundoApellido)) {
        $errors[] = "El segundo apellido solo debe contener caracteres alfabéticos y tildes.";
    }

    // Validación de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }

    // Validación de contraseña
    if (strlen($contraseña) < 8 || !preg_match("/[A-Z]/", $contraseña) || !preg_match("/[a-z]/", $contraseña) || !preg_match("/[0-9]/", $contraseña)) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número.";
    }

    if ($contraseña !== $verificar_contraseña) { 
        $errors[] = "Las contraseñas no coinciden.";
    } else {
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
    }

    // Verificar si el correo ya está registrado
    $sql = "SELECT email FROM cliente WHERE email='$email';";
    $result = mysqli_query($bs->myconn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="registro_advertencia"><a data-text="MsgEmailNoReg1">El correo</a>&nbsp;<b>' . $email . '</b><a data-text="MsgEmailYaReg2">, ya está registrado, Verifique!.</a></div>';
    } else {
        // Si no hay errores, insertar el nuevo registro en la base de datos
        if (empty($errors)) {
            $sql = "INSERT INTO cliente (PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, email, contraseña, Rol) 
                    VALUES ('$PrimerNombre', '$SegundoNombre', '$PrimerApellido', '$SegundoApellido', '$email', '$contraseña', '$Rol')";
            $sql1 = mysqli_query($bs->myconn, $sql);

            if ($sql1) {
                echo '<div class="registro_exitoso" data-text="AlumnRegsOK1">Los datos se han registrado correctamente.</div>';
                header("location: admin.php");
                exit();
            } else {
                echo '<div class="registro_error" data-text="AlumnRegsFa1">Error al registrar los datos.</div>';
            }
        } else {
            foreach ($errors as $error) {
                echo '<div class="registro_error">' . $error . '</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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
            <a href="../PHP/admin.php" title="Logo">
                <img src="../Imagenes/Logo_grande_negro.png" alt="Laplace Logo" class="logo">
            </a>
            <form class="my-form" method="POST">
                <div class="form-welcome-row">
                    <h1 style="color: black; font-family:Bebas neue; font-size:2.5rem;">Agregar Usuario</h1>
                </div>

                <div class="bloquepadredeRegistro" style=" display: flex; margin-left: -20%;">
                    <div class="PrimerBloqueRegistro" style="margin-left: -25%; margin-right: 20px ;">
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="PrimerNombre">Primer Nombre</label>
                            <input type="text" id="PrimerNombre" name="PrimerNombre" autocomplete="off" required>
                            <div class="error-message">Nombre de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="SegundoNombre">Segundo Nombre</label>
                            <input type="text" id="SegundoNombre" name="SegundoNombre" autocomplete="off" required>
                            <div class="error-message">Nombre de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="PrimerApellido">Primer Apellido</label>
                            <input type="text" id="PrimerApellido" name="PrimerApellido" autocomplete="off" required>
                            <div class="error-message">Apellido de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="SegundoApellido">Segundo Apellido</label>
                            <input type="text" id="SegundoApellido" name="SegundoApellido" autocomplete="off" required>
                            <div class="error-message">Apellido de Usuario No válido</div>
                        </div>
                    </div>
                    <div class="segundoBloqueRegistro">
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" autocomplete="off" required>
                            <div class="error-message">Correo Incorrecto</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="contraseña">Contraseña</label>
                            <input id="contraseña" type="password" name="contraseña" required>
                            <div class="error-message">Mínimo 8 caracteres, al menos 1 mayúscula, 1 minúscula y 1 número</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="verificar_contraseña">Confirmar Contraseña</label>
                            <input id="verificar_contraseña" type="password" name="verificar_contraseña" required>
                            <div class="error-message">Las contraseñas deben coincidir</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="Rol">Rol</label>
                            <input type="number" id="Rol" name="Rol" value="<?php echo $row['Rol']?>">
                        </div>
                    </div>
                </div>
                <button name="validar" class="my-form__button" type="submit">Registrar usuario</button>
            </form>
        </main>
        <aside class="info-side"></aside>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>