<?php

require_once __DIR__ . '/../../../security/controlAccess.php';
include_once __DIR__ . '/../../../model/managers/RulesManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

if($_SESSION['user']['permiso'] == '3') {
    header("Location: /urban/backoffice/catalogo/descuentos/comerciales/");
    exit;
}

?>

<?php require_once __DIR__ . '/../../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/catalogo/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Reglas Comerciales</a> / Añadir Regla Comercial</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Añadir Regla Comercial</h1>
        </div>

        <div class="content-description">
            <p>Las reglas comerciales te permiten realizar reducciones de precios a los productos que cumplan las condiciones de una regla comercial. Esto significa que una regla comercial se aplica a un conjunto de productos. <strong>Ojo:</strong> ten en cuenta que si no especificas ninguna condición, esta regla comercial afectará a todo el catalogo.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Reglas comerciales</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/codigos/">Códigos descuento</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/nuevo.php" class="active-item"><i class="bi bi-plus"></i> Añadir Regla Comercial</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-regla-comercial">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="100" autocomplete="off">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Grupo *</label>
                    <select class="form-select-rules" name="grupo">
                        <option value="todos">Todos</option>
                        <option value="invitados">Invitados</option>
                        <option value="registrados">Registrados</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="date">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                    <input class="form-date" type="datetime-local" min="<?php echo date('Y-m-d'); ?>" class="form-date" name="fecha_inicio">
                        
                    <p class="input-error-info">Debes incluir una fecha válida.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="date">
                    <label for="fecha_fin" class="form-label">Fecha de fin *</label>
                    <input class="form-date" type="datetime-local" min="<?php echo date('Y-m-d'); ?>" class="form-date" name="fecha_fin">
                        
                    <p class="input-error-info">Debes incluir una fecha válida.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Tipo de reducción *</label>
                    <select class="form-select-rules" name="tipo_reduccion">
                        <option value="Porcentaje">Porcentaje</option>
                        <option value="cantida-fija">Cantidad fija</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Tasas incluidas *</label>
                    <select class="form-select-rules" name="tasas_incluidas">
                        <option value="excluidas">Excluidas</option>
                        <option value="incluidas">Incluidas</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Reducción *</label>
                    <input type="text" class="form-input" name="reduccion" autocomplete="off" value="0.0">

                    <p class="input-error-info">Formato incorrecto.</p>

                    <div class="form-group-info">
                        <span>Si el tipo de reducción es porcentual, el rango sera de 0 a 1. El único caracter separador válido será el punto.</span>
                    </div>
                </div>


                <div class="form-submit">
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Añadir regla comercial</button>
                </div>

            </form>

        </div>

        <!-- condiciones de las reglas comerciales -->
        <div class="conditions-included empty" id="condiciones">

            <h2 class="comercial-rules-title">Grupo de condiciones <span id="conditions-length">(6)</span></h2>

            <div class="content-description">
                <p>Condiciones que has añadido a la regla comercial:</p>
            </div>
            
            <div class="conditions-included-group">
                <ul class="conditions-list-head">
                    <li>Tipo</li>
                    <li>Valor</li>
                    <li></li>
                </ul>

                <ul class="conditions-list-body">
                    <li data-condition-type="categoria">Categoría</li>
                    <li data-condition-value="2">Accesorios</li>
                    <li>
                        <button class="btn-condition-delete">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </li>
                </ul>

                <ul class="conditions-list-body">
                    <li data-condition-type="categoria">Categoría</li>
                    <li data-condition-value="2">Accesorios</li>
                    <li>
                        <button class="btn-condition-delete">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </li>
                </ul>

                <ul class="conditions-list-body">
                    <li data-condition-type="categoria">Categoría</li>
                    <li data-condition-value="2">Accesorios</li>
                    <li>
                        <button class="btn-condition-delete">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </li>
                </ul>

            </div>
            

        </div> 

        <div class="comercial-rules-container">

            <h2 class="comercial-rules-title">Condiciones</h2>

            <div class="content-description">
                <p>Aquí podrás añadir a la regla comercial todos los condicionantes que desees. Cuantos más condicionantes, a mayor número de productos afectará.</p>
            </div>

            <?php
                $rulesManager = new RulesManager();

                $categorias = $rulesManager -> getCategories();
                $subcategorias = $rulesManager -> getSubcategories();
                $colores = $rulesManager -> getColors();
                $generos = $rulesManager -> getGenders();
                $marcas = $rulesManager -> getBrands();
            ?>

            <div class="condition-group">
                <div class="condition-group-name">
                    <p>Categoría</p>
                </div>
                <div class="condition-group-select">
                    <select id="category-rule" class="form-select-condition" data-condition="categorias">
                        <?php
                            for($i = 0; $i < $categorias -> num_rows; $i++) {
                                $fila = $categorias -> fetch_assoc();
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <button class="rules-btn">
                    <i class="bi bi-plus"></i> Añadir condición
                </button>
                
            </div>

            <div class="condition-group">
                <div class="condition-group-name">
                    <p>Subcategoría</p>
                </div>
                <div class="condition-group-select">
                    <select id="subcategory-rule" class="form-select-condition" data-condition="subcategorias">
                        <?php
                            for($i = 0; $i < $subcategorias -> num_rows; $i++) {
                                $fila = $subcategorias -> fetch_assoc();
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <button class="rules-btn">
                    <i class="bi bi-plus"></i> Añadir condición
                </button>
                
            </div>

            <div class="condition-group">
                <div class="condition-group-name">
                    <p>Color</p>
                </div>
                <div class="condition-group-select">
                    <select id="color-rule" class="form-select-condition" data-condition="colores">
                        <?php
                            for($i = 0; $i < $colores -> num_rows; $i++) {
                                $fila = $colores -> fetch_assoc();
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <button class="rules-btn">
                    <i class="bi bi-plus"></i> Añadir condición
                </button>
            </div>

            <div class="condition-group">
                <div class="condition-group-name">
                    <p>Género</p>
                </div>
                <div class="condition-group-select">
                    <select id="gender-rule" class="form-select-condition" data-condition="genero">
                        <?php
                            for($i = 0; $i < $generos -> num_rows; $i++) {
                                $fila = $generos -> fetch_assoc();
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <button class="rules-btn">
                    <i class="bi bi-plus"></i> Añadir condición
                </button>
                
            </div>

            <div class="condition-group">
                <div class="condition-group-name">
                    <p>Marca</p>
                </div>
                <div class="condition-group-select">
                    <select id="marcas-rule" class="form-select-condition" data-condition="marcas">
                        <?php
                            for($i = 0; $i < $marcas -> num_rows; $i++) {
                                $fila = $marcas -> fetch_assoc();
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <button class="rules-btn">
                    <i class="bi bi-plus"></i> Añadir condición
                </button>
                
            </div>

        </div> <!-- final contenedor -->

    </div>
</div>

</div> <!--Final del container principal-->


<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/descuentos/reglasComerciales.js"; ?>"></script>

<?php require_once __DIR__ . '/../../../footer.php'; ?>