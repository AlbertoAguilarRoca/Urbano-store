<?php 

    require_once __DIR__ . '/./head.php'; 
    include_once __DIR__ . '/./backoffice/model/managers/ColorManager.php'; 
    include_once __DIR__ . '/./backoffice/model/managers/SizeManager.php';
    
    $colorManager = new ColorManager();
    $sizeManager = new SizeManager();

    $colores = $colorManager -> getAllColors();
    $tallas = $sizeManager -> getAllSizes();
    
?>

<div class="loading" id="loading">
    <div class="lds-ripple"><div></div><div></div></div>
</div>

<div class="content">

        <aside class="aside">
            <h2 class="aside_title">Hombre</h2>
            <p class="aside_item"><a href="#">Essentials</a></p>
            <p class="aside_item"><a href="#">Destacados</a></p>
            <p class="aside_item"><a href="#">Zapatillas</a></p>
            <p class="aside_item active"><a href="#">Ropa</a></p>
            <ul class="aside_list">
                <li class="aside_list_item"><a href="#">Chaquetas y abrigos</a></li>
                <li class="aside_list_item"><a href="#">Sudaderas</a></li>
                <li class="aside_list_item active"><a href="#">Camisetas</a></li>
                <li class="aside_list_item"><a href="#">Camisas</a></li>
                <li class="aside_list_item"><a href="#">Pantalones y chinos</a></li>
                <li class="aside_list_item"><a href="#">Vaqueros</a></li>
                <li class="aside_list_item"><a href="#">Shorts</a></li>
                <li class="aside_list_item"><a href="#">Ropa interior</a></li>
            </ul>
            <p class="aside_item"><a href="#">Complementos</a></p>

            <h2 class="aside_title">Filtros</h2>
            <div class="filtros">
                <p class="filter_title">Colores</p>
                <div class="filter_colors">
                    <?php 
                        for ($i=0; $i < $colores -> num_rows; $i++) { 
                            $fila = $colores -> fetch_assoc();
                            if($fila['id'] != '0') {
                                echo '<div class="color" style="background-color: '.$fila['codigo_hex'].';" data-color-id="'.$fila['id'].'"></div>';
                            }
                        }
                    ?>
                </div>
                
                <p class="filter_title">Tallas</p>
                <div class="filter_sizes">
                    
                    <?php 
                        for ($i=0; $i < $tallas -> num_rows; $i++) { 
                            $fila = $tallas -> fetch_assoc();
                            if($fila['id'] != '0' && $fila['id'] != 1) {
                                echo '<div class="talla" data-talla-id="'.$fila['id'].'">'.$fila['talla'].'</div>';
                            }
                        }
                    ?>
                </div>
                <input type="hidden" name="tallas" value="" id="sizes_input">
                <p class="filter_title">Precio</p>

                <div class="price_filter_box">
                    <div class="price-inputs">
                        <div class="field">
                            <span>Precio Min.</span>
                            <input type="number" class="input-min" id="input-min" min="0" max="650" value="0">
                        </div>
                        <div class="field">
                            <span>Precio Max.</span>
                            <input type="number" class="input-max" id="input-max" min="0" max="650" value="650">
                        </div>
                    </div>
                    <div class="slider">
                        <div class="progress"></div>
                    </div>

                    <div class="range-input">
                        <input type="range" min="0" max="650" value="0" class="min-range" id="min-range">
                        <input type="range" min="0" max="650" value="650" class="max-range" id="man-range">
                    </div>
                </div>

                <button class="filter_btn" id="appy_filter_btn">Aplicar filtros</button>
            </div>
        </aside>

        <main class="main">

            <div class="breadcrump">
                <p><a href="#">Inicio</a></p>
            </div>

            <h1 class="main_title" id="sub_title"></h1>

            <div class="main_productos" id="product_box">

                <!-- aqui se cargan los productos -->

            </div>



            <div class="load_product">
                <button class="load_product_btn" id="load_more">Cargar más productos</button>
            </div>

        </main>

    </div>




<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/decimal.js"; ?>"></script>
<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/helpers/inputRange.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/subcategoria.js"; ?>"></script>
<?php require_once __DIR__ . '/./footer.php'; ?>