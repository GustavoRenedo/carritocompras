<?php
require_once "header.php";

if (isset($_SESSION["cliente"])) {
    header("Location: index.php");
} else if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
    if (!$opcionesCliente->buscarCliente($_POST["txtEmail"])) {
        if ($opcionesCliente->registrarCliente($_POST)) {
            echo "Te has registrado correctamente. Ser&aacute;s redirigido en unos 5 segundos.";
            header("Refresh:5; url=login.php");
        } else {
            echo "¡No fue posible registrar tus datos en este momento! Intentalo de nuevo mas tarde.";
        }
    } else {
        echo "¡El correo electr&oacute;nico <b>" . $_POST["txtEmail"] . "</b> ya fue registrado! Puede iniciar sesi&oacute;n o solicitar que se restablezca su contraseña";
    }
}
?>
<body class="Login-control">
    
    <div class=" py-5">
        <div class=" container fondo-registro">
            <div class="row">
                <div class=" LetraRegistro col-12 text-center text-white">
                    <h1>Registrate con nosotros</h1>
                </div>
                <div class="col-12">
                    <form class="row g-3 needs-validation" action="" method="post" novalidate>
                        <input type="hidden" name="accion" value="registrar">
                        <div class="col-md-4">
                            <label for="txtNombre" class="LetraRegistro form-label text-white">Nombre</label>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="" required>
                            <div class="invalid-feedback">
                                Campo requerido, verifica el formato de tu registro.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtApellidos" class="LetraRegistro form-label text-white">Apellidos</label>
                            <input type="text" class="form-control" name="txtApellidos" id="txtApellidos" value="" required>
                            <div class="invalid-feedback">
                                Campo requerido, verifica el formato de tu registro.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtEmail" class=" LetraRegistro text-white form-label">Correo electr&oacute;nico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="spanEmail"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="txtEmail" id="txtEmail" aria-describedby="spanEmail" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtPassword" class="LetraRegistro text-white form-label">Contraseña</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="spanPassword"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" name="txtPassword" id="txtPassword" aria-describedby="spanPassword" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtTelefono" class="LetraRegistro text-white form-label">Tel&eacute;fono</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="spanTelefono"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" aria-describedby="spanTelefono" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtCelular" class="LetraRegistro text-white form-label">Celular</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="spanCelular"><i class="fas fa-mobile"></i></span>
                                <input type="text" class="form-control" name="txtCelular" id="txtCelular" aria-describedby="spanCelular">
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtEstado" class="LetraRegistro text-white form-label">Estado</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="txtEstado" id="txtEstado" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtDelegacionMunicipio" class="LetraRegistro text-white form-label">Delegaci&oacute;n/Municipio</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="txtDelegacionMunicipio" id="txtDelegacionMunicipio" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="txtAsentamientoColonia" class="LetraRegistro text-white form-label">Asentamiento/Colonia</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="txtAsentamientoColonia" id="txtAsentamientoColonia" required>
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="txtCodigoPostal" class="LetraRegistro text-white form-label">C&oacute;digo postal</label>
                            <input type="text" class="form-control" name="txtCodigoPostal" id="txtCodigoPostal" required>
                            <div class="invalid-feedback">
                                Campo requerido, verifica el formato de tu registro.
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="txtCalle" class="LetraRegistro text-white form-label">Calle</label>
                            <input type="text" class="form-control" name="txtCalle" id="txtCalle" required>
                            <div class="invalid-feedback">
                                Campo requerido, verifica el formato de tu registro.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="txtNumero" class="LetraRegistro text-white form-label">N&uacute;mero</label>
                            <input type="text" class="form-control" name="txtNumero" id="txtNumero" required>
                            <div class="invalid-feedback">
                                Campo requerido, verifica el formato de tu registro.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="txtReferencia" class="LetraRegistro text-white form-label">Referencia</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="txtReferencia" id="txtReferencia">
                                <div class="invalid-feedback">
                                    Campo requerido, verifica el formato de tu registro.
                                </div>
                            </div>
                        </div>
                        <div class="col-mb-4 form-check">
                                <input type="checkbox" name="connected" class="form-check-input" required>
                                <label for="connected" class="text-white form-check-label boton-aceptar">Acepto los <a href="../terminos_condiciones.php">Terminos y condiciones</a> y autorizo el uso de mis datos de acuerdo a la <a href="../declaracion_privacidad.php"> Declaracion de privacidad</a></label>
                            </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-secondary text-white" type="submit">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 text-center text-white">
                <a href="<?php echo APP_HOST; ?>" class="btn btn-link text-white">Regresar a la tienda</a>
            </div>
        </div>
    </div>
</body>
    <?php require_once "footer.php"; ?>

    <script>
        (function() {
            'use strict'
            // Obtener todos los formularios a los que queremos aplicar estilos de validacion personalizados de Bootstrap
            var forms = document.querySelectorAll('.needs-validation')

            // Bucle del formulario y evitar el envio
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();
</script>