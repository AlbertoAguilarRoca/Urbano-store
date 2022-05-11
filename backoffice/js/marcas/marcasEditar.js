/* Archivo para editar marcas */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";

const form = document.getElementById('form-brands');
const formDelete = document.getElementById('form-delete');

//Recojo los form groups del formulario
const formGroups = form.querySelectorAll('.form-group');

//Listener para contar los caracteres de los inputs
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
        const resp = await updateBrand(formData);

        //Establece el contador de caracteres a 0
        resp && setLengthToInitial();
        setMessageInfo(resp, form);
    } else {
        console.log('Email con errores.');
    }

});

formDelete.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (formValidation(formDelete)) {
        const params = new URLSearchParams(document.location.search);
        const id = params.get('id');
        const resp = await fetch(`http://localhost/urban/backoffice/controllers/BrandController.php?id=${id}`, {
            method: 'DELETE'
        });
        const data = await resp.json();

        if (data === true) {
            window.location = 'http://localhost/urban/backoffice/catalogo/marcas/';
            console.log('Borrado correcto');
        } else {
            alert('Error al borrar: ' + data);
        }

    } else {
        console.log('Email con errores.');
    }

});

async function updateBrand(formData) {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('id');

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/BrandController.php?id=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}