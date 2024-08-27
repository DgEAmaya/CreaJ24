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
    
    <div class="top-bar">
    
        <div class="izquierda">
            <a class="navbar-brand" href="../PHP/index.php">
            <img class="EstiloImagBS" src="../Imagenes/logo-mini.png" width="60">
        </a>
            <button class="toggle-btn" type="button" aria-expanded="false" aria-controls="menuItems">
                &#9776;
            </button>
        </div>
    
        <div class="derecha d-flex align-items-center toggle-menu-icon">
            
            <div id="google_translate_element" class="z-50 bg-black bottom-0 right-0"></div> 
            
            <div class="theme-toggle ms-4 mx-2">
                <button id="theme-button" class="btn btn-secondary px-2 py-1" onclick="cambiarTema()">
                    <i id="di-icon" class="bi bi-moon-fill"></i>
                </button>
            </div>

            <a href="../PHP/InicioSesion.php" class="nav-link"><button class="BotonLogiinregis"> <i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button></a>
            <a href="../PHP/Registros.php" class="nav-link"><button class="BotonLogiinregis"> <i class="fas fa-user-plus"></i> Registrarse</button></a>
        </div>
        
    </div>

    <nav class="vertical-nav" id="sideMenu">
        <div class="collapse show" id="menuItems">
            <ul class="navbar-nav flex-column mt-5">
                <li class="nav-item">
                    <a class="nav-link ps-3" href="../PHP/index.php"> <i class="bi bi-house-door-fill paraFueradeElotrodiv3 "></i> Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-3" href="#" id="CategoriDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#cateMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="bi bi-tag-fill"></i> Categorias <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="collapse" id="cateMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php">Entretenimiento</a></li>
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php">Moda Urbana</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-3" href="#" id="subastaDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#subMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="fas fa-gavel"></i> Subastas <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="collapse" id="subMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php ">Crear Subastas</a></li>
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php ">Mis Subastas</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-3" href="#" id="DonacionDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#donaMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="fas fa-donate classdeliconosmenus"></i> Donaciones <i class="bi bi-caret-down-fill "></i>
                    </a>
                    <div class="collapse" id="donaMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php">Realizar</a></li>
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php">Solicitar</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-3" href="../PHP/InicioSesion.php"> <i class="fas fa-file-alt paraFueradeElotrodiv"></i>Reclamos</a>
                </li>

                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-3" href="#" id="contactoDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#contaMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="fas fa-envelope"></i> Contáctanos <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="collapse" id="contaMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/InicioSesion.php">Correo Electronico</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-3" href="#"> <i class="fas fa-shield-alt paraFueradeElotrodiv2"></i>Políticas de Privacidad</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
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