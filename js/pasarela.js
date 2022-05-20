import { formValidation, setMessageInfo } from "../backoffice/js/helpers/formValidation.js";
import { lenthCounterForm } from "../backoffice/js/helpers/lengthCounterInput.js";

const bloque_1 = document.getElementById('bloque_1');
const bloque_2 = document.getElementById('bloque_2');
const next_btn = document.getElementById('siguiente');
const checkEmpresa = document.getElementById('empresa');
const form = document.getElementById('form-direccion');
const formGroups = form.querySelectorAll('.form-group');
const estados = document.querySelectorAll('.pasarela_estados');
const dir_fac_check = document.getElementById('dir_facturacion');
const back = document.getElementById('back_bloque_1');
let precioTotal = 0;
let productos = [];

formGroups.forEach((group) => {
    const input = group.querySelector('.form-input');
    const lengthCount = group.querySelector('.input-length-counter');
    if (!input || !lengthCount) {
        return;
    }

    lengthCount.innerText = `${input.value.length}/${input.getAttribute('maxlength')}`;
    lenthCounterForm(group);
});

next_btn.addEventListener('click', () => {

    if(formValidation(bloque_1)) {
        bloque_1.classList.add('no_display');
        bloque_2.classList.remove('no_display');
        estados[0].classList.remove('activa');
        estados[1].classList.add('activa');
    }

});

back.addEventListener('click', () => {
    bloque_2.classList.add('no_display');
    bloque_1.classList.remove('no_display');
    estados[1].classList.remove('activa');
    estados[0].classList.add('activa');
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('productos', JSON.stringify(productos));
    formData.append('importe', precioTotal);

    if(dir_fac_check.checked) {

        const resp = await sendData(formData);
        setMessageInfo(resp, form);
       
    } else {
        if(formValidation(bloque_2)) {
            const resp = await sendData(formData);
            setMessageInfo(resp, form);
        } else {
            console.log('no empiezo el pago');
        }
    }
});

async function sendData(formData) {
    const resp = await fetch(`http://localhost/urban/backoffice/controllers/PayController.php`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}


checkEmpresa.addEventListener('change', showFormCompany);

function showFormCompany() {
    const formCompany = document.getElementById('company-client-info');

    const formClientGroups = formCompany.querySelectorAll('.form-group');

    if (checkEmpresa.checked) {
        formCompany.classList.add('show-form');
        formClientGroups[0].setAttribute('data-required', 'true');
        formClientGroups[1].setAttribute('data-required', 'true');
    } else {
        formCompany.classList.remove('show-form');
        formClientGroups[0].removeAttribute('data-required');
        formClientGroups[1].removeAttribute('data-required');
    }
}

dir_fac_check.addEventListener('change', () => {

    const dir_fac = document.querySelector('.direccion_facturacion_form');

    if(dir_fac_check.checked) {
        dir_fac.classList.add('no_display');
    } else {
        dir_fac.classList.remove('no_display');
    }

});

/* PRECIO DE IMPORTE TOTAL */
calcularImporte();

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
    precioTotal = total.toFixed(2);
}

function calcSubTotal() {

    const sesion_productos = sessionStorage.getItem('carrito');
    const prod = JSON.parse(sesion_productos);

    let subTotal = 0;

    prod.forEach(p => {
        const precio = new Decimal(p.precio);
        const precio_total = precio.mul(parseInt(p.cantidad)).toNumber().toFixed(2);

        subTotal += parseFloat(precio_total);

        const producto = {
            ref: p.ref,
            cantidad: p.cantidad,
            talla_id: p.talla_id
        }

        productos.push(producto);
    });

    return subTotal.toFixed(2);
}

//Calcula si hay gastos de envio o no
function shippingCalc(amount) {
    return amount >= 50 ? true : false
}


//Evento para rellenar informacion
const select_address = document.getElementById('cliente_direccion');

if(select_address) {
    select_address.addEventListener('change', async (e) => {

        const id_direccion = e.target.value;
        const resp = await fetch(`http://localhost/urban/backoffice/controllers/DireccionController.php?id=${id_direccion}`, {
            method: 'GET'
        });
    
        const data = await resp.json();
    
        //cambio el input de control a yes para saber que la direccion de envio ya está guardada
        const control_input = document.getElementById('input-direccion-control');
        control_input.value = id_direccion;
    
    
        const direccion = document.getElementById('direccion');
        direccion.value = data.direccion;
    
        const direccion2 = document.getElementById('direccion2');
        direccion2.value = data.direccion2;
    
        const postal = document.getElementById('postal');
        postal.value = data.codigo_postal;
    
        const provincia = document.getElementById('provincia');
        provincia.value = data.provincia;
    
        const localidad = document.getElementById('localidad');
        localidad.value = data.localidad;
    
        const telefono = document.getElementById('telefono');
        telefono.value = data.telefono;
    });
    
}