/* En este archivo se realizaran las peticiones para la subida y edicion de categorias, y la validacion de los formularios. */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";

const form = document.getElementById('form-category');
const formGroups = form.querySelectorAll('.form-group');
const formDelete = document.getElementById('form-delete');
const selectCategory = document.getElementById('id_categoria');

formGroups.forEach((group) => {
    const input = group.querySelector('.form-input');
    const lengthCount = group.querySelector('.input-length-counter');

    if (input) {
        lengthCount.innerText = `${input.value.length}/${input.getAttribute('maxlength')}`;
        lenthCounterForm(group);
    }
});

//Evento para evitar activar el estado cuando la categoria padre está inactiva
selectCategory.addEventListener('change', ({target}) => {
    const selectedOption = target.options[ target.selectedIndex ];
    const categoryAvailability = selectedOption.getAttribute('data-status');
    const status = document.getElementById('status');
    const statusCheckbox = document.getElementById('status-checkbox');
    const statusInfo = document.getElementById('status-info');

    if(categoryAvailability === '0') {
        status.setAttribute('data-availability', 'not-available');

        status.classList.add('inactivo');
        statusInfo.innerText = 'Inactivo';
        statusCheckbox.checked = false;

    } else {
        status.setAttribute('data-availability', 'available');
        status.classList.remove('inactivo');
        statusInfo.innerText = 'Activo';
        statusCheckbox.checked = true;
    }

})

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (formValidation(form)) {
        const formData = new FormData(form);
        const resp = await sendData(formData);

        //Establece el contador de caracteres a 0
        resp && setLengthToInitial();
        setMessageInfo(resp, form);

    } else {
        console.log('Email con errores.');
    }

});

if (formDelete) {
    formDelete.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (formValidation(formDelete)) {
            const params = new URLSearchParams(document.location.search);
            const id = params.get('id');
            const resp = await fetch(`http://localhost/urban/backoffice/controllers/SubCategoryController.php?id=${id}`, {
                method: 'DELETE'
            });

            const data = await resp.json();

            if (data === true) {
                window.location = 'http://localhost/urban/backoffice/catalogo/categorias/subcategorias/';
                console.log('Borrado correcto');
            } else {
                alert('Error al borrar: ' + data);
            }

        } else {
            console.log('Email con errores.');
        }

    });
}

async function sendData(formData) {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('id');

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/SubCategoryController.php?id=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}