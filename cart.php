<?php require_once "header.php";
require_once "php/OpcionesCarrito.php";
$opcionesCarrito =  new OpcionesCarrito();

if (isset($_POST["accion"])) {
    switch ($_POST["accion"]) {
        case 'editarProducto':
            $opcionesCarrito->editarProducto($_POST);
            break;
        case 'quitarDelCarrito':
            $opcionesCarrito->quitarDelCarrito(intval($_POST['txtIdProducto']));
            break;
        case 'vaciarCarrito':
            $opcionesCarrito->vaciarCarrito();
            break;
        case 'pagarCompra':
            $opcionesCarrito->guardarPedido($_POST);
            break;
    }
}
?>

<div class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Lista de productos</h2>
            </div>
            <?php if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) : ?>
                <div class="py-1 col-12 col-sm-6 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <!-- <th scope="col">Caracter&iacute;stica</th> -->
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($_SESSION["carrito"]); $i++) :
                                    $producto = $_SESSION["carrito"][$i];
                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo ($i + 1); ?>
                                        </th>
                                        <td>
                                            <?php echo $producto['nombre']; ?>
                                        </td>
                                        <!-- <td>
                                            <?php //echo $producto['caracteristica']; 
                                            ?>
                                        </td> -->
                                        <td>
                                            <?php echo $producto['precio']; ?>
                                        </td>
                                        <form id="frmEditar<?php echo $producto['id']; ?>" action="" method="post">
                                            <td>
                                                <input type="hidden" name="accion" value="editarProducto">
                                                <input type="hidden" name="txtIdProducto" value="<?php echo $producto['id']; ?>">
                                                <input type="number" name="txtCantidad" min="1" max="<?php echo $opcionesCarrito->buscarExistencia($producto['id']); ?>" value="<?php echo $producto['cantidad']; ?>" style="width:60px;" required>

                                            </td>
                                            <td>
                                                <?php echo $producto['total']; ?>
                                            </td>
                                            <td>
                                                <input type="submit" class="btn btn-success" value="Editar">
                                            </td>
                                        </form>
                                        <td>
                                            <form id="frmQuitar<?php echo $producto['id']; ?>" action="" method="post">
                                                <input type="hidden" name="accion" value="quitarDelCarrito">
                                                <input type="hidden" name="txtIdProducto" value="<?php echo $producto['id']; ?>">
                                                <input type="submit" class="btn btn-danger" value="Eliminar">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                        <div class="d-flex flex-row-reverse">
                            <form id="frmVaciarCarrito" action="" method="post">
                                <input type="hidden" name="accion" value="vaciarCarrito">
                                <input type="submit" class="btn btn-danger" value="Vaciar carrito">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Resumen del pedido</h5>
                            <?php
                            $total = 0;
                            $articulo = 0;
                            foreach ($_SESSION["carrito"] as $producto) {
                                $articulo = $articulo + $producto['cantidad'];
                                $total = $total + $producto['total'];
                            }
                            ?>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><strong>Total: </strong></td>
                                        <td> $<?php echo $total; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Artículos: </strong></td>
                                        <td>
                                            <?php echo $articulo; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div>
                                <div class="form-group text-center">
                                    <?php if (isset($_SESSION["cliente"])) : ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="accion" value="pagarCompra">
                                            <input type="submit" value="Pagar">
                                        </form>
                                    <?php else : ?>
                                        ¡Debes <a href="cliente/login.php">iniciar sesi&oacute;n</a> o <a href="cliente/registro.php">crear una cuenta</a> para poder continuar con tu compra!
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="row justify-content-center ">
                    <div class="col-md-12 text-center ">
                        <span class="display-1 d-block"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="mb-4 lead">Oops! Tu carrito está vacío.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container py-3 text-center">
    <h4 for="mercadopagos">Paga con tu tarjeta de credito o debito</h4>
    <div class="row">
        <div class="col-md-12">
            <img src="" title="PayPal" alt="PlayPal - Medios de pago" width="575" height="30" class="img-fluid" />
        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>