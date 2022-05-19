<?php require_once __DIR__ . '/./head.php'; ?>


<div class="loading" id="loading">
    <div class="lds-ripple"><div></div><div></div></div>
</div>

<div class="carrito">

    <h1 class="carrito_title">Cesta</h1>

    <div class="no_products_msg">
        <p>Tu carrito está vacío</p>
    </div>

    <div class="promocional_cod_info">
        <p id="promo_cod_text">El código promocional no es válido.</p>
    </div>

    <div class="carrito_content">

        <div class="carrito_products">


        </div> <!--final carrito products-->

       
        <div class="carrito_pay">

            <div class="codigo_pro">
                <p class="codigo_title">
                    ¿Tienes un código promocional?
                </p>
                <input type="text" id="cod_promo" placeholder="Introducir código">
                <button class="promo_btn" disabled>Aplicar</button>
            </div>

            <div class="subtotal_price">
                <span>Subtotal</span>
                <span id="sub_price"></span>
            </div>

            <div class="shipping_price">
                <span>Envío Estandar</span>
                <span id="shipping_price"></span>
            </div>

            <div class="total_price">
                <div>
                    Total
                    <p class="tax_info">(21% IVA incluido)</p>
                </div>
                <span id="total_price"></span>
            </div>


            <div class="pay_btn_box">
                <button class="pay_btn">Realizar pago</button>
            </div>

            <div class="shipping_info">

                <div class="shipping_text">
                    <div class="shipping_icon">
                        <i class="bi bi-truck"></i>
                    </div>

                    <p>Entrega gratuita en pedidos superiores a 50 €</p>
                </div>

                <div class="refund_text">
                    <div class="refund_icon">
                        <i class="bi bi-reply-all"></i>
                    </div>

                    <p>Devoluciones gratuitas</p>
                </div>
            </div>

            <div class="pay_methods">
                <div class="method">
                    <img src="http://localhost/urban/src/img/visa.svg" alt="Logo visa">
                </div>
                <div class="method">
                    <img src="http://localhost/urban/src/img/paypal.svg" alt="Logo paypal">
                </div>
                <div class="method">
                    <img src="http://localhost/urban/src/img/mastercard-2.svg" alt="Logo mastercard">
                </div>
                <div class="method">
                    <img src="http://localhost/urban/src/img/google-pay.svg" alt="Logo visa">
                </div>
            </div>

        </div>



    </div>
</div> <!-- fin de carrito content --> 



<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/decimal.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/carrito.js"; ?>"></script>
<?php require_once __DIR__ . '/./footer.php'; ?>