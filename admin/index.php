<?php
require_once "header.php";
if (!isset($_SESSION["usuario"])) :
    header("Location: login.php");
else :
    $arregloPedidos = array();

    if (isset($_POST["accion"])) {
        if ($_POST["accion"] == "buscarPedido") {
            $arregloPedidos = $opcionesAdmin->consultarPedidos(intval($_POST["txtIdPedido"]));
        }
        if ($_POST["accion"] == "cambiarEstadoDelPedido") {
            $opcionesAdmin->editarPedido($_POST);
            $arregloPedidos = $opcionesAdmin->consultarPedidos(intval($_POST["txtIdPedido"]));
        }
    } else {
        $arregloPedidos = $opcionesAdmin->consultarPedidos();
    }
?>

    <div class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Lista de pedidos</h2>
                </div>
                <div class="col-12">
                    <div class="py-3">
                        <form action="" method="post">
                            <input type="hidden" name="accion" value="buscarPedido">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="txtIdPedido" class="col-form-label">No. Pedido</label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" name="txtIdPedido" id="txtIdPedido" min="1" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No. Pedido</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($arregloPedidos->num_rows > 0) : ?>
                                    <?php foreach ($arregloPedidos as $producto) : ?>
                                        <tr>
                                            <th scope="row"><?php echo $producto["id"]; ?></th>
                                            <td><?php echo $producto["total"]; ?></td>
                                            <td><?php echo $producto["fecha"]; ?></td>
                                            <td>
                                                <?php if ($producto["estado"] != "entregado" && $producto["estado"] != "cancelado") : ?>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="accion" value="cambiarEstadoDelPedido">
                                                        <input type="hidden" name="txtIdPedido" value="<?php echo $producto["id"]; ?>">
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <select name="cbmEstado" id="cbmEstado" class="form-control">
                                                                    <option value="pendiente" <?php echo ($producto["estado"] == "pendiente") ? "selected" : ""; ?>>Pendiente</option>
                                                                    <option value="autorizado" <?php echo ($producto["estado"] == "autorizado") ? "selected" : ""; ?>>Autorizado</option>
                                                                    <option value="cancelado" <?php echo ($producto["estado"] == "cancelado") ? "selected" : ""; ?>>Cancelado</option>
                                                                    <option value="enviado" <?php echo ($producto["estado"] == "enviado") ? "selected" : ""; ?>>Enviado</option>
                                                                    <option value="entregado" <?php echo ($producto["estado"] == "entregado") ? "selected" : ""; ?>>Entregado</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="submit" class="btn btn-success" value="Editar">
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php else : ?>
                                                    <?php echo strtoupper($producto["estado"]); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo APP_HOST . "admin/detalle-pedido.php?id=" . $producto["id"]; ?>">Detalle</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron resultados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
endif;
require_once "footer.php";
?>