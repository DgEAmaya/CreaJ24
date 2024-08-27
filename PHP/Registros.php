<?php
// Incluir la clase db_connect
require_once __DIR__ . '/conexionn.php';

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    $bs = new DB_CONNECT();
    $conn = $bs->connect();     
    $PrimerNombre = validate($_POST['PrimerNombre']);
    $SegundoNombre = validate($_POST['SegundoNombre']);
    $PrimerApellido = validate($_POST['PrimerApellido']);
    $SegundoApellido = validate($_POST['SegundoApellido']);
    $direccion = validate($_POST['direccion']);
    $telefono = validate($_POST['telefono']);
    $dui = validate($_POST['dui']);
    $email = validate($_POST['email']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $verificar_contraseña = validate($_POST['verificar_contraseña']);

    // Validaciones del lado del servidor
    if (!preg_match("/^[a-zA-Z]+$/", $PrimerNombre)) {
        $errors[] = "El nombre solo debe contener caracteres alfabéticos.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $SegundoNombre)) {
        $errors[] = "El nombre solo debe contener caracteres alfabéticos.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $PrimerApellido)) {
        $errors[] = "El apellido solo debe contener caracteres alfabéticos y tildes.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $SegundoApellido)) {
        $errors[] = "El apellido solo debe contener caracteres alfabéticos y tildes.";
    }

    if (!preg_match("/^[\d\-\+]{1,9}$/", $telefono)) {
        $errors[] = "El número telefónico debe tener máximo 9 caracteres, y solo puede contener dígitos y guiones (-).";
    }

    // Validación del correo electrónico en la base de datos
    $sql = "SELECT email FROM cliente WHERE email='$email';";
    $result = mysqli_query($bs->myconn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "El correo ya está registrado, Verifique!";
    } else {
        // Validación de DUI en la base de datos
        $sql = "SELECT dui FROM cliente WHERE dui='$dui';";
        $resulta = mysqli_query($bs->myconn, $sql);
        if (mysqli_num_rows($resulta) > 0) {
            $errors[] = "El DUI ya está registrado, Verifique!";
        } else {

            $sql = "SELECT telefono FROM cliente WHERE telefono='$telefono';";
            $resulta = mysqli_query($bs->myconn, $sql);
            if (mysqli_num_rows($resulta) > 0) {
            $errors[] = "El Numero de telefono ya está registrado, Verifique!";
            } else {    

                // Validación de correo electrónico
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "El correo electrónico no es válido.";
                }

                if (strlen($contraseña) < 8 || !preg_match("/[A-Z]/", $contraseña) || !preg_match("/[a-z]/", $contraseña) || !preg_match("/[0-9]/", $contraseña)) {
                    $errors[] = "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número.";
                }

                if ($_POST['contraseña'] !== $_POST['verificar_contraseña']) {
                    $errors[] = "Las contraseñas no coinciden.";
                }

                if (empty($errors)) {
                    // Insertar los datos de registro
                    $sql = "INSERT INTO cliente (PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, email, dui, direccion, telefono, contraseña) 
                    VALUES ('$PrimerNombre','$SegundoNombre','$PrimerApellido','$SegundoApellido','$email', '$dui', '$direccion','$telefono','$contraseña')";
                    $sql1 = mysqli_query($bs->myconn, $sql);

                    if ($sql1) {
                        $success = "El usuario ha sido creado correctamente."; // Cambia este bloque
                        header("location: Registros.php");
                        exit();
                    } else {
                        echo '<script>alert("Error al registrar los datos..");</script>';
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    
    <style>

        .alert-dismissible {
            position: relative;
            padding-right: 4rem;
        }

        .alert-dismissible .btn-close {
            position: absolute;
            top: 0.75rem;
            right: 1rem;
            padding: 0;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
        }

        .alert-success { /* Agrega este bloque */
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .skiptranslate iframe {
            opacity: 0 !important;
            z-index: -10000;
        }
        
        img[src="https://www.google.com/images/cleardot.gif"]
        {
            display: none;
        }

        body {
            top: 0 !important;
            overflow: hidden !important;
        }

    </style>

  
</head>
 
<body class="BoddyDos">

    <div class="form-wrapper">
        <main class="form-side">
            <a href="../PHP/Index.php" title="Logo">
                <img src="../Imagenes/Logo_grande_negro.png" alt="Laplace Logo" class="logo">
            </a>

            

            <form class="my-form" method="POST">

                <div class="form-welcome-row">
                    <h1 style="color: black; font-family:Bebas neue; font-size:2.5rem;">Bienvenid@ a Bidding Sure!</h1>
                    <h2>Encuentra lo que buscas en un solo lugar</h2>
                    <div id="google_translate_element" class="z-50 bottom-0 right-0 fixed"></div>  
                </div>

                <div class="bloquepadredeRegistro" style=" display: flex; margin-left: -20%;">

                    <div class="PrimerBloqueRegistro" style="margin-left: -25%; margin-right: 20px ;">
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="email">Primer Nombre</label>
                            <input type="text" id="NomUsuario" name="PrimerNombre" autocomplete="off"
                                required value="<?= isset($_POST['PrimerNombre']) ? htmlspecialchars($_POST['PrimerNombre']) : ''; ?>">
                            <div class="error-message">Nombre de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="email">Segundo Nombre</label>
                            <input type="text" id="NomUsuario" name="SegundoNombre" autocomplete="off"
                                required value="<?= isset($_POST['SegundoNombre']) ? htmlspecialchars($_POST['SegundoNombre']) : ''; ?>">
                            <div class="error-message">Nombre de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Primer Apellido</label>
                            <input type="text" id="NomUsuario" name="PrimerApellido" autocomplete="off"
                                required value="<?= isset($_POST['PrimerApellido']) ? htmlspecialchars($_POST['PrimerApellido']) : ''; ?>">
                            <div class="error-message">Apellido de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Segundo Apellido</label>
                            <input type="text" id="NomUsuario" name="SegundoApellido" autocomplete="off"
                                required value="<?= isset($_POST['SegundoApellido']) ? htmlspecialchars($_POST['SegundoApellido']) : ''; ?>">
                            <div class="error-message">Apellido de Usuario No válido</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" autocomplete="off"
                                required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            <div class="error-message">Correo Incorrecto</div>
                        </div>
                    </div>

                    <div class="segundoBloqueRegistro">

                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">Domicilio</label>
                            <input type="Texto" id="Ubi" name="direccion" autocomplete="off"
                                required value="<?= isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
                            <div class="error-message">Ubicación no encontrada. Introduzca una dirección válida.</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue; width: 400px;" for="email">Número de teléfono</label>
                            <input type="text" id="NumTelefonico" name="telefono" autocomplete="off"
                                required value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                            <div class="error-message">Número de dígitos supera el número de caracteres.</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="email">DUI o Pasaporte</label>
                            <input type="text" id="NumDeIdentificacion" name="dui" autocomplete="off"
                                required value="<?= isset($_POST['dui']) ? htmlspecialchars($_POST['dui']) : ''; ?>">
                            <div class="error-message">Número de dígitos no válidos.</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="password">Contraseña</label>
                            <input id="password" type="password" name="contraseña" title="Contraseña" required>
                            <div class="error-message">Mínimo 8 caracteres, al menos 1 alfabeto y 1 número</div>
                        </div>
                        <div class="text-field">
                            <label style="color: black; font-family:Bebas neue;" for="password">Confirmar Contraseña</label>
                            <input id="verificar_contraseña" type="password" name="verificar_contraseña" title="Contraseña" required>
                            <div class="error-message">Las contraseñas no coinciden</div>
                        </div>
                    </div>

                </div>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <button name="validar" class="my-form__button" type="submit">
                    Registrarse
                </button>
                <div class="my-form__actions">
                    <div class="my-form__row_Cuenta">
                        <span>¿Ya posee una cuenta?</span>
                        <a style="color: black;" href="../php/InicioSesion.php" title="Reset Password">
                            Iniciar Sesión
                        </a>
                    </div>
                </div>

            </form>
        </main>
        <aside class="info-side"></aside>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function() {
        function googleTranslateElementInit() {
            new window.google.translate.TranslateElement(
                {
                    autoDisplay: false,
                    includedLanguages: 'en,es,de,ja,fr,it,pt,zh-CN,hi,ru,el,no',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                },
                "google_translate_element"
            );
        }

        const translateDiv = document.createElement('div');
        translateDiv.classList.add('translate-container'); 
        translateDiv.id = 'google_translate_element';
        document.body.appendChild(translateDiv);

        const addScript = document.createElement("script");
        addScript.setAttribute(
            "src",
            "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
        );
        document.body.appendChild(addScript);

        window.googleTranslateElementInit = googleTranslateElementInit;
        });
    </script>

</body>
</html> 