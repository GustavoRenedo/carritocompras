<?php require_once "header.php";
require_once "php/OpcionesProducto.php";
require_once "php/OpcionesCarrito.php";

if (isset($_POST["accion"])) {
    $opcionesCarrito =  new OpcionesCarrito();
    if ($_POST["accion"] === 'agregarAlCarrito') {
        $opcionesCarrito->agregarAlCarrito($_POST);
    }
}

if (isset($_GET['id'])) :

    $opcionesProducto = new OpcionesProducto();
    $idProducto = $_GET['id'];
    $producto = $opcionesProducto->consultarProducto($idProducto);

    if ($producto != null) :
        $imagenes = $opcionesProducto->consultarImagenes($idProducto);
?>
        <div class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php $i = 0;
                                foreach ($imagenes as $imagen) : ?>
                                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                                <?php $i++;
                                endforeach; ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php $i = 0;
                                foreach ($imagenes as $imagen) : ?>
                                    <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                                        <img src="img/<?php echo $imagen["imagen"]; ?>" class="d-block w-100" alt="...">
                                    </div>
                                <?php $i++;
                                endforeach; ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <h1><?php echo $producto["nombre"]; ?></h1>
                        <p>Modelo: <?php echo $producto["modelo"]; ?></p>
                        <p>Precio: $<?php echo $producto["precio"]; ?></p>
                        <h3>Descripci&oacute;n</h3>
                        <p><?php echo $producto["descripcion"]; ?></p>
                        <p for="">(<?php echo $producto["existencias"]; ?> Disponibles)</p>
                        <form action="" method="post">
                            <input type="hidden" name="accion" value="agregarAlCarrito">
                            <input type="hidden" name="txtIdProducto" value="<?php echo $producto['id']; ?>">
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="txtCantidad" class="form-control" min="1" max="<?php echo $producto["existencias"]; ?>" value="1" maxlength="3" require>
                                </div>
                                <div class="col">
                                    <input type="submit" class="btn btn-success" value="Añadir al carrito">
                                </div>
                            </div>
                        </form>
                        <div class="py-3">
                            <a href="/" class="btn btn-link">Seguir comprando</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    else :
        include_once "404.php";
    endif;
else :
    include_once "404.php";
endif; ?>
<?php require_once "footer.php"; ?>