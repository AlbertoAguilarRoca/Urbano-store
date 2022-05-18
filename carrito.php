<?php require_once __DIR__ . '/./head.php'; ?>


<div class="loading" id="loading">
    <div class="lds-ripple"><div></div><div></div></div>
</div>

<div class="carrito">

    <h1 class="carrito_title">Cesta</h1>

    <div class="no_products_msg products_added">
        <p>Tu carrito está vacío</p>
    </div>

    <div class="promocional_cod_info">
        <p id="promo_cod_text">El código promocional no es válido.</p>
    </div>

    <div class="carrito_content">

        <div class="carrito_products">

            <div class="carrito_product_detail">
                <button class="delete_prod"><i class="bi bi-trash3"></i></button>
                <div class="carrito_prod_img">
                    <img src="https://images.unsplash.com/photo-1652821173271-c2af1ef81331?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=80&raw_url=true&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400" alt="">
                </div>

                <div class="carrito_product_info">
                    <h2 class="carrito_product_title">Camiseta Otherwise</h2>
                    <ul>
                        <li class="carrito_product_list_item">Talla: XS</li>
                        <li class="carrito_product_list_item">Color: Negro</li>
                    </ul>
                    <div class="carrito_prod_cantidad">
                        <input type="number" max="3" min="1" value="1">
                    </div>
                </div>

                <div class="carrito_product_price">
                    <span>33.00 €</span>
                </div>
            </div>


            <div class="carrito_product_detail">
                <button class="delete_prod"><i class="bi bi-trash3"></i></button>
                <div class="carrito_prod_img">
                    <img src="https://images.unsplash.com/photo-1652811230783-fa08dec5e21b?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=80&raw_url=true&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400" alt="">
                </div>

                <div class="carrito_product_info">
                    <h2 class="carrito_product_title">Camiseta Left Chest Logo que me compro mi padre</h2>
                    <ul>
                        <li class="carrito_product_list_item">Talla: M</li>
                        <li class="carrito_product_list_item">Color: Azul</li>
                    </ul>
                    <div class="carrito_prod_cantidad">
                        <input type="number" max="3" min="1" value="1">
                        <span>No disponemos de tanto stock</span>
                    </div>
                </div>

                <div class="carrito_product_price">
                    <span>45.00 €</span>
                </div>
            </div>

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
                <span id="sub_price">88.00 €</span>
            </div>

            <div class="shipping_price">
                <span>Envío Estandar</span>
                <span id="shipping_price">Gratuito</span>
            </div>

            <div class="total_price">
                <div>
                    Total
                    <p class="tax_info">(21% IVA incluido)</p>
                </div>
                <span id="total_price">88.00 €</span>
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




<?php require_once __DIR__ . '/./footer.php'; ?>