<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/dirs.php");
require_once CONFIG_PATH . "Conexion.php";
require_once CONFIG_PATH . "PayPal.php";

class OpcionesCarrito extends Conexion
{

    public function buscarExistencia(int $id)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT existencias FROM Producto WHERE id = ? ");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $existencias = $resultado->fetch_array()['existencias'];
        } else {
            $existencias = 0;
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $existencias;
    }

    public function obtenerCaracteristicaDelProducto(int $id)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, nombre, precio, existencias FROM Producto WHERE id = ? ");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $producto = $resultado->fetch_array();
        } else {
            $producto = null;
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $producto;
    }

    public function agregarAlCarrito(array $post)
    {
        if (isset($_SESSION['carrito'])) {

            $productoEncontrado = false;
            $arrayTemporal = array();

            foreach ($_SESSION['carrito'] as $producto) {
                $datosProducto = $this->obtenerCaracteristicaDelProducto($producto["id"]);
                $cantidad = $producto["cantidad"];
                $precio = $datosProducto['precio'];

                if ($producto["id"] === intval($post['txtIdProducto'])) {
                    $cantidad = $producto["cantidad"] + intval($post['txtCantidad']);
                    if ($cantidad > $datosProducto['existencias']) {
                        $cantidad = $datosProducto['existencias'];
                    }
                    $precio = $datosProducto['precio'] * $cantidad;
                    $productoEncontrado = true;
                }

                $producto = array(
                    'id' => $producto["id"],
                    'nombre' => $datosProducto['nombre'],
                    'cantidad' => $cantidad,
                    'caracteristica' => array(),
                    'precio' => $datosProducto['precio'],
                    'total' => $precio
                );
                array_push($arrayTemporal, $producto);
            }

            if (!$productoEncontrado) {
                $datosProducto = $this->obtenerCaracteristicaDelProducto(intval($post['txtIdProducto']));

                if ($datosProducto != null) {
                    $cantidad = intval($post['txtCantidad']);
                    if ($cantidad > $datosProducto['existencias']) {
                        $cantidad =  $datosProducto['existencias'];
                    }
                    $producto = array(
                        'id' => intval($post['txtIdProducto']),
                        'nombre' => $datosProducto['nombre'],
                        'cantidad' => $cantidad,
                        'caracteristica' => array(),
                        'precio' => $datosProducto['precio'],
                        'total' => $datosProducto['precio']
                    );
                    array_push($arrayTemporal, $producto);
                }
            }

            $_SESSION['carrito'] = $arrayTemporal;
        } else {

            $datosProducto = $this->obtenerCaracteristicaDelProducto($post['txtIdProducto']);

            if ($datosProducto != null) {
                $cantidad = intval($post['txtCantidad']);
                if ($cantidad > $datosProducto['existencias']) {
                    $cantidad =  $datosProducto['existencias'];
                }
                $_SESSION['carrito'] = array(
                    [
                        'id' => intval($post['txtIdProducto']),
                        'nombre' => $datosProducto['nombre'],
                        'cantidad' => $cantidad,
                        'caracteristica' => array(),
                        'precio' => $datosProducto['precio'],
                        'total' => $datosProducto['precio']
                    ]
                );
            }
        }

        header("Location: producto.php?id=" . $post['txtIdProducto']);
    }

    public function editarProducto(array $post)
    {
        $arrayTemporal = array();
        foreach ($_SESSION['carrito'] as $producto) {
            $datosProducto = $this->obtenerCaracteristicaDelProducto($producto["id"]);

            $cantidad = $producto["cantidad"];
            $precio = $datosProducto["precio"];

            if ($producto["id"] === intval($post['txtIdProducto'])) {
                $cantidad =  intval($post['txtCantidad']);
                if ($cantidad > $datosProducto['existencias']) {
                    $cantidad = $datosProducto['existencias'];
                }
                $precio = $datosProducto['precio'] * $cantidad;
            }

            $producto = array(
                'id' => $producto["id"],
                'nombre' => $datosProducto['nombre'],
                'cantidad' => $cantidad,
                'caracteristica' => array(),
                'precio' => $datosProducto['precio'],
                'total' => $precio
            );
            array_push($arrayTemporal, $producto);
        }
        $_SESSION['carrito'] = $arrayTemporal;
    }

    public function quitarDelCarrito(int $id)
    {
        $arrayTemporal = array();
        foreach ($_SESSION['carrito'] as $producto) {
            if ($producto["id"] != $id) {
                array_push($arrayTemporal, $producto);
            }
        }
        $_SESSION['carrito'] = $arrayTemporal;
        header("Location: cart.php");
    }

    public function vaciarCarrito()
    {
        unset($_SESSION['carrito']);
        header("Location: cart.php");
    }

    public function guardarPedido(array $post)
    {

        if ($post == null) {
            return false;
        } else {

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            $total = 0;
            foreach ($_SESSION["carrito"] as $producto) {
                $total = $total + $producto['total'];
            }

            $idcliente = $_SESSION["cliente"]["idCliente"];
            $clavetransaccion = strval(session_id());
            $total = floatval($total);
            $fecha = strval(date(DateTime::ISO8601));
            $estado = "pendiente";

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO Pedido
            (idcliente, clavetransaccion, total, fecha, estado)
            VALUES (?,?,?,?,?)");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "isdss",
                $idcliente,
                $clavetransaccion,
                $total,
                $fecha,
                $estado
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                $idpedido = $conexion->insert_id;
                if ($this->registrarLineaDePedido($_SESSION["carrito"], $idpedido, $conexion)) {
                    unset($_SESSION['carrito']);
                    header("Location: pago.php?pedido=" . $idpedido);
                }
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();
        }
    }

    public function registrarLineaDePedido(array $carrito, int $idpedido, $conexion)
    {

        if ($carrito == null) {
            return false;
        } else {

            foreach ($carrito as $producto) {

                $idproducto = $producto["id"];
                $unidades = $producto["cantidad"];
                $precioventa = $producto["precio"];

                // Prepara la consulta
                $sentencia = $conexion->prepare("INSERT INTO LineaPedido
                (idpedido, idproducto, unidades, precioventa) 
                VALUES (?,?,?,?)");

                // ligar par&aacute;metros para marcadores
                $sentencia->bind_param(
                    "iiid",
                    $idpedido,
                    $idproducto,
                    $unidades,
                    $precioventa
                );

                // se ejecuta la consulta
                if ($sentencia->execute()) {
                    return $this->actualizarExistencias($unidades, $idproducto, $conexion);
                } else {
                    return false;
                }
            }
        }
    }

    public function actualizarExistencias(int $unidades, int $idproducto, $conexion)
    {
        $sentencia = $conexion->prepare("SELECT existencias FROM Producto WHERE id = ? ");
        $sentencia->bind_param("i", $idproducto);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $existencias = $resultado->fetch_array()['existencias'];
            if ($existencias > 0) {

                $nuevaExistencia = $existencias - $unidades;
                $sentencia = $conexion->prepare("UPDATE Producto SET existencias= ? WHERE id = ?");
                $sentencia->bind_param(
                    "ii",
                    $nuevaExistencia,
                    $idproducto
                );
                if ($sentencia->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function consultarPedido(int $idPedido)
    {
        $pedido = null;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, idcliente, clavetransaccion, total, fecha, estado FROM Pedido WHERE id = ? AND estado = 'pendiente'");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param("i", $idPedido);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $pedido = $resultado->fetch_array();
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $pedido;
    }

    private function guardarDatosDelPago(array $datosPago)
    {
        if ($datosPago == null) {
            return false;
        } else {
            $guardado = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO Pago
            (idorder, metodopago, idpedido, total, 
            compradoremail, createtime, updatetime, estadopago) 
            VALUES (?,?,?,?,?,?,?,?)");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "ssidssss",
                $datosPago["idorder"],
                $datosPago["metodopago"],
                $datosPago["idpedido"],
                $datosPago["total"],
                $datosPago["compradoremail"],
                $datosPago["createtime"],
                $datosPago["updatetime"],
                $datosPago["estadopago"]
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                $guardado = true;
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();

            return $guardado;
        }
    }

    private function actualizarEstadoDelPedido(string $estado, int $idPedido)
    {
        $guardado = false;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("UPDATE Pedido SET estado= ? WHERE id = ?");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param(
            "si",
            $estado,
            $idPedido
        );

        // se ejecuta la consulta
        if ($sentencia->execute()) {
            $guardado = true;
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $guardado;
    }

    public function consultarestadoDelPedido(int $idPedido)
    {
        $pedido = null;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT estado FROM Pedido WHERE id = ?");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param("i", $idPedido);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $pedido = $resultado->fetch_array()["estado"];
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $pedido;
    }

    private function consultarTokenPaypal()
    {

        $curlToken = curl_init();
        curl_setopt($curlToken, CURLOPT_URL, PAYPAL_APIURL . "v1/oauth2/token");
        curl_setopt($curlToken, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlToken, CURLOPT_HTTPHEADER, array("Accept: application/json", "Accept-Language: en_US"));
        curl_setopt($curlToken, CURLOPT_USERPWD, PAYPAL_CLIENTID . ":" . PAYPAL_SECRET);
        curl_setopt($curlToken, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $respuesta = curl_exec($curlToken);
        $objRespuesta = json_decode($respuesta);
        curl_close($curlToken);

        return $objRespuesta->access_token;
    }

    public function consultarPago(array $get)
    {

        $accessToken = $this->consultarTokenPaypal();;

        $curlDetallePedido = curl_init();
        curl_setopt($curlDetallePedido, CURLOPT_URL, PAYPAL_APIURL . "v2/checkout/orders/" . $get["orderID"]);
        curl_setopt($curlDetallePedido, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlDetallePedido, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $accessToken));

        $respuestaPedido = curl_exec($curlDetallePedido);
        $objRespuestaPedido = json_decode($respuestaPedido);
        curl_close($curlDetallePedido);

        if (!isset($objRespuestaPedido->name) || $objRespuestaPedido->name != "RESOURCE_NOT_FOUND") {
            $idpedido = explode("#", $objRespuestaPedido->purchase_units[0]->custom_id);

            $estado = $this->consultarestadoDelPedido($idpedido[1]);
            if ($estado === "pendiente") {
                if ($objRespuestaPedido->status === "COMPLETED") {

                    $datosPago = array(
                        "idorder" => $objRespuestaPedido->id,
                        "metodopago" => "PayPal",
                        "idpedido" => $idpedido[1],
                        "total" => $objRespuestaPedido->purchase_units[0]->amount->value,
                        "compradoremail" => $objRespuestaPedido->purchase_units[0]->payee->email_address,
                        "createtime" => $objRespuestaPedido->purchase_units[0]->payments->captures[0]->create_time,
                        "updatetime" => $objRespuestaPedido->purchase_units[0]->payments->captures[0]->update_time,
                        "estadopago" => $objRespuestaPedido->status
                    );

                    $this->guardarDatosDelPago($datosPago);
                    if ($this->actualizarEstadoDelPedido("autorizado", $idpedido[1])) {
                        return array(
                            "estado" => "ok",
                            "idPedido" => $idpedido[1],
                            "createTime" => $objRespuestaPedido->purchase_units[0]->payments->captures[0]->create_time,
                            "mensaje" => "Su pedido ser&aacute; enviado lo m&aacute;s pronto posible, nos pondremos en contacto con usted para informarle sobre el estado de su paquete."
                        );
                    }
                } else {
                    return array(
                        "estado" => "otro",
                        "mensaje" => "¡Lo sentimos! Su pago no pudo ser acreditado."
                    );
                }
            } elseif ($estado === "autorizado") {
                return array(
                    "estado" => "autorizado",
                    "mensaje" => "Su pedido ser&aacute; enviado lo m&aacute;s pronto posible, nos pondremos en contacto con usted para informarle sobre el estado de su paquete."
                );
            } elseif ($estado === "entregado") {
                return array(
                    "estado" => "entregado",
                    "mensaje" => "Esperamos que este disfrutando de su pedido, gracias por su preferencia."
                );
            } elseif ($estado === "cancelado") {
                return array(
                    "estado" => "cancelado",
                    "mensaje" => "¡Lo sentimos! Su pedido fue cancelado."
                );
            }
        }
    }
}