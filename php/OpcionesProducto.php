<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/dirs.php");
require_once CONFIG_PATH . "Conexion.php";

class OpcionesProducto extends Conexion
{

    public function consultarListaDeProductos(int $idMarca = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        if ($idMarca == null) {
            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, nombre, descripcion, precio 
            FROM Producto WHERE existencias > 0 AND activado = 1");
        } else {

            // Prepara la consulta
            $sentencia = $conexion->prepare("SELECT id, nombre, descripcion, precio 
            FROM Producto WHERE existencias > 0 AND activado = 1 AND idmarcas = ?");

            // ligar parámetros para marcadores
            $sentencia->bind_param("i", $idMarca);
        }

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();
        if ($resultado->num_rows == 0) {
            $resultado = array();
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

    public function consultarProducto(int $id)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, idmarcas, nombre, modelo, descripcion, precio, existencias FROM Producto WHERE id = ? ");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $id);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();
        $configuarcion = $resultado->fetch_array();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $configuarcion;
    }

    public function consultarImagen(int $idProducto = null)
    {

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, imagen FROM ImagenProducto WHERE idproducto = ? LIMIT 1 ");

        // ligar parámetros para marcadores
        $sentencia->bind_param("i", $idProducto);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();
        $configuarcion = $resultado->fetch_array();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $configuarcion;
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

    public function consultarDatosDelaMarca(int $idMarca)
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, nombre 
        FROM Marca WHERE id = ?");

        // ligar par&aacute;metros para marcadores
        $sentencia->bind_param("i", $idMarca);

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        if ($resultado != null) {
            $marca = $resultado->fetch_array()['nombre'];
        } else {
            $marca = "";
        }

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $marca;
    }
}
