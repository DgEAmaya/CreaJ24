<?php
require_once '../PHP/conexionn.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario que ha iniciado sesión
    $sesion = $_SESSION['idCliente'];

    // Obtener los datos del formulario
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $tamano_producto = $_POST['tamano_producto'];
    $color_producto = $_POST['color_producto'];
    $telefono = $_POST['telefono'];
    $categoria_producto = $_POST['categoria_producto'];
    $estado_producto = $_POST['estado_producto'];
    $tiempo_subasta = $_POST['tiempo_subasta'];
    $cantidad_inicial = $_POST['cantidad_inicial'];
    $imagenes = ['imagen_producto', 'imagen2', 'imagen3', 'imagen4', 'imagen5'];
    $imagenes_tipos_mime = [];
    $imagenes_datos = [];

    foreach ($imagenes as $key => $imagen) {
        if (isset($_FILES[$imagen]) && $_FILES[$imagen]['error'] == 0) {
            $imagen_producto = $_FILES[$imagen]['tmp_name'];
            $tipo_mime = $_FILES[$imagen]['type'];
            $imagen_contenido = file_get_contents($imagen_producto);
            $imagenes_datos[$key] = $imagen_contenido;
            $imagenes_tipos_mime[$key] = $tipo_mime; // Añadir el tipo MIME
        } else {
            $imagenes_datos[$key] = null;
            $imagenes_tipos_mime[$key] = null; // Tipo MIME vacío
        }
    }

    // Consulta SQL ajustada
    $sql = "INSERT INTO subastas (
            nombre_producto, tamano_producto, color_producto, telefono, categoria_producto, 
            estado_producto, tiempo_subasta, cantidad_inicial, usuario, 
            imagen_producto, tipo_mime, imagen2, tipo_mime2, imagen3, tipo_mime3, 
            imagen4, tipo_mime4, imagen5, tipo_mime5, descripcion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conex->prepare($sql);
    
    if ($stmt === false) {
        die('Error en prepare: ' . htmlspecialchars($conex->error));
    }

    // Asegúrate de que el tipo de datos y el número de parámetros coincidan
    $stmt->bind_param("ssssssssssssssssssss", 
        $nombre_producto, $tamano_producto, $color_producto, $telefono, $categoria_producto, 
        $estado_producto, $tiempo_subasta, $cantidad_inicial, $sesion, 
        $imagenes_datos[0], $imagenes_tipos_mime[0], 
        $imagenes_datos[1], $imagenes_tipos_mime[1], 
        $imagenes_datos[2], $imagenes_tipos_mime[2], 
        $imagenes_datos[3], $imagenes_tipos_mime[3], 
        $imagenes_datos[4], $imagenes_tipos_mime[4], $descripcion);

    if ($stmt->execute()) {
        echo '<script>alert("Los datos han sido guardados correctamente."); window.location.href = "index.php";</script>';
        exit;
    } else {
        echo "Error al ejecutar la consulta: " . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Subasta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/cssdepura.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            background-color: #808080;
        }

        .contaainer {
            max-width: 800px;
            margin-left: 500px;
            margin: 0 auto;
        }

        .forms-container {
            border: solid 3px #57070c;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 15px rgba(87, 7, 12, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0px 4px 20px rgba(87, 7, 12, 0.2);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #57070c;
        }

        .btn-primary:hover {
            background-color: #357ab7;
            border-color: #357ab7;
        }

        .preview-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .preview-container .preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .theme-toggle {
            position: fixed;
            top: 10px;
            right: 20px;
        }

        .preview-container {
    display: flex;
    justify-content: space-between;
    }

    .preview-box {
        width: 150px; /* Ajusta el tamaño según tus necesidades */
        height: 150px;
        border: 2px dashed #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Mantener proporciones y ajustar dentro del cuadro */
    }
    

    </style>
</head>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

<body class="sb-nav-fixed">
    
    <nav>
    <?php include ("header.php"); ?>
    </nav>

    <div class="contaainer my-5">
        <div class="forms-container">
            <h1 class="mb-4 text-center">Crear Subasta</h1>
            <form id="product-data-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                </div>
                <div class="mb-3">
                    <label for="tamano_producto" class="form-label">Tamaño del Producto (cm)</label>
                    <input type="number" class="form-control" id="tamano_producto" name="tamano_producto" required>
                </div>
                <div class="mb-3">
                    <label for="color_producto" class="form-label">Color del Producto</label>
                    <input type="color" class="form-control form-control-color" id="color_producto" name="color_producto" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Número Telefónico</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="categoria_producto" class="form-label">Categoría del Producto</label>
                    <select class="form-select" id="categoria_producto" name="categoria_producto" required>
                        <option value="">Selecciona la categoría</option>
                        <option value="Entretenimiento">Entretenimiento</option>
                        <option value="Moda Urbana">Moda Urbana</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="estado_producto" class="form-label">Estado del Producto</label>
                    <select class="form-select" id="estado_producto" name="estado_producto" required>
                        <option value="">Selecciona el estado</option>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Usado">Usado</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tiempo_subasta" class="form-label">Tiempo de Subasta</label>
                    <input type="datetime-local" class="form-control" id="tiempo_subasta" name="tiempo_subasta" required>
                </div>
                <div class="mb-3">
                    <label for="cantidad_inicial" class="form-label">Cantidad Inicial de la Subasta</label>
                    <input type="number" class="form-control" id="cantidad_inicial" name="cantidad_inicial" required placeholder="$">
                </div>
                <div class="preview-container">
                        <div class="preview-box" onclick="document.getElementById('file-input1').click()">
                            <input type="file" name="imagen_producto" id="file-input1" onchange="previewImage(event, 'preview1')" style="display:none;">
                            <div id="preview1">ADD</div>
                        </div>
                        <div class="preview-box" onclick="document.getElementById('file-input2').click()">
                            <input type="file" name="imagen2" id="file-input2" onchange="previewImage(event, 'preview2')" style="display:none;">
                            <div id="preview2">ADD</div>
                        </div>
                        <div class="preview-box" onclick="document.getElementById('file-input3').click()">
                            <input type="file" name="imagen3" id="file-input3" onchange="previewImage(event, 'preview3')" style="display:none;">
                            <div id="preview3">ADD</div>
                        </div>
                        <div class="preview-box" onclick="document.getElementById('file-input4').click()">
                            <input type="file" name="imagen4" id="file-input4" onchange="previewImage(event, 'preview4')" style="display:none;">
                            <div id="preview4">ADD</div>
                        </div>
                        <div class="preview-box" onclick="document.getElementById('file-input5').click()">
                            <input type="file" name="imagen5" id="file-input5" onchange="previewImage(event, 'preview5')" style="display:none;">
                            <div id="preview5">ADD</div>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary w-100">Crear Subasta</button>
            </form>
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
        previewBox.innerHTML = 'ADD'; // Mostrar 'ADD' si no hay imagen seleccionada
    }
}
     </script>
    <footer>
        <?php
        include('footer.php');
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
