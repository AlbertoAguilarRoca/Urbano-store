
/* Archivo para gestionar la creación y edicion de marcas */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";

const form = document.getElementById('form-brands');

//Recojo los form groups del formulario
const formGroups = form.querySelectorAll('.form-group');

//Listener para contar los caracteres de los inputs
formGroups.forEach( (group) => {
    lenthCounterForm(group);
});

form.addEventListener('submit', async(e) => {
    e.preventDefault();

    if(formValidation(form)) {
        const formData = new FormData(form);
        const resp = await createNewBrand(formData);

        //Establece el contador de caracteres a 0
        resp && setLengthToInitial();
        setMessageInfo(resp, form);

    } else {
        console.log('Email con errores.');
    }

});

async function createNewBrand(formData) {
    const resp = await fetch('http://localhost/urban/backoffice/controllers/BrandController.php', {
        method: 'POST',
        body: formData
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}



