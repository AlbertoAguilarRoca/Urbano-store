<?php 

    include_once __DIR__ . './security/ControlAcceso.php';
    $control = new ControlAcceso();
    require_once __DIR__ . '/./head.php'; 

?>


<div class="loading" id="loading">
    <div class="lds-ripple"><div></div><div></div></div>
</div>

<div class="content">
    <div class="gallery">

        <div class="gallery_mini">

        </div>

        <div class="main_foto" id="main_foto">

        </div>

    </div>

    <div class="product_sheet_info">

        <h1 class="product_title"></h1>
        <p class="product_brand"></p>
        <div class="product_price">
            <span class="original_price">33.00 €</span>
            <span class="discount_price">25.95 €</span>
        </div>

        <div class="product_color">
            <p class="color">Color <span class="color_name"></span></p>
        </div>

        <div class="related_product">
            <ul class="related_product_list">
                
            </ul>
        </div>

        <p class="size_title">Talla</p>
        <div class="select_box">
            <select id="select_size" class="select_size">
                <option value="" disabled selected>Selecciona una talla</option>
            </select>
            <p class="select_error_info">Debes seleccionar una talla</p>
        </div>


        <div class="add_product_btn">
            <button class="add_to_shop_btn" id="add_btn">Añadir a la cesta</button>
            <button class="add_to_wishlist_btn"><i class="bi bi-heart"></i></button>
        </div>

        <div class="shipping_info">

            <div class="shipping_text">
                <div class="shipping_icon">
                    <i class="bi bi-truck"></i>
                </div>

                <p>Envío estándar y recogida en punto de entrega gratis en pedidos de más de 50 €.</p>
            </div>

            <div class="refund_text">
                <div class="refund_icon">
                    <i class="bi bi-reply-all"></i>
                </div>

                <p>¿No estás seguro? Pruébatelo. Devuélvelo gratuitamente en un plazo de 30 días.</p>
            </div>

        </div>

        <div class="product_desc">
            <div class="desc_title">
                <p>Descripción y características</p>
            </div>
            <p class="desc_text">La camiseta de manga corta Otherside está confeccionada en algodón 100% de alto gramaje, cardado e hilado en anillos, e incluye gráficos de la marca con el esqueleto en el lado izquierdo del pecho y en la espalda. Corte clásico.</p>
            <p><strong>Ref.</strong> rwehgGERGrge4</p>
        </div>

    </div> <!-- final de producto info -->



</div> <!-- final de content --> 

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/decimal.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/product_sheet.js"; ?>"></script>
<?php require_once __DIR__ . '/./footer.php'; ?>