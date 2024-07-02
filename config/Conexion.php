<?php
require_once 'DB.php';
/**
 * Clase que permite conectar a la base de datos
 * @see https://www.php.net/manual/es/intro.mysqli.php
 * @see https://www.php.net/manual/es/function.require-once.php
 */

class Conexion
{
    /**
     * Método de conexión
     *
     * @return mysqli 
     */
    public function conectar()
    {
        $mysqli =  new mysqli(host, user, password, dataBase, port);
        if ($mysqli->connect_errno) 
        { // si la conexión no se establece enviamos un mensaje informando el erro (TOP)
            echo "Error al conectar MySQL: " . $mysqli->connect_error;
        } // si la conexión no se establece enviamos un mensaje informando el erro (BOTTOM)
        $mysqli->set_charset("utf8");
        return $mysqli;
    }

}
