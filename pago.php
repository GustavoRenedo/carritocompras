<?php
require_once "header.php";

if (!isset($_SESSION["cliente"]) || !isset($_GET["pedido"])) :
    include_once "404.php";
else :
    require_once "config/PayPal.php";
    require_once "php/OpcionesCarrito.php";
    $opcionesCarrito =  new OpcionesCarrito();
    $pedido = $opcionesCarrito->consultarPedido($_GET["pedido"]);
?>
    <!-- Incluye el SDK de JavaScript de PayPal -->
    <script src="<?php echo PAYPAL_BASEURL; ?>"></script>

    <div class="py-5">
        <div class="page-wrap d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <span class="display-1 d-block">¡Paso final!</span>

                        <div class="mb-4 lead">Para completar tu compra realiza el pago de $<?php echo $pedido["total"]; ?></div>
                        <div class="d-flex justify-content-center">
                            <!-- Configurar un elemento contenedor para el botón -->
                            <div id="paypal-button-container"></div>
                        </div>
                        <div class="mb-4 lead">Tu pedido ser&aacute; cancelado si no realizas el pago dentro de las pr&oacute;ximas 24 horas.</div>
                        <a href="Contacto/AtencionCliente.php" class="btn btn-link btn-lg">
                            <i class="fas fa-envelope"></i>
                            Contactar con soporte t&eacute;cnico
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Renderice el botón de PayPal en # paypal-button-container
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Esta función configura los detalles de la transacción, incluido el monto y los detalles del artículo de línea.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $pedido["total"]; ?>'
                        },
                        description: 'Compra de productos a Mi tienda Web: $<?php echo $pedido["total"]; ?>',
                        custom_id: '<?php echo $pedido["clavetransaccion"] . "#" . $pedido["id"]; ?>'
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Esta función captura los fondos de la transacción.
                return actions.order.capture().then(function(details) {
                    //console.log(data);
                    //console.log(actions);
                    //console.log(details);
                    window.location = "verificador.php?orderID="+data.orderID+"&status="+details.status;
                });
            }
        }).render('#paypal-button-container');
    </script>

<?php
endif;
require_once "footer.php";
?>