<?php
require_once "header.php";

if (!isset($_SESSION["cliente"]) || !isset($_GET["orderID"])) :
    include_once "404.php";
else :
    require_once "config/PayPal.php";
    require_once "php/OpcionesCarrito.php";
    $opcionesCarrito =  new OpcionesCarrito();
    $respuesta = $opcionesCarrito->consultarPago($_GET);

    if (!isset($respuesta['estado'])) :
        include_once "404.php";
    else :
?>

        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2><?php echo $configuracion['nombretienda']; ?></h2>
                    </div>
                    <hr>
                    <?php if ($respuesta['estado'] === 'ok') : ?>
                        <div class="col-md-6 py-1 text-center">
                            <strong>No. Pedido: <?php echo $respuesta['idPedido']; ?></strong>
                        </div>
                        <div class="col-md-6 py-1 text-center">
                            <?php echo $respuesta['createTime']; ?>
                        </div>
                        <hr>
                        <div class="col-md-12 py-1 text-center">
                            <h2>Estimado usuario</h2>
                            <span>Su pago fue exitoso, gracias por la compra.</span>
                        </div>
                        <div class="col-md-12 py-1 text-center">
                            <p class="">
                                <?php echo $respuesta['mensaje']; ?>
                            </p>
                        </div>
                    <?php elseif ($respuesta['estado'] === 'otro') : ?>
                        <div class="col-md-12 py-1 text-center">
                            <h3>Estimado usuario</h3>
                        </div>
                        <div class="col-md-12 py-1 text-center">
                            <p class="" style="color:#D70000; font-size:16px; font-weight:bold;">
                                <?php echo $respuesta['mensaje']; ?>
                            </p>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12 py-1 text-center">
                            <h3>Estimado usuario</h3>
                        </div>
                        <div class="col-md-12 py-1 text-center">
                            <p>
                                <?php echo $respuesta['mensaje']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

<?php
    endif;
endif;
require_once "footer.php";
?>