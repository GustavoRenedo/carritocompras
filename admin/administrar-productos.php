<?php
require_once "header.php";
if (!isset($_SESSION["usuario"])) :
    header("Location: login.php");
else :
    if (isset($_POST["accion"])) {
        switch ($_POST["accion"]) {
            case 'registrarProducto':
                $opcionesAdmin->registrarProducto($_POST);
                break;
            case 'editarProducto':
                $opcionesAdmin->editarProducto($_POST);
                break;
            case 'registrarImagen':
                $opcionesAdmin->registrarImagen($_POST["txtIdProducto"], $_FILES);
                break;
            case 'borrarImagen':
                $opcionesAdmin->borrarImagen($_POST);
                break;
        }
    }
    $arregloProductos = $opcionesAdmin->consultarLitaDeProductos();
    $arregloMarcas = $opcionesAdmin->consultarLitaDeMarcas();
?>

    <!-- Modal (inicio) -->
    <div class="modal fade" id="modalNuevoProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoProductoLabel">Nuevo producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="" method="post">
                        <input type="hidden" name="accion" value="registrarProducto">
                        <div class="col-md-12">
                            <label for="txtNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="" required>
                        </div>
                        <div class="col-md-12">
                            <label for="txtDescripcion" class="form-label">Descripci&oacute;n</label>
                            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="cmbMarca" class="form-label">Marca</label>
                            <select name="cmbMarca" id="cmbMarca" class="form-control" required>
                                <option value="">--Elige una opci&oacute;n--</option>
                                <?php foreach ($arregloMarcas as $marca) : ?>
                                    <option value="<?php echo $marca["id"]; ?>"><?php echo $marca["nombre"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="txtModelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="txtModelo" id="txtModelo" value="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="txtPrecio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="txtPrecio" id="txtPrecio" value="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="txtExistencias" class="form-label">Existencias</label>
                            <input type="number" class="form-control" name="txtExistencias" id="txtExistencias" value="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cmbEstado" class="form-label">Activo</label>
                            <select name="cmbEstado" id="cmbEstado" class="form-control" required>
                                <option value="">--Elige una opci&oacute;n--</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-12 d-flex flex-row-reverse">
                            <button class="btn btn-success" type="submit">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal (fin) -->

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-row-reverse">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                        Agregar un nuevo producto
                    </button>
                </div>
                <div class="col-12 text-center">
                    <h2>Lista de productos</h2>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Existencias</th>
                                    <th scope="col">Activo</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Editar im&aacute;genes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($arregloProductos->num_rows > 0) : ?>
                                    <?php foreach ($arregloProductos as $producto) : ?>
                                        <tr>
                                            <th scope="row"><?php echo $producto["id"]; ?></th>
                                            <td>
                                                <?php echo $producto["nombre"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $producto["modelo"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $producto["precio"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $producto["existencias"]; ?>
                                            </td>
                                            <td>
                                                <?php echo ($producto["activado"] == 1) ? "Si" : "No"; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarProducto<?php echo $producto["id"]; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarImagen<?php echo $producto["id"]; ?>">
                                                    Im&aacute;genes
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal editar (inicio) -->
                                        <div class="modal fade" id="modalEditarProducto<?php echo $producto["id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarProducto<?php echo $producto["id"]; ?>Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditarProductoLabel<?php echo $producto["id"]; ?>">Editar producto</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="row g-3 needs-validation" action="" method="post">
                                                                <input type="hidden" name="accion" value="editarProducto">
                                                                <input type="hidden" name="txtId" value="<?php echo $producto["id"]; ?>">
                                                                <div class="col-md-12">
                                                                    <label for="txtNombre" class="form-label">Nombre</label>
                                                                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto["nombre"]; ?>" required>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="txtDescripcion" class="form-label">Descripci&oacute;n</label>
                                                                    <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="3" required><?php echo $producto["descripcion"]; ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="cmbMarca" class="form-label">Marca</label>
                                                                    <select name="cmbMarca" id="cmbMarca" class="form-control" required>
                                                                        <option value="">--Elige una opci&oacute;n--</option>
                                                                        <?php foreach ($arregloMarcas as $marca) : ?>
                                                                            <option value="<?php echo $marca["id"]; ?>" <?php echo ($producto["idmarcas"] == $marca["id"]) ? "selected" : ""; ?>><?php echo $marca["nombre"]; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="txtModelo" class="form-label">Modelo</label>
                                                                    <input type="text" class="form-control" name="txtModelo" id="txtModelo" value="<?php echo $producto["modelo"]; ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="txtPrecio" class="form-label">Precio</label>
                                                                    <input type="number" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto["precio"]; ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="txtExistencias" class="form-label">Existencias</label>
                                                                    <input type="number" class="form-control" name="txtExistencias" id="txtExistencias" value="<?php echo $producto["existencias"]; ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="cmbEstado" class="form-label">Activo</label>
                                                                    <select name="cmbEstado" id="cmbEstado" class="form-control" required>
                                                                        <option value="">--Elige una opci&oacute;n--</option>
                                                                        <option value="1" <?php echo ($producto["activado"] == 1) ? "selected" : ""; ?>>Si</option>
                                                                        <option value="0" <?php echo ($producto["activado"] == 0) ? "selected" : ""; ?>>No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="py-2 col-md-12 d-flex flex-row-reverse">
                                                                    <button class="btn btn-success" type="submit">Editar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal editar (fin) -->
                                        <!-- Modal editar imagen (inicio) -->
                                        <div class="modal fade" id="modalEditarImagen<?php echo $producto["id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarImagen<?php echo $producto["id"]; ?>Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditarImagenLabel<?php echo $producto["id"]; ?>">Im&aacute;genes</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <?php
                                                                    $arregloImagenes = $opcionesAdmin->consultarImagenes($producto["id"]);
                                                                    if ($arregloImagenes->num_rows > 0) :
                                                                        foreach ($arregloImagenes as $imagen) :
                                                                    ?>
                                                                            <div class="col-md-8"><?php echo $imagen["imagen"]; ?></div>
                                                                            <div class="col-md-4">
                                                                                <form action="" method="post">
                                                                                    <input type="hidden" name="accion" value="borrarImagen">
                                                                                    <input type="hidden" name="txtId" value="<?php echo $imagen["id"]; ?>">
                                                                                    <button type="submit" class="btn btn-danger">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                    <?php
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <form class="row g-3 needs-validation" action="" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="accion" value="registrarImagen">
                                                                <input type="hidden" name="txtIdProducto" value="<?php echo $producto["id"]; ?>">
                                                                <div class="col-md-12">
                                                                    <label for="txtNombre" class="form-label">Imagen</label>
                                                                    <input type="file" accept="image/*" name="txtImagen" id="txtImagen" class="form-control" required>
                                                                </div>
                                                                <div class="py-2 col-md-12 d-flex flex-row-reverse">
                                                                    <button class="btn btn-success" type="submit">Agregar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal editar imagen (fin) -->
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No se encontraron resultados</td>
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