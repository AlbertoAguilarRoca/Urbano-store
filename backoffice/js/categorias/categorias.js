/* En este archivo se realizaran las peticiones para la subida y edicion de categorias, y la validacion de los formularios. */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";

const form = document.getElementById('form-category');
const formGroups = form.querySelectorAll('.form-group');
const formDelete = document.getElementById('form-delete');

formGroups.forEach((group) => {
    const input = group.querySelector('.form-input');
    const lengthCount = group.querySelector('.input-length-counter');
    lengthCount.innerText = `${input.value.length}/${input.getAttribute('maxlength')}`;
    lenthCounterForm(group);
});

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

if(formDelete) {
    formDelete.addEventListener('submit', async (e) => {
        e.preventDefault();
    
        if (formValidation(formDelete)) {
            const params = new URLSearchParams(document.location.search);
            const id = params.get('id');
            const resp = await fetch(`http://localhost/urban/backoffice/controllers/CategoryController.php?id=${id}`, {
                method: 'DELETE'
            });
    
            const data = await resp.json();
    
            if (data === true) {
                window.location = 'http://localhost/urban/backoffice/catalogo/categorias/';
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

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/CategoryController.php?id=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}