<?php require_once "header.php";
require_once "php/OpcionesProducto.php";

$opcionesProducto = new OpcionesProducto();
if (isset($_GET["id"])) {
    $listaDeProductos = array();
    $marca = "";
    if (intval($_GET["id"]) > 0) {
        $listaDeProductos = $opcionesProducto->consultarListaDeProductos(intval($_GET["id"]));
        $marca = $opcionesProducto->consultarDatosDelaMarca(intval($_GET["id"]));
    }
} else {
    $listaDeProductos = $opcionesProducto->consultarListaDeProductos();
}
?>

<div class="py-3 tienda-fondos">
    <div class="container">
        <div class="row">
            <?php if (!empty($listaDeProductos)) : ?>
                <?php if (isset($marca) && !empty($marca)) : ?>
                    <div class="col-md-12 text-center text-white titulo-aviso">
                        <h3><?php echo $marca; ?></h3>
                    </div>
                <?php endif; ?>
                <?php foreach ($listaDeProductos as $producto) : ?>
                    <div class="col-md-4 col-6 p-3">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="img/<?php echo $opcionesProducto->consultarImagen($producto["id"])["imagen"]; ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto["nombre"]; ?></h5>
                                <p class="card-text">$<?php echo $producto["precio"]; ?></p>
                                <a href="producto.php?id=<?php echo $producto["id"]; ?>" class="btn btn-primary">Ver</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <span class="display-1 d-block">
                            <i class="fas fa-exclamation-circle"></i>
                        </span>
                        <div class="mb-4 lead">
                            Oops! Lo sentimos no se encontr&oacute; ning&uacute;n producto.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>