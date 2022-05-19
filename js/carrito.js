

const loader = document.getElementById('loading');

if(checkIfCardHasProducts()) {
    products_toCardDOM();
}


function products_toCardDOM() {

    loader.classList.add('info_loading');

    const sesion_productos = sessionStorage.getItem('carrito');
    const prod = JSON.parse(sesion_productos);

    //muestro los productos del carrito en el dom
    infoProductToDOM(prod);

    calcularImporte();

    loader.classList.remove('info_loading');
}

function calcularImporte() {
     //incluyo el subtotal
     const sub_price = document.getElementById('sub_price');
     const total_price = document.getElementById('total_price');
     const subTotal = calcSubTotal();
     let total = parseFloat(subTotal);
 
     //gastos de envio
     const shipping_price = document.getElementById('shipping_price');
     //pedido superior 50€
     if (shippingCalc(subTotal)) {
         shipping_price.innerText = 'Gratuito';
     } else {
         shipping_price.innerText = '5 €';
         total += 5;
     }
 
     sub_price.innerText = `${subTotal} €`;
     total_price.innerText = `${total.toFixed(2)} €`;
}


//Comprueba si el carrito tiene productos, y muestra el compononente correcto
function checkIfCardHasProducts() {
    const sesion_productos = sessionStorage.getItem('carrito');
    const prod = JSON.parse(sesion_productos);

    const emptyCard = document.querySelector('.no_products_msg');
    const cardContent = document.querySelector('.carrito_content');

    if (sesion_productos && prod.length > 0) {
        //tiene productos
        emptyCard.classList.add('products_added');
        return true;
    } else {
        //no tiene productos
        emptyCard.classList.remove('products_added');
        cardContent.classList.add('no_product_added');
        return false;
    }
}

function infoProductToDOM(arr) {
    arr.forEach(e => {
        const cardProduc_box = document.querySelector('.carrito_products');

        const precio = new Decimal(e.precio);
        const precio_total = precio.mul(parseInt(e.cantidad)).toNumber().toFixed(2);

        cardProduc_box.innerHTML +=
            `<div class="carrito_product_detail" data-ref="${e.ref}" data-size-id="${e.talla_id}">
                <button class="delete_prod"></button>
                <div class="carrito_prod_img">
                    <img src="data:${e.tipo};base64,${e.img}" alt="${e.nombre}">
                </div>

                <div class="carrito_product_info">
                    <h2 class="carrito_product_title">${e.nombre}</h2>
                    <ul>
                        <li class="carrito_product_list_item">Talla: ${e.talla_text}</li>

                        <li class="carrito_product_list_item">Color: ${e.color}</li>
                    </ul>
                    <div class="carrito_prod_cantidad">
                        <input class="input_cantidad" type="number" max="3" min="1" value="${e.cantidad}">
                    </div>
                </div>

                <div class="carrito_product_price">
                    <span>${precio_total} €</span>
                </div>
            </div>`;

    });

    eventToDeleteBtn();
    eventToInput();
}

//Calcula si hay gastos de envio o no
function shippingCalc(amount) {
    return amount >= 50 ? true : false
}

function calcSubTotal() {

    const sesion_productos = sessionStorage.getItem('carrito');
    const prod = JSON.parse(sesion_productos);

    let subTotal = 0;

    prod.forEach(p => {
        const precio = new Decimal(p.precio);
        const precio_total = precio.mul(parseInt(p.cantidad)).toNumber().toFixed(2);

        subTotal += parseFloat(precio_total);
    });

    return subTotal.toFixed(2);
}

function eventToDeleteBtn() {

    //botones de borrar
    const del_btn = document.querySelectorAll('.delete_prod');

    del_btn.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const produc_box = e.target.parentNode;
            const ref_prod = produc_box.getAttribute('data-ref');
            const talla_prod = produc_box.getAttribute('data-size-id');

            const sesion_productos = sessionStorage.getItem('carrito');
            const prod = JSON.parse(sesion_productos);
            const aux_card = [...prod];

            //busco el producto en el carrito y lo borro del array y del dom
            prod.forEach((p, i) => {
                if (p.ref === ref_prod && p.talla_id === talla_prod) {
                    aux_card.splice(i, 1);
                }
            });

            //despues de borrar vuelvo a subir el arr a la sesion
            sessionStorage.setItem('carrito', JSON.stringify(aux_card));
            produc_box.remove();

            calcularImporte();

            checkIfCardHasProducts();
            
            const cesta = document.getElementById('total_productos_cesta');
            if (aux_card.length > 0) {
                cesta.innerText = aux_card.length;
            } else {
                cesta.classList.add('no_products');
            }
        });
    });
}


function eventToInput() {
    const input_cantidad = document.querySelectorAll('.input_cantidad');
    input_cantidad.forEach(input => {
        input.addEventListener('change' , (e) => {
            const cantidad = e.target.value;
            const produc_box = input.parentNode.parentNode.parentNode;
            const ref_prod = produc_box.getAttribute('data-ref');
            const talla_prod = produc_box.getAttribute('data-size-id');

            const sesion_productos = sessionStorage.getItem('carrito');
            const prod = JSON.parse(sesion_productos);
            const aux_card = [...prod];
    
            //busco el producto en el carrito y aumento la cantidad
            prod.forEach((p, i) => {
                if (p.ref === ref_prod && p.talla_id === talla_prod) {
                    aux_card[i].cantidad = cantidad;
                }
            });
    
           //despues de borrar vuelvo a subir el arr a la sesion
           sessionStorage.setItem('carrito', JSON.stringify(aux_card));

           const cardProductos_box = document.querySelector('.carrito_products');
           cardProductos_box.innerHTML = '';

           products_toCardDOM();
        });
    });
}
