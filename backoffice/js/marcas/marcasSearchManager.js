/* Archivo para gestionar el buscador de las marcas */

import { formValidation } from "../helpers/formValidation.js";

const form = document.getElementById('form-search');

form.addEventListener('submit', async(e) => {
    e.preventDefault();

    if(formValidation(form)) {
        const {origin, pathname} = window.location;
        const input = form.querySelector('.form-input').value;

        window.location = `${origin+pathname}?search=${input}`;
    } else {
        console.log('Error al buscar');
    }

});