<?php

require_once __DIR__ . '/../../../security/controlAccess.php';
include_once __DIR__ . '/../../../model/managers/GenericManager.php';
include_once __DIR__ . '/../../../model/managers/RulesManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$rulesManager = new RulesManager();

$rule = $rulesManager -> getRuleById($_GET['id_regla']);
$rule_cond = $rulesManager -> getRuleCondById($_GET['id_regla']);

?>

<?php require_once __DIR__ . '/../../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/catalogo/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Reglas Comerciales</a> / Editar Regla Comercial</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Editar Regla Comercial</h1>
        </div>

        <div class="content-description">
            <p>Las reglas comerciales te permiten realizar reducciones de precios a los productos que cumplan las condiciones de una regla comercial. Esto significa que una regla comercial se aplica a un conjunto de productos. <strong>Ojo:</strong> ten en cuenta que si no especificas ninguna condición, esta regla comercial afectará a todo el catalogo.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Reglas comerciales</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/codigos/">Códigos descuento</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/nuevo.php"><i class="bi bi-plus"></i> Añadir Regla Comercial</a></li>
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

                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="100" autocomplete="off" value="<?php echo $rule['nombre']; ?>">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Grupo *</label>
                    <select class="form-select-rules" name="grupo">
                        <option value="todos" <?php if($rule['grupo'] == 'todos') {echo 'selected';} ?>>Todos</option>
                        <option value="invitados" <?php if($rule['grupo'] == 'invitados') {echo 'selected';} ?>>Invitados</option>
                        <option value="registrados" <?php if($rule['grupo'] == 'registrados') {echo 'selected';} ?>>Registrados</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="date">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio *</label>
                    <input class="form-date" type="datetime-local" class="form-date" name="fecha_inicio" value="<?php echo str_replace(' ', 'T', $rule['fecha_inicio']); ?>">
                        
                    <p class="input-error-info">Debes incluir una fecha válida.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="date">
                    <label for="fecha_fin" class="form-label">Fecha de fin *</label>
                    <input class="form-date" type="datetime-local"min="<?php echo date('Y-m-d').'T'.date('h:i'); ?>" class="form-date" name="fecha_fin" value="<?php echo str_replace(' ', 'T', $rule['fecha_fin']); ?>">
                        
                    <p class="input-error-info">Debes incluir una fecha válida.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Tipo de reducción *</label>
                    <select class="form-select-rules" name="tipo_reduccion">
                        <option value="porcentaje" <?php if($rule['tipo_reduccion'] == 'porcentaje') {echo 'selected';} ?>>Porcentaje</option>
                        <option value="cantidad-fija" <?php if($rule['tipo_reduccion'] == 'cantidad-fija') {echo 'selected';} ?>>Cantidad fija</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="select">
                    <label for="grupo" class="form-label">Tasas incluidas *</label>
                    <select class="form-select-rules" name="tasas_incluidas">
                        <option value="excluidas" <?php if($rule['tasas_incluidas'] == 'excluidas') {echo 'selected';} ?>>Excluidas</option>
                        <option value="incluidas" <?php if($rule['tasas_incluidas'] == 'incluidas') {echo 'selected';} ?>>Incluidas</option>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                    <div class="form-group-info">
                        <span>Elige si el descuento se realiza con el IVA (Incluidas) o sin el IVA (Excluidas).</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Reducción *</label>
                    <input type="text" class="form-input" name="reduccion" autocomplete="off" value="<?php echo $rule['reduccion'] ?>">

                    <p class="input-error-info">Formato incorrecto.</p>

                    <div class="form-group-info">
                        <span>Si el tipo de reducción es porcentual, el rango sera de 0 a 1 (Ej: para un 10% de descuento sería 0.10). El único caracter separador válido será el punto, y solo se admitirán dos decimales.</span>
                    </div>
                </div>


                <div class="form-submit">
                    <?php 
                        //Solo los administradores podrán borrar
                        $permiso = intval($_SESSION['user']['permiso']);
                        if($permiso == 1) { 
                    ?>
                    <button class="form-delete-btn" type="button">Eliminar</button>
                    <?php 
                        }
                    ?>
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/descuentos/comerciales/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Editar regla comercial</button>
                </div>

            </form>

        </div>

        <!-- condiciones de las reglas comerciales -->
        <div class="conditions-included" id="condiciones_container">

            <h2 class="comercial-rules-title">Grupo de condiciones <span id="conditions-length"></span></h2>

            <div class="content-description">
                <p>Condiciones que has añadido a la regla comercial:</p>
            </div>
            
            <div class="conditions-included-group">
                <ul class="conditions-list-head">
                    <li>Tipo</li>
                    <li>Valor</li>
                    <li> </li>
                </ul>

                <!-- aquí van las condiciones -->
                <div id="conditions"><?php
                    //condiciones traidas desde php

                    for($i = 0; $i < $rule_cond -> num_rows; $i++) {
                        $fila = $rule_cond -> fetch_assoc();

                        echo '<ul class="conditions-list-body" id="'.$fila['tipo'].'_'.$fila['valor_id'].'" data-tipo="'.$fila['tipo'].'" data-valor-id="'.$fila['valor_id'].'" data-valor-nombre="'.$fila['valor_nombre'].'">
                        <li>'.getConditionType($fila['tipo']).'</li>
                        <li>'.$fila['valor_nombre'].'</li>
                        <li>
                            <button data-id="'.$fila['tipo'].'_'.$fila['valor_id'].'" class="btn-condition-delete" >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </li>
                        </ul>';
                    }
                ?></div>

            </div>
            

        </div> 

        <div class="comercial-rules-container">

            <h2 class="comercial-rules-title" id="titulo">Condiciones</h2>

            <div class="content-description">
                <p>Aquí podrás añadir a la regla comercial todos los condicionantes que desees. Cuantos más condicionantes, a mayor número de productos afectará.</p>
            </div>

            <?php
                $genericManager = new GenericManager();

                $categorias = $genericManager -> getCategories();
                $subcategorias = $genericManager -> getSubcategories();
                $colores = $genericManager -> getColors();
                $generos = $genericManager -> getGenders();
                $marcas = $genericManager -> getBrands();
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
                                if($fila['id'] != '0') {
                                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                                }
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
                                if($fila['id'] != '0') {
                                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                                }
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
                                if($fila['id'] != '0') {
                                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                                }
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
                                if($fila['id'] != '0') {
                                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                                }
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
<!-- area de confirmación de borrado -->
<div class="overlay-delete">
    <button id="close-form-delete" class="close-form-delete">
        <i class="bi bi-x-lg"></i>
    </button>
    <div class="confirm-delete">
        <div class="icon-warning">
            <i class="bi bi-exclamation-octagon"></i>
        </div>
        <h2>¿Seguro que deseas eliminar?</h2>
        <p class="form-delete-text-info">Borrar una regla comercial es irreversible. También borrarás sus condiciones. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar regla comercial</span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar regla comercial">

                <p class="input-error-info">Debes escribir el texto exacto.</p>
            </div>
            <div class="form-submit">
                <button class="form-delete-btn" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<?php
    function getConditionType($string) {
        switch ($string) {
            case 'categorias':
                return 'Categoría';
            case 'subcategorias':
                return 'Subcategoría';
            case 'colores':
                return 'Color';
            case 'genero':
                return 'Género';
            case 'marcas':
                return 'Marcas';
            default:
                break;
        }
    }
?>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleDeletePopup.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/descuentos/reglasComerciales.js"; ?>"></script>

<?php require_once __DIR__ . '/../../../footer.php'; ?>