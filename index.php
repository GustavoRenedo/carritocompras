<?php require_once "header.php";
require_once "php/OpcionesProducto.php";

$opcionesProducto = new OpcionesProducto();
?>

<div class="py-3 tienda-fondos">
    <div class="container">
        <div class="row">
            <?php $listaDeProductos = $opcionesProducto->consultarListaDeProductos();
            foreach ($listaDeProductos as $producto) : ?>
                <div class="col col-md-6 col-lg-4 p-3 ">
                    <div class="card text-center" style="width: 18rem;">
                        <img class="card-img-top" src="img/<?php echo $opcionesProducto->consultarImagen($producto["id"])["imagen"]; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto["nombre"]; ?></h5>
                            <p class="card-text">$<?php echo $producto["precio"]; ?></p>
                            <a href="producto.php?id=<?php echo $producto["id"]; ?>" class="btn btn-success boton-ver">Ver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>