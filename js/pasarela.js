import { formValidation, setMessageInfo } from "../backoffice/js/helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../backoffice/js/helpers/lengthCounterInput.js";

const bloque_1 = document.getElementById('bloque_1');
const bloque_2 = document.getElementById('bloque_2');
const next_btn = document.getElementById('siguiente');
const checkEmpresa = document.getElementById('empresa');
const form = document.getElementById('form-direccion');
const formGroups = form.querySelectorAll('.form-group');
const estados = document.querySelectorAll('.pasarela_estados');
const dir_fac_check = document.getElementById('dir_facturacion');
const back = document.getElementById('back_bloque_1');

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
        console.log('paso a bloque 2');
        bloque_1.classList.add('no_display');
        bloque_2.classList.remove('no_display');
        estados[0].classList.remove('activa');
        estados[1].classList.add('activa');
    } else {
        console.log('no paso al bloque 2');
    }

});

back.addEventListener('click', () => {
    bloque_2.classList.add('no_display');
    bloque_1.classList.remove('no_display');
    estados[1].classList.remove('activa');
    estados[2].classList.add('activa');
});

form.addEventListener('submit', (e) => {
    e.preventDefault();

    if(formValidation(bloque_2)) {
        console.log('Empieza proceso pago');
    } else {
        console.log('no empiezo el pago');
    }
});


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