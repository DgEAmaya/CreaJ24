<?php

// Incluir la clase db_connect
require_once __DIR__ . '/conexionn.php';

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

session_start();

@$email = $_POST['email'];
@$contraseña = $_POST['contraseña']; 
@$sesion = $_SESSION['PrimerNombre'];

// Conectar a la base de datos
$bs = new DB_CONNECT();
$conn = $bs->connect();

// Array para almacenar los mensajes de error
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = validate($_POST['email']);
    $contraseña = validate($_POST['contraseña']);

    // Validación de usuario y contraseña
    $sql = "SELECT idCliente, email, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, contraseña, Rol FROM cliente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($idCliente, $email, $PrimerNombre, $SegundoNombre, $PrimerApellido, $SegundoApellido, $contraseña_hash, $Rol);
        $stmt->fetch();
        
        if (password_verify($contraseña, $contraseña_hash)) {
            $_SESSION['idCliente'] = $idCliente;
            $_SESSION['PrimerNombre'] = $PrimerNombre;
            $_SESSION['SegundoNombre'] = $SegundoNombre;
            $_SESSION['PrimerApellido'] = $PrimerApellido;
            $_SESSION['SegundoApellido'] = $SegundoApellido;
            $_SESSION['email'] = $email;
            $_SESSION['Rol'] = $Rol;
            
            if ($Rol == 1) { // Cliente
                header("Location: index.php");
            } elseif ($Rol == 2) { // Inspector
                header("Location: inspector.php");
            } elseif ($Rol == 3) { // Admin
                header("Location: admin.php");
            }
            exit();
        } else {
            $errors[] = "Contraseña incorrecta.";
        }
    } else {
        $errors[] = "El correo electrónico no existe.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssdepura.css">

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
            position: relative;
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="my-form" method="POST">  
                <div class="form-welcome-row">
                    <h1 style="color: black; font-family:Bebas neue; font-size:2.5rem;" >Bienvenid@ a Bidding Sure!</h1>
                    <h2>Encuentra lo que buscas en un solo lugar</h2>
                    <div id="google_translate_element" class="z-50 bottom-0 right-0 fixed"></div>
                </div>
                <div class="text-field">
                    <label for="email"style="color: black; font-family:Bebas neue;font-size:1.5rem; ">Correo Electronico</label>
                    <input type="email" id="email" name="email" placeholder="Tucorreo@gmail.com"
                        required>
                    <div class="error-message">Email in incorrect format</div>
                </div>
                <div class="text-field">
                    <label for="password" style="color: black; font-family:Bebas neue; font-size:1.5rem;">Contraseña</label>
                    <input id="password" type="password" name="contraseña" placeholder="Introduce tu contraseña" title="Mínimo 6 caracteres, al menos 1 alfabeto y 1 número"
                    required>
                    <div class="error-message">Mínimo 6 caracteres, al menos 1 alfabeto y 1 número</div>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                    <button name="validar" class="my-form__button" type="submit" style="background-color: #57070c;">
                   
                        <h1 style=" font-family:Bebas neue; font-size:1.5rem;letter-spacing: 0.1rem; padding-top: 0.5rem;">Iniciar Sesión</h1>
                   
                    </button>

                <div class="my-form__actions">
                    <div class="my-form__row_Cuenta">
                        <span >¿No tiene cuenta?</span>
                        <a href="../php/Registros.php" title="Reset Password" class="link" style="color: black;">
                            Regístrese ahora
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