<?php
require_once "header.php";
if (!isset($_SESSION["usuario"])) :
    header("Location: login.php");
else :
    if (isset($_POST["accion"])) {
        if ($_POST["accion"] == "registrarMarca") {
            $opcionesAdmin->registrarMarca($_POST);
        }
        if ($_POST["accion"] == "editarMarcar") {
            $opcionesAdmin->editarMarcar($_POST);
        }
    }
    $arregloMarcas = $opcionesAdmin->consultarLitaDeMarcas();
?>

    <div class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Registrar una nueva categoria</h2>
                </div>
                <div class="col-12">
                    <div class="py-3">
                        <form action="" method="post">
                            <input type="hidden" name="accion" value="registrarMarca">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="txtNombre" class="col-form-label">Nombre</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="txtNombre" id="txtNombre" class="form-control" required>
                                </div>
                                <div class="col-auto">
                                    <label for="cmbEstado" class="col-form-label">Estado</label>
                                </div>
                                <div class="col-auto">
                                    <select name="cmbEstado" id="cmbEstado" class="form-control" required>
                                        <option value="">--Elige una opci&oacute;n--</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <h2>Lista de categorias</h2>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No. Pedido</th>
                                    <th scope="col">Categorias</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($arregloMarcas->num_rows > 0) : ?>
                                    <?php foreach ($arregloMarcas as $marca) : ?>
                                        <tr>
                                            <form action="" method="post">
                                                <input type="hidden" name="accion" value="editarMarcar">
                                                <input type="hidden" name="txtId" value="<?php echo $marca["id"]; ?>">
                                                <th scope="row"><?php echo $marca["id"]; ?></th>
                                                <td>
                                                    <input type="text" name="txtNombre" id="txtNombre" class="form-control" value="<?php echo $marca["nombre"]; ?>" required>
                                                </td>
                                                <td>
                                                    <select name="cmbEstado" id="cmbEstado" class="form-control" required>
                                                        <option value="1" <?php echo ($marca["estado"] == 1) ? "selected" : ""; ?>>Activo</option>
                                                        <option value="0" <?php echo ($marca["estado"] == 0) ? "selected" : ""; ?>>Inactivo</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                                </td>
                                            </form>
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