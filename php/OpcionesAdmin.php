<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/dirs.php");
require_once CONFIG_PATH . "Conexion.php";

class OpcionesAdmin extends Conexion
{
    public function buscarUsuario(string $correoElectronico)
    {
        $estaRegistrado = false;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, email FROM usuario WHERE email = ?");

        // ligar parámetros para marcadores
        $sentencia->bind_param("s", $correoElectronico);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();
        if ($resultado != null) {
            $estaRegistrado = true;
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $estaRegistrado;
    }

    public function login(array $post)
    {
        $isLogin = false;
        if ($post == null) {
            return $isLogin;
        } else {

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, nombre, email, contrasena FROM Usuario WHERE email = ? LIMIT 1 ");

            // ligar parámetros para marcadores
            $sentencia->bind_param("s", $post['loginEmail']);

            // se ejecuta la consulta
            $sentencia->execute();

            // obtener el resultado
            $resultado = $sentencia->get_result();
            if ($resultado != null) {

                $datos = $resultado->fetch_array();
                if ($post['loginPassword'] === $datos['contrasena']) {
                    session_start();
                    $_SESSION["usuario"] = array(
                        'idUsuario' => $datos['id'],
                        'nombreUsuario' => $datos['nombre']
                    );
                    $isLogin = true;
                }
            }
            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();

            return $isLogin;
        }
    }

    public function cerrarSesion()
    {
        //para borrar todas las variables de sesión usa session_destroy
        unset($_SESSION['usuario']);
        header("Location: login.php");
    }

    // nuevas opciones
    public function consultarPedidos(int $id = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        if ($id == null) {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, idcliente, clavetransaccion, total, fecha, estado 
            FROM Pedido");
        } else {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, idcliente, clavetransaccion, total, fecha, estado 
            FROM Pedido WHERE id = ?");

            // ligar parámetros para marcadores
            $sentencia->bind_param("i", $id);
        }

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function editarPedido(array $post = null)
    {
        $estaEditado = false;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();


        // Prepara la consulta
        $sentencia = $conexion->prepare("UPDATE Pedido SET estado= ? WHERE id = ?");

        // ligar parámetros para marcadores
        $sentencia->bind_param("si", $post["cbmEstado"], $post["txtIdPedido"]);


        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $estaEditado = true;
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $estaEditado;
    }

    public function consultarDetallePedido(int $id)
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT Pedido.clavetransaccion, Pedido.total, 
        Pedido.fecha, Pedido.estado as estatus,
        Cliente.nombre, Cliente.apellidos, 
        Cliente.email, Cliente.contrasena, 
        Cliente.telefono, Cliente.movil, 
        Cliente.direccioncalle, Cliente.numero, 
        Cliente.codigopostal, Cliente.estado, 
        Cliente.delegacionmunicipio, Cliente.asentamientocolonia, 
        Cliente.referencia
        FROM Pedido 
        INNER JOIN Cliente
        ON Pedido.idcliente = Cliente.id
        WHERE Pedido.id = ?");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();
        $datos = $resultado->fetch_assoc();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $datos;
    }

    public function consultarPedido(int $id)
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT
            Producto.nombre,
            Producto.modelo,
            Marca.nombre as marca,
            LineaPedido.unidades,
            LineaPedido.precioventa
            FROM LineaPedido 
            INNER JOIN Producto
            ON LineaPedido.idproducto = Producto.id
            INNER JOIN Marca
            ON Marca.id= Producto.idmarcas
            WHERE idpedido = ?");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function consultarPagos(int $id)
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT metodopago, idpedido, 
        total, compradoremail, createtime, 
        updatetime, estadopago 
        FROM Pago 
        WHERE idpedido = ?");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function consultarLitaDeMarcas(int $id = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        if ($id == null) {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, nombre, estado FROM Marca");
        } else {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, nombre, estado FROM Marca WHERE id = ?");

            // ligar parámetros para marcadores
            $sentencia->bind_param("i", $id);
        }

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function registrarMarca(array $post)
    {
        if ($post == null) {
            return false;
        } else {
            $guardado = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO Marca (nombre, estado) 
            VALUES (?,?)");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "si",
                $post["txtNombre"],
                $post["cmbEstado"]
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

    public function editarMarcar(array $post)
    {
        if ($post == null) {
            return false;
        } else {
            $seEdito = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("UPDATE Marca 
            SET nombre = ?, estado = ? WHERE id = ?");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "sii",
                $post["txtNombre"],
                $post["cmbEstado"],
                $post["txtId"]
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                $seEdito = true;
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();

            return $seEdito;
        }
    }

    public function consultarLitaDeProductos(int $id = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        if ($id == null) {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, idmarcas, nombre, modelo, 
            descripcion, precio, existencias, activado FROM Producto");
        } else {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, idmarcas, nombre, modelo, 
            descripcion, precio, existencias, activado FROM Producto WHERE id = ?");

            // ligar parámetros para marcadores
            $sentencia->bind_param("i", $id);
        }

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function consultarImagenes(int $idProducto = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, imagen FROM ImagenProducto WHERE idproducto = ? ");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $idProducto);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function registrarProducto(array $post)
    {
        if ($post == null) {
            return false;
        } else {
            $guardado = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO Producto
            (idmarcas, nombre, modelo, descripcion, precio, existencias, activado) 
            VALUES (?,?,?,?,?,?,?)");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "isssdii",
                $post["cmbMarca"],
                $post["txtNombre"],
                $post["txtModelo"],
                $post["txtDescripcion"],
                $post["txtPrecio"],
                $post["txtExistencias"],
                $post["cmbEstado"]
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

    public function editarProducto(array $post)
    {
        if ($post == null) {
            return false;
        } else {
            $guardado = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("UPDATE Producto 
            SET idmarcas=?,nombre=?,modelo=?,descripcion=?,precio=?,existencias=?,activado=? 
            WHERE id = ?");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "isssdiii",
                $post["cmbMarca"],
                $post["txtNombre"],
                $post["txtModelo"],
                $post["txtDescripcion"],
                $post["txtPrecio"],
                $post["txtExistencias"],
                $post["cmbEstado"],
                $post["txtId"]
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

    private function subirArchivo(array $files)
    {
        // Recogemos el archivo enviado por el formulario
        $archivo = $files["txtImagen"]["name"];
        // Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $files["txtImagen"]["type"];
            $tamano = $files["txtImagen"]["size"];
            $temp = $files["txtImagen"]["tmp_name"];
            // Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error. La extensión o el tamaño de los archivos no es correcta. 
                            Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b>
                            </div>';
            } else {
                // Si la imagen es correcta en tamaño y tipo
                // Se intenta subir al servidor
                $ruta = ROOT_PATH . "img/" . $archivo;
                if (move_uploaded_file($temp, $ruta)) {
                    // Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod($ruta, 0777);
                    // Mostramos el mensaje de que se ha subido co éxito
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Se ha subido correctamente la imagen.
                                </div>';
                    return $archivo;
                } else {
                    // Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Ocurrió algún error al subir el fichero. No pudo guardarse.
                                </div>';
                }
            }
        }
        return null;
    }

    public function registrarImagen(int $idProducto, array $files)
    {

        $guardado = false;

        $nombreArchivo = $this->subirArchivo($files);

        if ($nombreArchivo != null) {
            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO ImagenProducto(idproducto, imagen) VALUES (?,?)");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "is",
                $idProducto,
                $nombreArchivo
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                $guardado = true;
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();
        }

        return $guardado;
    }

    public function borrarImagen(array $post)
    {
        if ($post == null) {
            return false;
        } else {
            $borrado = false;

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            // Prepara la consulta
            $sentencia = $conexion->prepare("DELETE FROM ImagenProducto WHERE id = ?");

            // ligar par&aacute;metros para marcadores
            $sentencia->bind_param(
                "i",
                $post["txtId"]
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                $borrado = true;
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();

            return $borrado;
        }
    }
}