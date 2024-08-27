<?php
session_start();
require_once '../PHP/conexionn.php';

// Verifica si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
    $id_subasta = intval($_GET['id']);
    $nombre_producto = htmlspecialchars($_POST['nombre_producto']);
    $tamano_producto = htmlspecialchars($_POST['tamano_producto']);
    $color_producto = htmlspecialchars($_POST['color_producto']);
    $estado_producto = htmlspecialchars($_POST['estado_producto']);
    $categoria_producto = htmlspecialchars($_POST['categoria_producto']);
    $descripcion = htmlspecialchars($_POST['descripcion']);

    $imagenes = ['imagen_producto', 'imagen2', 'imagen3', 'imagen4', 'imagen5'];
    $imagenes_datos = [];
    $imagenes_tipos_mime = [];

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

    // Construir la consulta SQL con parámetros opcionales para imágenes
    $sql_update = "UPDATE subastas 
                   SET nombre_producto=?, tamano_producto=?, color_producto=?, estado_producto=?, categoria_producto=?, 
                       descripcion=?, 
                       imagen_producto=COALESCE(?, imagen_producto),
                       tipo_mime=COALESCE(?, tipo_mime),
                       imagen2=COALESCE(?, imagen2),
                       tipo_mime2=COALESCE(?, tipo_mime2),
                       imagen3=COALESCE(?, imagen3),
                       tipo_mime3=COALESCE(?, tipo_mime3),
                       imagen4=COALESCE(?, imagen4),
                       tipo_mime4=COALESCE(?, tipo_mime4),
                       imagen5=COALESCE(?, imagen5),
                       tipo_mime5=COALESCE(?, tipo_mime5)
                   WHERE id=?";
    
    $stmt = $conex->prepare($sql_update);
    if ($stmt === false) {
        die('Error en prepare: ' . htmlspecialchars($conex->error));
    }

    $stmt->bind_param("ssssssssssssssssi",
        $nombre_producto, $tamano_producto, $color_producto, $estado_producto, $categoria_producto, 
        $descripcion,
        $imagenes_datos[0], $imagenes_tipos_mime[0], 
        $imagenes_datos[1], $imagenes_tipos_mime[1], 
        $imagenes_datos[2], $imagenes_tipos_mime[2], 
        $imagenes_datos[3], $imagenes_tipos_mime[3], 
        $imagenes_datos[4], $imagenes_tipos_mime[4], 
        $id_subasta
    );

    if ($stmt->execute()) {
        header("Location: detalle_subasta1.php?id=" . $id_subasta);
        exit();
    } else {
        echo "Error al actualizar la subasta: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

// Obtener detalles de la subasta para prellenar el formulario
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_subasta = (int)$_GET['id'];

    $sql = "SELECT * FROM subastas WHERE id = ?";
    $stmt = $conex->prepare($sql);
    $stmt->bind_param("i", $id_subasta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_producto = $row['nombre_producto'];
        $tamano_producto = $row['tamano_producto'];
        $color_producto = $row['color_producto'];
        $estado_producto = $row['estado_producto'];
        $categoria_producto = $row['categoria_producto'];
        $descripcion = $row['descripcion'];
        // Cargar los datos de las imágenes
        $imagenes = [
            'imagen_producto' => ['data' => $row['imagen_producto'], 'type' => $row['tipo_mime']],
            'imagen2' => ['data' => $row['imagen2'], 'type' => $row['tipo_mime2']],
            'imagen3' => ['data' => $row['imagen3'], 'type' => $row['tipo_mime3']],
            'imagen4' => ['data' => $row['imagen4'], 'type' => $row['tipo_mime4']],
            'imagen5' => ['data' => $row['imagen5'], 'type' => $row['tipo_mime5']],
        ];
    } else {
        echo "Subasta no encontrada.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID de subasta no proporcionado o no válido.";
    exit;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Subasta</title>
    <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-container {
            display: flex;
            justify-content: space-between;
        }
        .preview-box {
            width: 150px;
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
            object-fit: contain;
        }
    </style>
</head>

<body class="sb-nav-fixed">


    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4 text-center">Editar Subasta</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($nombre_producto); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tamano_producto" class="form-label">Tamaño del Producto (cm)</label>
                        <input type="text" class="form-control" id="tamano_producto" name="tamano_producto" value="<?php echo htmlspecialchars($tamano_producto); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="color_producto" class="form-label">Color del Producto</label>
                        <input type="text" class="form-control" id="color_producto" name="color_producto" value="<?php echo htmlspecialchars($color_producto); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="estado_producto" class="form-label">Estado del Producto</label>
                        <select class="form-select" id="estado_producto" name="estado_producto">
                            <option value="Nuevo" <?php if ($estado_producto == 'Nuevo') echo 'selected'; ?>>Nuevo</option>
                            <option value="Usado" <?php if ($estado_producto == 'Usado') echo 'selected'; ?>>Usado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categoria_producto" class="form-label">Categoría del Producto</label>
                        <select class="form-select" id="categoria_producto" name="categoria_producto">
                            <option value="Entretenimiento" <?php if ($categoria_producto == 'Entretenimiento') echo 'selected'; ?>>Entretenimiento</option>
                            <option value="Moda Urbana" <?php if ($categoria_producto == 'Moda Urbana') echo 'selected'; ?>>Moda Urbana</option>
                        </select>
                    </div>
                    <div class="preview-container">
                        <?php foreach ($imagenes as $key => $imagen): ?>
                            <div class="preview-box" onclick="document.getElementById('file-input-<?php echo $key; ?>').click()">
                                <input type="file" name="<?php echo $key; ?>" id="file-input-<?php echo $key; ?>" onchange="previewImage(event, 'preview-<?php echo $key; ?>')" style="display:none;">
                                <div id="preview-<?php echo $key; ?>">
                                    <?php if ($imagen['data']): ?>
                                        <img src="data:<?php echo $imagen['type']; ?>;base64,<?php echo base64_encode($imagen['data']); ?>" alt="Imagen">
                                    <?php else: ?>
                                        ADD
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Actualizar Subasta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            var input = event.target;
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(previewId).innerHTML = '<img src="' + e.target.result + '" alt="Imagen" style="max-width: 100%; max-height: 100%;">';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
