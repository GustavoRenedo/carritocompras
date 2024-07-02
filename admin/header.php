<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/dirs.php");
require_once ROOT_PATH . "php/OpcionesAdmin.php";
$opcionesAdmin = new OpcionesAdmin();

if (isset($_POST["accion"])) {
    switch ($_POST["accion"]) {
        case 'salir':
            $opcionesAdmin->cerrarSesion();
            break;
        default:
            # code...
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio Administrador</title>
    <link rel="stylesheet" href="<?php echo APP_HOST; ?>libs/bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APP_HOST; ?>libs/fontawesome-free-6.4.0-web1/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APP_HOST; ?>css/style11.css">
    
</head>

<body>
    <?php if (isset($_SESSION["usuario"])) : ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand text-primary" href="#">
                    <i class="fas d-inline fa-lg fa-circle"></i>
                    <img src="img_config/amg_logo1.png" alt="" width="80px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="nav navbar-nav mx-auto">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_HOST."admin"; ?>">Pedidos</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_HOST."admin/administrar-marcas.php"; ?>">Categorias</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo APP_HOST."admin/administrar-productos.php"; ?>">Productos</a> </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"> <a class="nav-link" href="#"><?php echo $_SESSION["usuario"]["nombreUsuario"]; ?></a> </li>
                        <li class="nav-item"> <a class="nav-link text-primary" onclick="frmLogout.submit()" href="#">salir</a> </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form name="frmLogout" method="post">
            <input type="hidden" name="accion" value="salir">
        </form>

    <?php endif; ?>