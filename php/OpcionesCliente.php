<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/dirs.php");
require_once CONFIG_PATH . "Conexion.php";

class OpcionesCliente extends Conexion
{
    public function buscarCliente(string $correoElectronico)
    {
        $estaRegistrado = false;

        // iniciamos la conexi&oacute;n
        $conexion = $this->conectar();

        // Prepara la consulta
        $sentencia = $conexion->prepare("SELECT id, email FROM Cliente WHERE email = ?");

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

    public function registrarCliente(array $post)
    {
        if ($post == null) {
            return false;
        } else {

            // iniciamos la conexi&oacute;n
            $conexion = $this->conectar();

            $txtNombre = $post["txtNombre"];
            $txtApellidos = $post["txtApellidos"];
            $txtEmail = $post["txtEmail"];
            $txtPassword = $post["txtPassword"];
            $txtTelefono = intval($post["txtTelefono"]);
            $txtCelular = intval($post["txtCelular"]);
            $txtEstado = $post["txtEstado"];
            $txtDelegacionMunicipio = $post["txtDelegacionMunicipio"];
            $txtAsentamientoColonia = $post["txtAsentamientoColonia"];
            $txtCodigoPostal = $post["txtCodigoPostal"];
            $txtCalle = $post["txtCalle"];
            $txtNumero = $post["txtNumero"];
            $txtReferencia = $post["txtReferencia"];

            // Prepara la consulta
            $sentencia = $conexion->prepare("INSERT INTO Cliente
            (nombre, apellidos, email, 
            contrasena, telefono, movil, 
            direccioncalle, numero, codigopostal, 
            estado, delegacionmunicipio, asentamientocolonia, 
            referencia) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

            // ligar parámetros para marcadores
            $sentencia->bind_param(
                "ssssiisssssss",
                $txtNombre,
                $txtApellidos,
                $txtEmail,
                $txtPassword,
                $txtTelefono,
                $txtCelular,
                $txtCalle,
                $txtNumero,
                $txtCodigoPostal,
                $txtEstado,
                $txtDelegacionMunicipio,
                $txtAsentamientoColonia,
                $txtReferencia
            );

            // se ejecuta la consulta
            if ($sentencia->execute()) {
                return true;
            } else {
                return false;
            }

            // Cerrar conexiones
            $sentencia->close();
            $conexion->close();
        }
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
            $sentencia = $conexion->prepare("SELECT id, nombre, email, contrasena FROM Cliente WHERE email = ? LIMIT 1 ");

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
                    $_SESSION["cliente"] = array(
                        'idCliente' => $datos['id'],
                        'nombreCliente' => $datos['nombre']
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
        unset($_SESSION['cliente']);
        header("Location: login.php");
    }
}
