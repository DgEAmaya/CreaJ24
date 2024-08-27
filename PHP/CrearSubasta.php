<?php
date_default_timezone_set("America/El_Salvador");
session_start();
require_once '../PHP/conexionn.php';

$telefono = '';
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sesion = $_SESSION['idCliente'];

    $stmt = $conex->prepare("SELECT telefono FROM cliente WHERE idCliente = ?");
    $stmt->bind_param("i", $sesion);
    $stmt->execute();
    $stmt->bind_result($telefono);
    $stmt->fetch();
    $stmt->close();

    $telefono = preg_replace('/[^0-9]/', '', $telefono); 
    if (strlen($telefono) === 8) {
        $telefono = substr($telefono, 0, 4) . '-' . substr($telefono, 4, 4);
    } else {
        echo '<script>alert("El teléfono debe contener como mínimo 8 dígitos."); window.history.back();</script>';
        exit;
    }

    $nombre_producto = trim($_POST['nombre_producto'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $tamano_producto = trim($_POST['tamano_producto'] ?? '');
    $color_producto = trim($_POST['color_producto'] ?? '');
    $categoria_producto = trim($_POST['categoria_producto'] ?? '');
    $estado_producto = trim($_POST['estado_producto'] ?? '');
    $min = isset($_POST['min']) && is_numeric($_POST['min']) ? intval($_POST['min']) : null;
    $max = isset($_POST['max']) && is_numeric($_POST['max']) ? intval($_POST['max']) : null;
    $fecha_cierre = trim($_POST['fecha_cierre'] ?? '');
    $hora_cierre = trim($_POST['hora_cierre'] ?? '');
    $fecha_hora_cierre = "$fecha_cierre $hora_cierre:00";
    $estado = 0;
    $fecha_hora_inicio = date('Y-m-d');
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i');
    $postor = $sesion;

    if (empty($nombre_producto) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nombre_producto)) {
        echo '<script>alert("El nombre del producto es obligatorio y solo puede contener letras, números y espacios."); window.history.back();</script>';
        exit;
    }

    if (empty($tamano_producto)) {
        echo '<script>alert("El tamaño del producto es obligatorio."); window.history.back();</script>';
        exit;
    }

    if (empty($color_producto)) {
        echo '<script>alert("El color del producto es obligatorio."); window.history.back();</script>';
        exit;
    }

    if (empty($categoria_producto)) {
        echo '<script>alert("La categoría del producto es obligatoria."); window.history.back();</script>';
        exit;
    }

    if (empty($estado_producto)) {
        echo '<script>alert("El estado del producto es obligatorio."); window.history.back();</script>';
        exit;
    }

    if ($min === null || $min < 0) {
        echo '<script>alert("El precio mínimo es obligatorio y debe ser un número mayor o igual a 0."); window.history.back();</script>';
        exit;
    }

    if ($max === null || $max < 0) {
        echo '<script>alert("El precio máximo es obligatorio y debe ser un número mayor o igual a 0."); window.history.back();</script>';
        exit;
    }

    if ($min !== null && $max !== null && $min > $max) {
        echo '<script>alert("El precio mínimo no puede ser mayor que el precio máximo."); window.history.back();</script>';
        exit;
    }

    if (empty($fecha_cierre) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_cierre)) {
        echo '<script>alert("La fecha de cierre es obligatoria y debe tener el formato AAAA-MM-DD."); window.history.back();</script>';
        exit;
    }

    if (empty($hora_cierre) || !preg_match('/^\d{2}:\d{2}$/', $hora_cierre)) {
        echo '<script>alert("La hora de cierre es obligatoria y debe tener el formato HH:MM."); window.history.back();</script>';
        exit;
    }

    $fecha_hora_cierre = $fecha_cierre . ' ' . $hora_cierre;

    $fecha_hora_actual = $fecha_actual . ' ' . $hora_actual;

    $timestamp_cierre = strtotime($fecha_hora_cierre);
    $timestamp_actual = strtotime($fecha_hora_actual);

    if ($timestamp_cierre <= $timestamp_actual) {
        echo '<script>alert("La fecha y hora de cierre deben ser en el futuro."); window.history.back();</script>';
        exit;
    }

    $imagenes = ['imagen_producto', 'imagen2', 'imagen3', 'imagen4', 'imagen5'];
    $imagenes_tipos_mime = [];
    $imagenes_datos = [];
    $imagenes_validas = false;

    foreach ($imagenes as $key => $imagen) {
        if (isset($_FILES[$imagen]) && $_FILES[$imagen]['error'] == 0) {
            $imagen_producto = $_FILES[$imagen]['tmp_name'];
            $tipo_mime = $_FILES[$imagen]['type'];
            $imagen_contenido = file_get_contents($imagen_producto);
            $imagenes_datos[$key] = $imagen_contenido;
            $imagenes_tipos_mime[$key] = $tipo_mime;
            $imagenes_validas = true;
        } else {
            $imagenes_datos[$key] = null;
            $imagenes_tipos_mime[$key] = '';
        }
    }

    if (!$imagenes_validas) {
        echo '<script>alert("Debes agregar al menos una imagen válida."); window.history.back();</script>';
        exit;
    }

    if (empty($errores)) {
        $sql = "INSERT INTO subastas 
                (nombre_producto, descripcion, tamano_producto, color_producto, 
                telefono, categoria_producto, estado_producto, postor, min, 
                max, creador, estado, fecha_hora_inicio, fecha_hora_cierre, 
                imagen_producto, tipo_mime, imagen2, tipo_mime2, imagen3, tipo_mime3, imagen4, tipo_mime4, imagen5, tipo_mime5) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conex->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conex->error);
        }

        $stmt->bind_param("ssssssssssssssssssssssss", 
            $nombre_producto, $descripcion, $tamano_producto, $color_producto, $telefono, 
            $categoria_producto, $estado_producto, $postor, $min, $max, $sesion, 
            $estado, $fecha_hora_inicio, $fecha_hora_cierre, 
            $imagenes_datos[0], $imagenes_tipos_mime[0], 
            $imagenes_datos[1], $imagenes_tipos_mime[1], 
            $imagenes_datos[2], $imagenes_tipos_mime[2], 
            $imagenes_datos[3], $imagenes_tipos_mime[3], 
            $imagenes_datos[4], $imagenes_tipos_mime[4]
        );

        if ($stmt->execute()) {
            echo '<script>alert("Los datos han sido guardados correctamente."); window.location.href = "index.php";</script>';
            exit;
        } else {
            echo "Error al ejecutar la consulta: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
} else {
    $sesion = $_SESSION['idCliente'];
    $stmt = $conex->prepare("SELECT telefono FROM cliente WHERE idCliente = ?");
    $stmt->bind_param("i", $sesion);
    $stmt->execute();
    $stmt->bind_result($telefono);
    $stmt->fetch();
    $stmt->close();

    $telefono = preg_replace('/[^0-9]/', '', $telefono);
    if (strlen($telefono) === 8) {
        $telefono = substr($telefono, 0, 4) . '-' . substr($telefono, 4, 4);
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Subasta</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cssdepura.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
   <style>

.error-message {
    color: red;
    font-size: 0.875em;
}

body {
    padding-top: 50px;
}

.contaainer {
    max-width: 700px;
    margin: 0 auto;
    
}

.forms-contaainer {
    border: solid 3px #57070c;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 4px 15px rgba(87, 7, 12, 0.1);
    transition: box-shadow 0.3s ease;
}

.forms-contaainer:hover {
    box-shadow: 0px 4px 20px rgba(87, 7, 12, 0.2);
}

.form-label {
    font-weight: bold;
}

.btn-primary {
    border: 2px solid #ced4da; 
    color: #333; 
    font-weight: bold;
    padding: 10px 20px; 
    border-radius: 8px;
    margin-top: 25px;
    cursor: pointer;
    transition: background-color 0.3s, border-color 0.3s; 
}

.btn-primary:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
}


.preview-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px; 
    margin-top: 20px;
}

.preview-box {
    width: 200px; 
    height: 200px;
    border: 3px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
}

.preview-box:nth-child(4), .preview-box:nth-child(5) {
    margin-left: calc(40% - 265px); /* Ajusta 215px según el tamaño de las cajas y el gap */
    padding-top: 10px;
}


.preview-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
}

#file-input1, #file-input2, #file-input3, #file-input4, #file-input5 {
    display: none;
}

#preview1, #preview2, #preview3, #preview4, #preview5 {
    font-size: 1em;
    color: #888;
}

.color-input {
    -webkit-appearance: none;
    appearance: none;
    width: 30px; /* Ajusta el tamaño según sea necesario */
    height: 30px; /* Ajusta el tamaño según sea necesario */
    border-radius: 50%;
    border: 2px solid #ced4da; /* Color del borde */
    outline: none;
    cursor: pointer;
    padding: 0;
    background: none;
}

.color-input::-webkit-color-swatch-wrapper {
    padding: 0;
}

.color-input::-webkit-color-swatch {
    border-radius: 50%;
    border: none;
    padding: 0;
}

.color-input::-moz-color-swatch {
    border-radius: 50%;
    border: none;
}

input[type="color"] {
            width: 50px;
            height: 50px;
            padding: 0;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

    </style>
</head>
<body class="sb-nav-fixed">
    <nav>
        <?php include ("header.php"); ?>
    </nav>

    <div class="contaainer my-5">
        <div class="forms-contaainer">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Crear Subasta</h1>
                    <form method="POST" enctype="multipart/form-data" id="subasta-form">
                    <div class="mb-3">
                            <label for="nombre_producto" class="form-label custom-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                            <?php if (isset($errores['nombre_producto'])): ?>
                                <div class="error-message"><?= $errores['nombre_producto'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label custom-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            <?php if (isset($errores['descripcion'])): ?>
                                <div class="error-message"><?= $errores['descripcion'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="tamano_producto" class="form-label custom-label">Tamaño del Producto</label>
                            <input type="text" class="form-control" id="tamano_producto" name="tamano_producto" required>
                            <?php if (isset($errores['tamano_producto'])): ?>
                                <div class="error-message"><?= $errores['tamano_producto'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label custom-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono ?? '') ?>" readonly required>
                            </div>

                        <div class="mb-3">
                            <label for="color_producto" class="form-label custom-label">Color del Producto</label required>
                            <input type="color" class="form-control color-input" id="color_producto" name="color_producto" 
                            value="#000000">
                            <?php if (isset($errores['color_producto'])): ?>
                                <div class="error-message"><?= $errores['color_producto'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_producto" class="form-label custom-label">Categoría del Producto</label>
                            <select class="form-select" id="categoria_producto" name="categoria_producto" required>
                            <option value="">Selecciona la categoría</option>
                            <option value="Entretenimiento">Entretenimiento</option>
                            <option value="Moda Urbana">Moda Urbana</option>
                            </select>                            
                            <?php if (isset($errores['categoria_producto'])): ?>
                                <div class="error-message"><?= $errores['categoria_producto'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="estado_producto" class="form-label custom-label">Estado del Producto</label>
                            <select class="form-select" id="estado_producto" name="estado_producto" required>
                            <option value="">Selecciona el estado</option>
                            <option value="Nuevo">Nuevo</option>
                            <option value="Usado">Usado</option>
                            </select>                            <?php if (isset($errores['estado_producto'])): ?>
                                <div class="error-message"><?= $errores['estado_producto'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min" class="form-label">Precio mínimo:</label>
                                <input type="number" class="form-control" id="min" name="min" step="0.01" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="max" class="form-label">Precio máximo:</label>
                                <input type="number" class="form-control" id="max" name="max" step="0.01" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_cierre" class="form-label">Fecha de cierre:</label>
                                <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hora_cierre" class="form-label">Hora de cierre:</label>
                                <input type="time" class="form-control" id="hora_cierre" name="hora_cierre" required>
                            </div>
                        </div>
                        <div class="mb-3">
                        <label for="imagenes" class="form-label custom-label">Imágenes del Producto</label>
                        <div class="preview-container">
                            <div class="preview-box" onclick="document.getElementById('file-input1').click()">
                                <input type="file" name="imagen_producto" id="file-input1" onchange="previewImage(event, 'preview1')" style="display:none;">
                                <div id="preview1">Agregar</div>
                            </div>
                            <div class="preview-box" onclick="document.getElementById('file-input2').click()">
                                <input type="file" name="imagen2" id="file-input2" onchange="previewImage(event, 'preview2')" style="display:none;">
                                <div id="preview2">Agregar</div>
                            </div>
                            <div class="preview-box" onclick="document.getElementById('file-input3').click()">
                                <input type="file" name="imagen3" id="file-input3" onchange="previewImage(event, 'preview3')" style="display:none;">
                                <div id="preview3">Agregar</div>
                            </div>
                            <div class="preview-box" onclick="document.getElementById('file-input4').click()">
                                <input type="file" name="imagen4" id="file-input4" onchange="previewImage(event, 'preview4')" style="display:none;">
                                <div id="preview4">Agregar</div>
                            </div>
                            <div class="preview-box" onclick="document.getElementById('file-input5').click()">
                                <input type="file" name="imagen5" id="file-input5" onchange="previewImage(event, 'preview5')" style="display:none;">
                                <div id="preview5">Agregar</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="background-color: #57070c;">Crear Subasta</button>
                    </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const file = input.files[0];
            const previewBox = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    previewBox.innerHTML = ''; // Limpiar el contenido previo
                    previewBox.appendChild(img); // Agregar la imagen previsualizada
                }
                reader.readAsDataURL(file);
            } else {
                previewBox.innerHTML = 'Agregar'; // Mostrar 'Agregar' si no hay imagen seleccionada
            }
        }
    </script>

        <script>
        document.getElementById('subasta-form').addEventListener('submit', function(event) {
            const fechaCierreInput = document.getElementById('fecha_cierre');
            const horaCierreInput = document.getElementById('hora_cierre');
            
            const fechaCierre = new Date(fechaCierreInput.value);
            const horaCierre = horaCierreInput.value.split(':');
            fechaCierre.setHours(horaCierre[0]);
            fechaCierre.setMinutes(horaCierre[1]);

            const ahora = new Date();
            
            // Ajusta la hora actual para que coincida con la fecha actual
            const fechaAhora = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate(), ahora.getHours(), ahora.getMinutes());

            if (fechaCierre < fechaAhora) {
                alert('La fecha y hora de cierre deben ser en el futuro o en la misma fecha a partir de la hora actual.');
                event.preventDefault(); // Evita que el formulario se envíe
            }
        });
        </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/mood_oscuro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    <footer>
    <?php
    
    include ('footer.php');
    
    ?>
</footer>
</html>

