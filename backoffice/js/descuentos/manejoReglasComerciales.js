/* Archivo para gestionar las condiciones de los descuentos comerciales */

import {formValidation} from '../helpers/formValidation.js';


const condiciones = [];
const cond_container = document.getElementById('condiciones_container');
const cond_total = document.getElementById('conditions-length');
const rules_btn = document.querySelectorAll('.rules-btn');
const cond_included_box = document.getElementById('conditions');
const form = document.getElementById('form-regla-comercial');


form.addEventListener('submit', (e) => {
    e.preventDefault();

    if(formValidation(form)) {
        console.log('Formulario valido');
    } else {
        console.log('Formulario NO valido');
    }
});


//compruebo si hay condiciones incluidas (parte de edicion)
isConditionsAdded();

/* Evento para registrar las condiciones que se añaden */
rules_btn.forEach(bnt => {
    bnt.addEventListener('click', (e) => {

        const select = e.target.parentNode.querySelector('.form-select-condition');
        
        /* guardamos el tipo y el valor */
        const select_type = select.getAttribute('data-condition');
        const select_value = select.value;
        const select_text = select.options[select.selectedIndex].text;

        const cond = {
            tipo: select_type, //tipo de condicion
            tipo_refact: getConditionType(select_type), //tipo con acentos y primera letra en mayus
            id: select_value, //id del elemento condicional
            valor: select_text, //texto del elemento
            cond_id: `${select_type}_${select_value}`
        };

        if(!document.getElementById(cond.cond_id)) {
            condiciones.push(cond);

            addConditionsToDOM(cond);
            isConditionsAdded();
            cond_total.innerText = '(' + condiciones.length + ')';
            //añado un event listener a cada boton X
            const delete_btn = document.querySelectorAll('.btn-condition-delete');
            setEventToBtn(delete_btn);
        }
    });
});



//Incluye la condicion añadida
function addConditionsToDOM(cond) {
    cond_included_box.innerHTML +=
        `<ul class="conditions-list-body" id="${cond.tipo}_${cond.id}">
            <li>${cond.tipo_refact}</li>
            <li>${cond.valor}</li>
            <li>
                <button data-id="${cond.tipo}_${cond.id}" class="btn-condition-delete" >
                    <i class="bi bi-x-lg"></i>
                </button>
            </li>
        </ul>`;
}

//Comprueba si hay condiciones añadidas y muestra u oculta el contenedor
function isConditionsAdded() {
    if (cond_included_box.hasChildNodes()) {
        cond_container.classList.remove('empty');
    } else {
        cond_container.classList.add('empty');
    }
}

function borrarCondicion(event) {
    //datos del boton clicado
    const btn = event.target.parentNode;

    //busca el data-id del boton, que se corresponde con el id de la lista
    const id = btn.getAttribute('data-id');
    //busca en indice donde se encuentra la condicion a borrar
    const idx_cond = condiciones.findIndex( (cond) => cond.cond_id === id);

    //Borro del array la condicion
    condiciones.splice(idx_cond, 1);
    //borro del dom la condicion
    document.getElementById(id).remove();
    //actualizo el contado de condiciones
    cond_total.innerText = '(' + condiciones.length + ')';
    isConditionsAdded();
}

//retorna el nombre en base a la categoria
function getConditionType(data) {
    switch (data) {
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

function setEventToBtn(delete_btn) {
    delete_btn.forEach( (btn) => {
        btn.addEventListener('click', (e) => {
            borrarCondicion(e)
        });
    });
}