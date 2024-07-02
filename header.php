<?php
session_start();
require_once "php/OpcionesMenu.php";
$opcionesMenu = new OpcionesMenu();
$configuracion = $opcionesMenu->consultarConfiguracion();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $configuracion['nombretienda']; ?> | Tienda</title>
    <link rel="stylesheet" href="libs/bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="libs/fontawesome-free-6.4.0-web1/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="css/style11.css">
    <link rel="icon" href="img_config/icono.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-info menu-principal">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <img src="img_config/icono_amg.png" alt="" width="80px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <!--Menu principal y modificaciones -->

                <ul class="nav navbar-nav mx-auto">
                    <li class="nav-item "> <a class="nav-link menu-tienda" href="/">Inicio</a> </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle menu-tienda" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                            <li> <a class="dropdown-item" href="/">Mostrar todos</a> </li>
                            <?php $marcas = $opcionesMenu->consultarMarcas();
                            foreach ($marcas as $marca) : ?>
                                <li><a class="dropdown-item" href="marca.php?id=<?php echo $marca['id']; ?>"><?php echo $marca['nombre']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="nav-item"> <a class="nav-link menu-tienda" href="Contacto/AtencionCliente.php">Contacto</a> </li>


                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                                                echo "text-success";
                                            } ?>" href="cart.php">
                            <i class="fas fa-shopping-cart"></i>
                            
                        </a>
                    </li>


                    <?php if (isset($_SESSION["cliente"])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle menu-tienda" href="#" id="dropdownUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bienvenido <?php echo $_SESSION["cliente"]["nombreCliente"]; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownUsuario">
                                <li class="nav-item"> <a class="nav-link" href="cliente/index.php">Panel de usuario</a> </li>
                                <li class="nav-item"> <a class="nav-link" onclick="frmLogout.submit()" href="#">salir</a> </li>
                                <form name="frmLogout" method="post" action="cliente/index.php">
                                    <input type="hidden" name="accion" value="salir">
                                </form>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item"> <a class="nav-link menu-tienda" href="cliente/login.php">Iniciar sesión</a> </li>
                        <li class="nav-item"> <a class="nav-link menu-tienda" href="cliente/registro.php">Registrate</a> </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>