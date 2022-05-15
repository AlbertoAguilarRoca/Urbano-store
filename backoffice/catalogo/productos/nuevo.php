<?php

require_once __DIR__ . '/../../security/controlAccess.php';
include_once __DIR__ . '/../../model/managers/GenericManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

if ($_SESSION['user']['permiso'] == '3') {
    header("Location: /urban/backoffice/catalogo/productos/");
    exit;
}

$genericManager = new GenericManager();

$categorias = $genericManager->getCategories();
$subcategorias = $genericManager->getSubcategories();
$colores = $genericManager->getColors();
$generos = $genericManager->getGenders();
$marcas = $genericManager->getBrands();
$tallas = $genericManager->getSizes();

?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/productos/">Productos</a> / Añadir producto</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Añadir producto</h1>
        </div>

        <div class="content-description">
            <p>Al tratarse de una tienda online, los productos son el eje central. Aquí podrás añadir nuevos productos, asociarlos a categorías, y subcategorias. También podrás añadir el stock por tallas, el precio, y la descripción del producto que aparecerá en la web. Si quieres crear el producto, pero no quieres publicarlo puedes marcarlo como inactivo.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/productos/">Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/productos/nuevo.php" class="active-item"><i class="bi bi-plus"></i> Añadir producto</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-product">

                <div class="product-form-row">

                    <div class="product-form-col">

                        <div class="form-group" data-required="true" data-type="text">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-input" name="nombre" maxlength="100" autocomplete="off">

                            <p class="input-error-info">El nombre no puede estar vacío.</p>

                            <div class="form-group-info">
                                <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                <span class="input-length-counter">0/100</span>
                            </div>
                        </div>

                        <div class="product-form-col-group">

                            <div class="form-group pr-5" data-required="true" data-type="select">
                                <label for="marca" class="form-label">Marca *</label>
                                <select class="form-select" name="marca">
                                    <option value="" disabled selected></option>
                                    <?php
                                    for ($i = 0; $i < $marcas->num_rows; $i++) {
                                        $fila = $marcas->fetch_assoc();
                                        if ($fila['id'] != '0') {
                                            echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <p class="input-error-info">Debes seleccionar una marca.</p>
                            </div>

                            <div class="form-group" data-required="true" data-type="select">
                                <label for="genero" class="form-label">Género *</label>
                                <select class="form-select" name="genero">
                                    <option value="" disabled selected></option>
                                    <?php
                                    for ($i = 0; $i < $generos->num_rows; $i++) {
                                        $fila = $generos->fetch_assoc();
                                        if ($fila['id'] != '0') {
                                            echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <p class="input-error-info">Debes seleccionar un género.</p>
                            </div>

                        </div>
                        <!--fin product-form-col-group -->

                        <div class="form-group" data-required="true" data-type="select">
                            <label for="subcategoria" class="form-label">Subcategoría *</label>
                            <select class="form-select" name="subcategoria">
                                <option value="" disabled selected></option>
                                <?php
                                for ($i = 0; $i < $subcategorias->num_rows; $i++) {
                                    $fila = $subcategorias->fetch_assoc();
                                    if ($fila['id'] != '0') {
                                        echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <p class="input-error-info">Debes seleccionar una subcategoría.</p>
                        </div>

                        <div class="form-group pb-5" data-required="true" data-type="date">
                            <label for="fecha_creacion" class="form-label">Fecha de creación *</label>
                            <input class="form-date" type="date" class="form-date" name="fecha_creacion">

                            <p class="input-error-info">Debes incluir una fecha válida.</p>
                            <div class="form-group-info">
                                <span>Si estableces una fecha de creación futura, el producto no aparecerá hasta que supere dicha fecha. Es decir, estarás programando la fecha de publicación.</span>
                            </div>
                        </div>

                        <div class="product-form-col-group">
                            <div>
                                <p class="form-label">Estado</p>
                                <div class="form-status-area">
                                    <div id="status" class="form-status-selector">
                                        <div class="form-status-ball"></div>
                                    </div>
                                    <input id="status-checkbox" type="checkbox" name="estado" class="form-status-checkbox" checked value="yes">
                                    <span id="status-info" class="form-admin-status-info">Activo</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="color" class="form-label">Color</label>
                                <select class="form-select" name="color">
                                    <?php
                                    for ($i = 0; $i < $colores->num_rows; $i++) {
                                        $fila = $colores->fetch_assoc();

                                        if($fila['id'] == '0') {
                                            echo "<option selected value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                        } else {
                                            echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                        }
                                        
                                        
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> <!-- fin product form col group color y estatus-->
                        <div class="form-group-info">
                                <span>Si el producto lleva asociado una marca o subcategoría inactiva, el producto se creará inactivo.</span>
                            </div>

                        <div class="product-form-col-group">
                            
                            <div class="form-group pr-5" data-required="true" data-type="text">
                                <label for="precio" class="form-label">Precio sin IVA *</label>
                                <input type="text" class="form-input" name="precio" autocomplete="off" id="precio-sin">

                                <p class="input-error-info">Debes incluir un precio.</p>
                            </div>

                            <div class="form-group pr-5" data-required="true" data-type="text">
                                <label for="precio" class="form-label">Precio con IVA *</label>
                                <input type="text" class="form-input" autocomplete="off" id="precio-con">
                            </div>

                            <div class="form-group pl-5" data-required="true" data-type="select">
                                <label for="iva" class="form-label">Tipo IVA *</label>
                                <select class="form-select" name="iva" id="iva">
                                    <option value="0">Sin IVA (0%)</option>
                                    <option value="0.04">IVA Superredicodo (4%)</option>
                                    <option value="0.10">IVA Reducido (10%)</option>
                                    <option value="0.21" selected>IVA General (21%)</option>
                                </select>
                            </div>

                        </div> <!-- fin product form col group precios-->
                        <div class="form-group-info">
                            <span>El único separador de decimales permitidos es el punto. El número máximo de decimales será de dos.</span> 
                        </div>

                        <label for="size" class="form-label">Tallas *</label>
                        <div class="product-form-col-group">
                            
                            <div class="form-group pr-5">
                                <select class="form-select" id="size">
                                    <option value="" disabled selected>-- Tallas --</option>
                                    <?php
                                    for ($i = 0; $i < $tallas->num_rows; $i++) {
                                        $fila = $tallas->fetch_assoc();
                                        if($fila['id'] != '0') {
                                            echo "<option value='" . $fila['id'] . "'>" . $fila['talla'] . "</option>";
                                        }
                                        
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group pr-5">
                                <input type="number" class="form-input" autocomplete="off" placeholder="Cantidad" id="size-stock">
                            </div>

                            <div class="form-group pr-5">
                                <input type="number" class="form-input" autocomplete="off" placeholder="Rotura de stock" id="rotura-stock">
                            </div>

                            <div class="btn-add pl-5">
                                <button type="button" id="add-size"><i class="bi bi-plus-lg"></i></button>
                            </div>

                        </div> <!-- fin product form col group tallas-->

                        <div class="sizes-box" id="tallas-contenedor"></div>

                        <label for="rel_product" class="form-label">Productos relacionados</label>
                        <div class="product-form-col-group">

                            <div class="form-group pr-5">
                                <input type="text" class="form-input" autocomplete="off" placeholder="Referencia de producto" id="ref_product">
                            </div>

                            <div class="btn-add pl-5">
                                <button type="button" id="add-ref-product"><i class="bi bi-plus-lg"></i></button>
                            </div>

                        </div> <!-- fin product form col group tallas-->
                        
                        <div class="form-group-info">
                            <span>Incluye todos los productos relacionados que quieras especificando la referencia de producto. Aquellas referencias que no se encuentren no se añadiran.</span>
                        </div>
                        <div class="sizes-box" id="ref-product-contenedor"></div>



                    </div> <!-- fin product form col -->

                    <div class="product-form-col">

                        <div class="form-group" data-required="true" data-type="file">
                            <label for="imagenes_producto" class="form-label">Imágenes del producto *</label>
                            <input type="file" id="file-input" class="form-file-img" name="imagenes_producto[]" accept="image/png, image/jpeg, image/jpg" multiple>

                            <div class="form-display-images" id="display-images">
 
                                <div class="no-images" id="no-images-box">
                                    <p class="images-icon"><i class="bi bi-images"></i></p>
                                    <p class="images-text">No hay imágenes añadidas. Incluye alguna foto del producto haciendo click en el botón.</p>
                                </div>

                            </div>

                            <div class="upload-images-product">
                                <button type="button" class="upload-images-btn" id="btn-upload">
                                    <i class="bi bi-upload"></i>
                                    Añadir
                                </button>
                            </div>

                            <p class="input-error-info">Debes incluir al menos una imagen.</p>

                            <div class="form-group-info">
                                <span>Como mínimo, debes añadir una imagen del producto. Solo estarán permitidas las extensiones .jpg y .png. Por favor, ten en cuenta la optimización de las imágenes al subirlas, ya que puede afectar al rendimiento de la página. En caso de querer modificar las imágenes subidas, vuelve a añadirlas.</span>
                            </div>
                        </div>

                        <div class="form-group" data-required="true" data-type="text">
                            <label for="resumen" class="form-label">Resumen *</label>
                            <textarea class="form-input" name="resumen" maxlength="300" rows="5"></textarea>
                            <p class="input-error-info">Campo vacío.</p>
                            <div class="form-group-info">
                                <span>Resumen de las cualidades principales del producto. Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                <span class="input-length-counter">0/300</span>
                            </div>
                        </div>

                        <div class="form-group" data-required="true" data-type="text">
                            <label for="caracteristicas" class="form-label">Características *</label>
                            <textarea class="form-input" name="caracteristicas" maxlength="500" rows="7"></textarea>
                            <p class="input-error-info">Campo vacío.</p>
                            <div class="form-group-info">
                                <span>En las características puedes describir los detalles más técnicos del producto, como los materiales, procedencia, marca, etc. Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                <span class="input-length-counter">0/500</span>
                                
                            </div>
                        </div>

                    </div> <!-- fin product form col -->

                </div> <!-- fin -product form row -->

                <div class="form-submit">
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/productos/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Añadir producto</button>
                </div>

            </form>

        </div>

    </div>
</div>

</div>
<!--Final del container principal-->

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/decimal.js"; ?>"></script>
<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleStatusInput.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/producto/productos.js"; ?>"></script>

<?php require_once __DIR__ . '/../../footer.php'; ?>