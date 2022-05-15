/* Archivo para gestionar las condiciones de los descuentos comerciales */

import {formValidation, setMessageInfo} from '../helpers/formValidation.js';
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";


let condiciones = [];
const cond_container = document.getElementById('condiciones_container');
const cond_total = document.getElementById('conditions-length');
const rules_btn = document.querySelectorAll('.rules-btn');
const cond_included_box = document.getElementById('conditions');
const form = document.getElementById('form-regla-comercial');
const formGroups = form.querySelectorAll('.form-group');
const formDelete = document.getElementById('form-delete');
const btn_delete_edit = document.querySelectorAll('.btn-condition-delete');
const list_conditions = document.querySelectorAll('.conditions-list-body');

formGroups.forEach((group) => {
    const input = group.querySelector('.form-input');
    const lengthCount = group.querySelector('.input-length-counter');
    if (!input || !lengthCount) {
        return;
    }

    lengthCount.innerText = `${input.value.length}/${input.getAttribute('maxlength')}`;
        lenthCounterForm(group);
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    if(formValidation(form)) {
        const formData = new FormData(form);
        const resp = await sendData(formData);

        //Establece el contador de caracteres a 0
        if(resp)  {
            setLengthToInitial();
            cond_included_box.innerHTML = '';
            isConditionsAdded();
            cond_total.innerText = '(' + condiciones.length + ')';
            condiciones = [];
        }
        setMessageInfo(resp, form);
    } else {
        console.log('Formulario NO valido');
    }
});

const sendData = async (formData) => {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('id_regla');

    if(condiciones.length > 0) {
        formData.append('condiciones', JSON.stringify(condiciones));
    }

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/RulesController.php?id_regla=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}


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

        //Con este if comprobamos que no se haya creado ya esa condicion
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
            borrarCondicion(e);
        });
    });
}

/* Cuando se quiera editar, debe haber un listener habilitado desde el momento que se carga, y rellenar el array de condiciones con las que ya trae de la bd */
if(btn_delete_edit) {
    btn_delete_edit.forEach( (btn) => {
        btn.addEventListener('click', (e) => {
            borrarCondicion(e);
        });
    });
}

if(list_conditions) {
    list_conditions.forEach( cond => {
        const tipo = cond.getAttribute('data-tipo');
        const valor_id = cond.getAttribute('data-valor-id');
        const valor_nombre = cond.getAttribute('data-valor-nombre');
    
        condiciones.push({
            tipo: tipo, //tipo de condicionen mayus
            id: valor_id, //id del elemento condicional
            valor: valor_nombre, //texto del elemento
        });
    });
}

if(formDelete) {
    formDelete.addEventListener('submit', async (e) => {
        e.preventDefault();
    
        if (formValidation(formDelete)) {
            const params = new URLSearchParams(document.location.search);
            const id = params.get('id_regla');
            const resp = await fetch(`http://localhost/urban/backoffice/controllers/RulesController.php?id_regla=${id}`, {
                method: 'DELETE'
            });
    
            const data = await resp.json();
    
            if (data === true) {
                window.location = 'http://localhost/urban/backoffice/catalogo/descuentos/comerciales/';
                console.log('Borrado correcto');
            } else {
                alert('Error al borrar: ' + data);
            }
    
        } else {
            console.log('Email con errores.');
        }
    
    });
}