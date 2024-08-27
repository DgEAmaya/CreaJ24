<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>
  <link rel="shortcut icon" href="../Imagenes/logo-mini.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/cssdepura.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- el css de el menu -->
  <link rel="stylesheet" href="../css/MenuNewCSS.css">
  
  <script>
    function confirmDelete(id) {
      if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
        window.location.href = `delete_user.php?idCliente=${id}`;
      }
    }
  </script>

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

</head>

<?php
  include_once('conexionn.php');
  session_start();
  $id = $_SESSION['idCliente'];
  $sql = "SELECT PrimerNombre, PrimerApellido FROM cliente where idCliente= $id";
    $resultado = $myconn->query($sql);

    $PrimerNombre = $row['PrimerNombre'];
    $PrimerApellido = $row['PrimerApellido'];

    $PrimerNombre = "";
    $PrimerApellido = "";
    
?>

<body class="sb-nav-fixed">


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

        <a href="#  " class="nav-link px-2">
            <h3 style="color: #FFFFFF; font-size:2rem;"><?php echo $PrimerNombre," ", $PrimerApellido; ?></h3>
        </a>
        <i class="bi bi-caret-down-fill toggle-menu-icon me-4" style="cursor: pointer;"></i>
        <i class="bi bi-bell-fill me-4"></i>

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
                    <a class="nav-link ps-4 mr-4" href="../PHP/admin.php"> <i class="bi bi-house-door-fill paraFueradeElotrodiv3 "></i> Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-4" href="#" id="CategoriDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#cateMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="bi bi-tag-fill"></i> Usuarios <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="collapse" id="cateMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/agregar.php">Agregar</a></li>
                            <li><a class="dropdown-item" href="../PHP/usuarios.php">Ver usuarios</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-4" href="#" id="subastaDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#subMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="fas fa-gavel"></i> Subastas <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="collapse" id="subMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/entretenimiento_admin.php">Entretenimiento</a></li>
                            <li><a class="dropdown-item" href="../PHP/Moda_admin.php">Moda</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-4" href="#" id="DonacionDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#donaMenu" aria-expanded="false" aria-controls="subMenu">
                        <i class="fas fa-donate classdeliconosmenus"></i> Donaciones <i class="bi bi-caret-down-fill "></i>
                    </a>
                    <div class="collapse" id="donaMenu">
                        <ul class="navbar-nav">
                            <li><a class="dropdown-item" href="../PHP/DonacionesSolicitadas.php">Solicitudes:</a></li>
                            <li><a class="dropdown-item" href="../PHP/.php">Donaciones realizadas</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                <a class="nav-link ps-4" href="../PHP/Reclamos_visual.php">
                  <i class="fas fa-file-alt paraFueradeElotrodiv icon-margin"></i> Reclamos
                  </a>
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
  <img src="../Imagenes/9.png" width="100%" class="img-fluid max-width: 100%;" alt="imgDonaciones">

  <section>
    <div class="usuariosVista">
      <h2>Usuarios registrados</h2>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col">id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Dui</th>
            <th scope="col">Telefono</th>
            <th scope="col">Contraseña</th>
            <th scope="col">Rol</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
        <?php
 
 if ($conex == true) { 
  if ($sql) {
      while ($row = $resultado->fetch_array()) {
          $id = $row['idCliente'];
          $PrimerNombre = $row['PrimerNombre'];
          $SegundoNombre = $row['SegundoNombre'];
          $PrimerApellido = $row['PrimerApellido'];
          $SegundoApellido = $row['SegundoApellido'];
          $email = $row['email'];
          $ubi = $row['direccion'];
          $telefono = $row['telefono'];
          $Contraseña = $row['contraseña'];
          $Rol = $row['Rol'];
            
?>
          <tr>
            <th> <?php echo $id?> </th>
            <th> <?php echo "$PrimerNombre"," ", "$SegundoNombre"," ", "$PrimerApellido"," ", "$SegundoApellido" ?> </th>
            <th> <?php echo $email ?> </th>
            <th> <?php echo $ubi?> </th>
            <th> <?php echo $telefono ?> </th>
            <th> <?php echo $Contraseña ?> </th>
            <th> <?php echo $Rol ?> </th>
            <th class="d-flex">
              <a class="visual" href="edit_user.php?idCliente=<?php echo $row['idCliente']?>"><button class="btn reseñasbtn btn-warning"><i class="bi bi-pencil-fill"></i></button></a>
              <a class="visual" href="#" onclick="confirmDelete('<?php echo $row['idCliente']?>')"><button class="btn reseñasbtn btn-danger"><i class="bi bi-trash3-fill"></i></button></a>
            </th>            
          </tr>
          <?php 
                }
              }
            } 
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

<footer>
  <?php include ('footer.php') ?>
</footer>

</html>
