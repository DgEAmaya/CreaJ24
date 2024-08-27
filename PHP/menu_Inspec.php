<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/MenuNewCSS.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
        .theme-toggle button {
        background-color: transparent; 
        border: none; 
        }

        .theme-toggle i {
            font-size: 20px; 
            color: #fff; 
        }       

</style>
<body>

<?php
include_once('conexionn.php');

if ($conex->connect_error) {
    die("Conexión fallida: " . $conex->connect_error);
}

$sql = "SELECT PrimerNombre, PrimerApellido FROM cliente WHERE rol = 2";
$result = $conex->query($sql);

$PrimerNombre = "";
$PrimerApellido = "";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $PrimerNombre = $row["PrimerNombre"];
        $PrimerApellido = $row["PrimerApellido"];
    }
} else {
    $PrimerNombre = "No disponible";
    $PrimerApellido = "";
}
$conex->close();
?>

<div class="top-bar">
    <div class="izquierda">
        <a class="navbar-brand" href="../PHP/index.php">
            <img class="EstiloImagBS" src="../Imagenes/logo-mini.png" width="60">
        </a>
        <button class="toggle-btn" type="button" aria-expanded="false" aria-controls="menuItems">
            &#9776;
        </button>
    </div>

    <div class="derecha d-flex align-items-center toggle-menu-icon" style="cursor: pointer;">

        <div id="google_translate_element" class="z-50 bg-black bottom-0 right-0 fixed"></div>
        

        <div class="theme-toggle ms-4 mx-2">
            <button id="theme-button" class="btn btn-secondary px-2 py-1" onclick="cambiarTema()">
                <i id="di-icon" class="bi bi-moon-fill"></i>
            </button>
        </div>

        <style>
            .theme-toggle button {
                background-color: transparent; 
                border: none; 
            }

            .theme-toggle i {
                font-size: 20px; 
                color: #fff; 
            }
                
        </style>

        <a href="#  " class="nav-link px-2">
            <h3 style="color: #FFFFFF; font-size:2rem;"><?php echo $PrimerNombre . " " . $PrimerApellido; ?></h3>
        </a>
        <i class="bi bi-caret-down-fill toggle-menu-icon me-4" style="cursor: pointer;"></i>

    </div>

    <div class="floating-menu p-2 mx-4" id="floatingMenu">
        <ul>
            <li class="nav-item my-2 mt-3">
                <a class="nav-link ps-3" href="../PHP/perfil.php"> <i class="fas fa-file-alt paraFueradeElotrodiv"></i>Perfil</a>
            </li>

            <a class="ButtoonnCerrar my-2" href="../PHP/cerrar_sesion.php">
                <button class="BotonLogiinregis">Cerrar Sesion</button>
            </a>
        </ul>
    </div>
</div>


    <nav class="vertical-nav" id="sideMenu">
        <div class="collapse show" id="menuItems">
            <ul class="navbar-nav flex-column mt-5">
                <li class="nav-item">
                    <a class="nav-link ps-4 mr-4" href="../PHP/Inspector.php"> <i class="bi bi-house-door-fill paraFueradeElotrodiv3 "></i> Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ps-4" href="../PHP/SolicitudesInspec.php"><i class="bi bi-envelope-paper-heart-fill paraFueradeElotrodiv icon-margin"></i>Notificaciones</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ps-4" href="../PHP/historialInspec.php"><i class="bi bi-clock-fill paraFueradeElotrodiv icon-margin"></i>Historial</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ps-4" href="../PHP/PolíticasInspe.php"> <i class="fas fa-shield-alt paraFueradeElotrodiv2 icon-margin"></i>Políticas</a>
                </li>
            </ul>
            
        </div>
        
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    
    
    <script type="text/javascript">
    document.querySelector('.toggle-menu-icon').addEventListener('click', function() {
    var menu = document.getElementById('floatingMenu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
});



window.addEventListener('click', function(e) {
    var menu = document.getElementById('floatingMenu');
    if (!e.target.matches('.toggle-menu-icon')) {
        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        }
    }
});
</script>

    <script>
        document.querySelector('.top-bar .toggle-btn').addEventListener('click', function() {
            const sideMenu = document.getElementById('sideMenu');
            if (sideMenu.classList.contains('show')) {
                sideMenu.classList.remove('show');
            } else {
                sideMenu.classList.add('show');
            }
        });
    </script>


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
