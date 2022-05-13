/* Archivo para controlar las funcionalidades de la subida y edicion de productos */

import { formValidation } from '../helpers/formValidation.js';
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";

const stock_tallas = [];
const prod_rel = [];

const form = document.getElementById('form-product');
const formGroups = form.querySelectorAll('.form-group');

//Boton para añadir imagenes
const btn_upload = document.getElementById('btn-upload');
//input type file para subir imagenes
const file_input = document.getElementById('file-input');
//contenedor donde se mostrarán las imagenes
const imageContainer = document.getElementById('display-images');
const info_images = document.getElementById('no-images-box');
//Boton para añadir tallas
const add_size_btn = document.getElementById('add-size');
//Boton para añadir ref de productos
const add_prod_ref_btn = document.getElementById('add-ref-product');

formGroups.forEach((group) => {
    const input = group.querySelector('.form-input');
    const lengthCount = group.querySelector('.input-length-counter');
    if (!input || !lengthCount) {
        return;
    }

    lengthCount.innerText = `${input.value.length}/${input.getAttribute('maxlength')}`;
        lenthCounterForm(group);
});

form.addEventListener('submit', (e) => {
    e.preventDefault();

    if(formValidation(form)) {
        console.log('Formulario valido');
    } else {
        console.log('Formulario NO valido');
    }
});

/* Evento para abrir el selector de archivos de imagen */
btn_upload.addEventListener('click', () => {
    file_input.click();
});

file_input.addEventListener('change', () => {
    previewImages();
});

//funcion que mostrará las imagenes que se suban
function previewImages() {
    const imagenes = file_input.files;

    if (imagenes.length > 0) {
        info_images.classList.add('images-upladed');
    }

    for (let img of imagenes) {
        setReaderToFile(img);
    }

    //Para añadir un listener de click al boton de close de las imagenes, tenemos que establecer un timeout para que pueda coger los botones del dom
    setTimeout(() => {
        const del_btn = document.querySelectorAll('.delete-btn-image');
        setListenerToDeleteBtn(del_btn);
    }, 1000);
    

}

function setReaderToFile(img) {
    let reader = new FileReader();
    reader.onload = () => {
        imageContainer.innerHTML +=
            `<div class="product-img">
                    <button type="button" class="delete-btn-image">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                    <img src="${reader.result}" alt="${img.name}">
                </div>`;
    }
    reader.readAsDataURL(img);
}

function setListenerToDeleteBtn(del_btn) {
    del_btn.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            console.log(e);
        });
    });
}

/* AÑADIR Y BORRAR STOCK DE TALLAS */
add_size_btn.addEventListener('click', () => {
    const size_select = document.getElementById('size');
    //id de la talla
    const select_value = size_select.value;
    //texto de la talla
    const select_text = size_select.options[size_select.selectedIndex].text;
    //cantidad de stock
    const stock = document.getElementById('size-stock').value;
    //cantidad de stock mínimo
    const stock_min = document.getElementById('rotura-stock').value;

    const sizeProduct = {
        id: select_value + '_' + select_text.replace(/\s/g, ''),
        talla_id: select_value,
        talla_text: select_text,
        stock: stock,
        stock_min: stock_min
    }

    if(!document.getElementById(sizeProduct.id) && select_value != '' && stock > stock_min) {

        if(stock_min == '') {sizeProduct.stock_min = 0}

        stock_tallas.push(sizeProduct);
        addProductSize(sizeProduct);

        //añado un event listener a cada boton X
        const delete_btn = document.querySelectorAll('.btn-delete-size');
        setEventToDeleteSize(delete_btn);
    }

});

/* AÑADIR Y BORRAR REFERENCIAS DE PRODUCTOS */
add_prod_ref_btn.addEventListener('click', () => {
    const ref_product = document.getElementById('ref_product').value;

    const ref = {
        id: ref_product
    }

    if(!document.getElementById(ref.id) && ref_product != '') {

        prod_rel.push(ref);
        addProductRef(ref);
        console.log(prod_rel)
        const delete_btn_ref = document.querySelectorAll('.btn-delete-ref');
        setEventToDeleteRef(delete_btn_ref);
    }
});



function addProductSize(s) {
    //contenedor donde se añaden los datos
    const size_box = document.getElementById('tallas-contenedor');
    size_box.innerHTML += 
        `<ul class="conditions-list-body" id="${s.id}">
            <li>Talla: ${s.talla_text}</li>
            <li>Cantidad: ${s.stock}</li>
            <li>Stock mínimo: ${s.stock_min}</li>
            <li>
                <button type="button" data-id="${s.id}" class="btn-condition-delete btn-delete-size" >
                    <i class="bi bi-x-lg"></i>
                </button>
            </li>
        </ul>`;
}

function addProductRef(s) {
    //contenedor donde se añaden los datos
    const ref_box = document.getElementById('ref-product-contenedor');
    ref_box.innerHTML += 
        `<ul class="conditions-list-body" id="${s.id}">
            <li>Referencia: ${s.id}</li>
            <li>
                <button type="button" data-id="${s.id}" class="btn-condition-delete btn-delete-ref" >
                    <i class="bi bi-x-lg"></i>
                </button>
            </li>
        </ul>`;
}

function setEventToDeleteSize(delete_btn) {
    delete_btn.forEach( (btn) => {
        btn.addEventListener('click', (e) => {
            borrarCondicion(e, stock_tallas);
        });
    });
}

function setEventToDeleteRef(delete_btn) {
    delete_btn.forEach( (btn) => {
        btn.addEventListener('click', (e) => {
            borrarCondicion(e, prod_rel);
            console.log(prod_rel)
        });
    });
}

function borrarCondicion(event, arr) {
    //datos del boton clicado
    const btn = event.target.parentNode;

    //busca el data-id del boton, que se corresponde con el id de la lista
    const id = btn.getAttribute('data-id');
    //busca en indice donde se encuentra el objeto a borrar
    const idx_cond = arr.findIndex( (cond) => cond.id === id);

    //Borro del array
    arr.splice(idx_cond, 1);
    //borro del dom lo que necesito
    document.getElementById(id).remove();
}

