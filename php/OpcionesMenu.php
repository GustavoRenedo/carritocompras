<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/dirs.php");
require_once CONFIG_PATH."Conexion.php";

/**
 * Clase que permite consultar las configuraciones del sistema
 */
class OpcionesMenu extends Conexion
{
    
    /**
     * Esta función permite consultar la configuración del sistema
     *
     * @return array
     */
    public function consultarConfiguracion()
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, nombretienda, historia, mision, vision FROM Configuracion WHERE 1");

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

    /**
     * Esta función permite consultar las marcas
     *
     * @return array
     */
    public function consultarMarcas()
    {
        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, nombre FROM Marca");

        // se ejecuta la consulta
        $sentencia->execute();

        // obtener el resultado
        $resultado = $sentencia->get_result();

        // Cerrar conexiones
        $sentencia->close();
        $conexion->close();

        return $resultado;
    }

}