<?php
require_once "header.php";
if (!isset($_SESSION["usuario"])) :
    header("Location: login.php");
else :
    if (!isset($_GET["id"])) :
        include_once APP_HOST . "404.php";
    else :
        $pedido = $opcionesAdmin->consultarDetallePedido(intval($_GET["id"]));
        $lineaPedido = $opcionesAdmin->consultarPedido(intval($_GET["id"]));
        $pagos = $opcionesAdmin->consultarPagos(intval($_GET["id"]));
?>

        <div class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2>Pedido No. <?php echo $_GET["id"]; ?></h2>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Clave de la Transacci&oacute;n</b> </h4>
                        <p><?php echo $pedido["clavetransaccion"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Total</b> </h4>
                        <p><?php echo $pedido["total"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Fecha</b> </h4>
                        <p><?php echo $pedido["fecha"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Estatus de pedido</b> </h4>
                        <p><?php echo strtoupper($pedido["estatus"]); ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Cliente</b> </h4>
                        <p><?php echo $pedido["nombre"]." ".$pedido["apellidos"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Correo electr&oacute;nico</b> </h4>
                        <p><?php echo $pedido["email"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Tel&eacute;fonos</b> </h4>
                        <p><?php echo "Tel&eacute;fono: ".$pedido["telefono"]." Movil:".$pedido["movil"]; ?></p>
                    </div>
                    <div class="col-lg-4 col-md-6 p-4">
                        <h4> <b>Direccion</b> </h4>
                        <p>Calle: <?php echo $pedido["direccioncalle"]. " #".$pedido["numero"]; ?></p>
                        <p>CP: <?php echo $pedido["codigopostal"]; ?></p>
                        <p>Estado: <?php echo $pedido["estado"]; ?></p>
                        <p>Delegaci&oacute;n/Municipio: <?php echo $pedido["delegacionmunicipio"]; ?></p>
                        <p>Asentamiento/Colonia: <?php echo $pedido["asentamientocolonia"]; ?></p>
                        <p>Referencia: <?php echo $pedido["referencia"]; ?></p>
                    </div>
                    <div class="col-lg-12 col-md-12 p-4 text-center">
                        <h4> <b>Productos</b> </h4>
                    </div>
                    <div class="col-12 text-center">
                        <?php if ($lineaPedido->num_rows > 0) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Unidades</th>
                                            <th scope="col">Precio de venta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($lineaPedido as $pedido) : ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $pedido["nombre"]; ?></td>
                                                <td><?php echo $pedido["modelo"]; ?></td>
                                                <td><?php echo $pedido["marca"]; ?></td>
                                                <td><?php echo $pedido["unidades"]; ?></td>
                                                <td><?php echo $pedido["precioventa"]; ?></td>
                                            </tr>
                                        <?php $i++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <h2>¡No se encontraron datos!</h2>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12 col-md-12 p-4 text-center">
                        <h4> <b>Pagos</b> </h4>
                    </div>
                    <div class="col-lg-12 col-md-12 p-4 text-center">
                        <?php if ($pagos->num_rows > 0) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">M&eacute;todo de pago</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Correo electr&oacute;nico del comprador</th>
                                            <th scope="col">Createtime</th>
                                            <th scope="col">Updatetime</th>
                                            <th scope="col">Estado de pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($pagos as $pago) : ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $pago["metodopago"]; ?></td>
                                                <td><?php echo $pago["total"]; ?></td>
                                                <td><?php echo $pago["compradoremail"]; ?></td>
                                                <td><?php echo $pago["createtime"]; ?></td>
                                                <td><?php echo $pago["updatetime"]; ?></td>
                                                <td><?php echo $pago["estadopago"]; ?></td>
                                            </tr>
                                        <?php $i++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <h2>¡No se encontraron datos!</h2>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-12 col-md-12 p-4 text-center">
                        <a href="<?php echo APP_HOST."admin"; ?>">Regresar a la lista de pedidos</a>
                    </div>
                </div>
            </div>
        </div>

<?php
    endif;
endif;
require_once "footer.php";
?>