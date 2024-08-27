<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            padding-top: 50px;
        }
        .cc-img {
            margin-top: 20px; /* Añadir margen superior para separar del título */
            margin-bottom: 20px; /* Añadir margen inferior */
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%; /* Ajustar tamaño máximo al ancho disponible */
            height: auto; /* Mantener proporción de aspecto */
        }
        .panel-default {
            border: 1px solid #ddd;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-top: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="tel"], input[type="text"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
        }
        .input-group-addon {
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            padding: 12px;
            margin-left: -1px;
        }
        .btn-lg {
            border-radius: 5px;
            background-color: #E51F04;
            border-color: #E51F04;
            color: #fff;
            font-size: 18px;
            padding: 12px;
            width: 100%;
        }
        .btn-lg:hover {
            background-color: #A60000;
            border-color: #A60000;
        }
    </style>
    <script>
        function formatCardNumber(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 16) value = value.slice(0, 16);
            let formattedValue = value.match(/.{1,4}/g);
            if (formattedValue) input.value = formattedValue.join('-');
        }

        function formatExpDate(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0, 4);
            if (value.length > 2) {
                input.value = value.slice(0, 2) + '/' + value.slice(2);
            } else {
                input.value = value;
            }
        }

        function validateForm() {
            const cardNumber = document.getElementById('num_tarjeta').value.replace(/-/g, '');
            const expDate = document.getElementById('exp_fecha').value;
            const cvv = document.getElementById('cod_cv').value;
            const cardHolder = document.getElementById('titular').value;

            let errors = [];

            if (cardNumber.length < 12 || cardNumber.length > 16) {
                errors.push("El número de tarjeta debe tener entre 12 y 16 dígitos.");
            }

            if (!/^\d{2}\/\d{2}$/.test(expDate)) {
                errors.push("La fecha de expiración debe tener el formato MM/YY.");
            }

            if (!/^\d{3}$/.test(cvv)) {
                errors.push("El código CV debe tener 3 dígitos.");
            }

            if (cardHolder.trim() === '') {
                errors.push("El nombre del titular no puede estar vacío.");
            }

            if (errors.length > 0) {
                alert(errors.join('\n'));
                return false;
            }

            return true;
        }

        // Función para mostrar mensaje de éxito y limpiar los campos del formulario
        function showSuccessMessageAndClearFields() {
            alert("Puja registrada correctamente.");
            clearFormFields();
        }

        // Función para limpiar los campos del formulario
        function clearFormFields() {
            document.getElementById('num_tarjeta').value = '';
            document.getElementById('exp_fecha').value = '';
            document.getElementById('cod_cv').value = '';
            document.getElementById('titular').value = '';
        }
    </script>
</head>
<body class="sb-nav-fixed">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3>Detalles de la Puja</h3>
                        <img class="cc-img" src="https://www.prepbootstrap.com/Content/images/shared/misc/creditcardicons.png">
                    </div>
                    <div class="panel-body">
                    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_tarjeta = str_replace('-', '', $_POST['num_tarjeta']);
    $exp_fecha = $_POST['exp_fecha'];
    $cod_cv = $_POST['cod_cv'];
    $titular = $_POST['titular'];
    $id_subasta = 1; 

    $errors = [];

    // Validar número de tarjeta
    if (strlen($num_tarjeta) < 12 || strlen($num_tarjeta) > 16) {
        $errors[] = "Número de tarjeta inválido. Debe tener entre 12 y 16 dígitos.";
    }

    // Validar fecha de expiración
    if (!preg_match('/^\d{2}\/\d{2}$/', $exp_fecha) || !validateExpDate($exp_fecha)) {
        $errors[] = "Fecha de expiración inválida. Debe tener el formato MM/YY.";
    }

    // Validar código CV
    if (!preg_match('/^\d{3}$/', $cod_cv)) {
        $errors[] = "Código CV inválido. Debe tener 3 dígitos.";
    }

    // Validar nombre del titular
    if (trim($titular) === '') {
        $errors[] = "El nombre del titular no puede estar vacío.";
    }

    // Evitar inserción duplicada en la base de datos
    if (empty($errors)) {
        include ('conexionn.php');

        // Verificar si ya existe una puja con estos datos
        $stmt_check = $conex->prepare("SELECT idpuja FROM pujas WHERE numeroTarjeta = ? AND fechaExpira = ? AND CV = ? AND nombreTarjeta = ?");
        if (!$stmt_check) {
            $errors[] = "Error al preparar la consulta de verificación: " . $conex->error;
        } else {
            $stmt_check->bind_param("ssss", $num_tarjeta, $exp_fecha, $cod_cv, $titular);
            $stmt_check->execute();
            $stmt_check->store_result();
            $num_rows = $stmt_check->num_rows;
            $stmt_check->close();

            if ($num_rows > 0) {
                $errors[] = "Ya existe una puja registrada con estos datos.";
            } else {
                // Preparar y bindear para la inserción
                $stmt_insert = $conex->prepare("INSERT INTO pujas (nombreTarjeta, numeroTarjeta, fechaExpira, CV, idSubasta) VALUES (?, ?, ?, ?, ?)");
                if (!$stmt_insert) {
                    $errors[] = "Error al preparar la consulta de inserción: " . $conex->error;
                } else {
                    $stmt_insert->bind_param("ssssi", $titular, $num_tarjeta, $exp_fecha, $cod_cv, $id_subasta);

                    // Convertir la fecha al formato correcto para MySQL
                    $exp_fecha = validateExpDate($exp_fecha);

                    // Ejecutar la consulta de inserción
                    if ($stmt_insert->execute()) {
                        echo "<script>showSuccessMessageAndClearFields();</script>";
                    } else {
                        $errors[] = "Error al ejecutar la consulta de inserción: " . $stmt_insert->error;
                    }

                    // Cerrar la consulta de inserción
                    $stmt_insert->close();
                }
            }
        }

        // Cerrar conexión
        $conex->close();
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
    }
}

function validateExpDate($date) {
    $currentYear = date('Y');
    $currentCentury = substr($currentYear, 0, 2);
    
    list($month, $year) = explode('/', $date);
    
    // Asumiendo que MM/YY se refiere a MM/20YY (por ejemplo, 12/25 es diciembre de 2025)
    $formattedDate = $currentCentury . $year . '-' . $month . '-01'; // Día 01 por convención
    
    return $formattedDate;
}
?>

                        <form role="form" id="payment-form" method="POST" action="" onsubmit="return validateForm();">
                            <div class="form-group">
                                <label for="num_tarjeta">NÚMERO DE TARJETA</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" id="num_tarjeta" name="num_tarjeta" placeholder="1234-5678-9012-3456" oninput="formatCardNumber(this);" value="<?php echo isset($_POST['num_tarjeta']) ? htmlspecialchars($_POST['num_tarjeta']) : ''; ?>" />
                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exp_fecha">FECHA DE EXPIRACIÓN</label>
                                <input type="tel" class="form-control" id="exp_fecha" name="exp_fecha" placeholder="MM/YY" oninput="formatExpDate(this);" value="<?php echo isset($_POST['exp_fecha']) ? htmlspecialchars($_POST['exp_fecha']) : ''; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="cod_cv">CÓDIGO CV</label>
                                <input type="tel" class="form-control" id="cod_cv" name="cod_cv" placeholder="CVC" value="<?php echo isset($_POST['cod_cv']) ? htmlspecialchars($_POST['cod_cv']) : ''; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="titular">TITULAR DE LA TARJETA</label>
                                <input type="text" class="form-control" id="titular" name="titular" placeholder="Nombres del Titular de la Tarjeta" value="<?php echo isset($_POST['titular']) ? htmlspecialchars($_POST['titular']) : ''; ?>" />
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-block btn-danger">Procesar Puja</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
