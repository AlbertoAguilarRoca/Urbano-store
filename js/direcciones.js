

import { formValidation, setMessageInfo } from "../backoffice/js/helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../backoffice/js/helpers/lengthCounterInput.js";
import { API_KEY } from "../backoffice/js/api/api-key.js";

console.log('funcionando')

const form = document.getElementById('form-direccion');
const formGroups = form.querySelectorAll('.form-group');
const provincias = document.getElementById('provincias');
const localidad = document.getElementById('localidad');
const checkEmpresa = document.getElementById('empresa');
const key = API_KEY;
const URL_PROVINCIAS = `https://apiv1.geoapi.es/provincias?key=${key}`;
const URL_MUNICIPIOS = `https://apiv1.geoapi.es/municipios?key=${key}`;

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

    if (formValidation(form)) {
        console.log('Formulario valido');
        const formData = new FormData(form);
        const resp = await sendData(formData);

        //Establece el contador de caracteres a 0
        if(resp) {
            window.location.reload();
        } else {
            setMessageInfo(resp, form);
        }

        //resp && setLengthToInitial();
    } else {
        console.log('Formulario con errores');
    }

});

const sendData = async (formData) => {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('cliente');

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/DireccionFrontController.php?cliente=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}

const getData = async (url) => {
    const peticion = await fetch(url, {
        method: 'GET'
    });

    const data = await peticion.json();
    return data.data;
}

const setProvinciasToSelect = async () => {
    const data = await getData(URL_PROVINCIAS);

    const ciudadSelect = (provincias.hasAttribute('data-selected')) ? provincias.getAttribute('data-selected') : null;

    //Si hay una ciudad seleccionada, borro el contenido del select antes del forEach
    if (ciudadSelect) provincias.innerHTML = '';

    data.forEach((city) => {
        const { CPRO, PRO } = city;
        const cityName = capitalizarPrimeraLetra(PRO);

        if (cityName === ciudadSelect) {
            provincias.innerHTML += `<option selected data-cpro="${CPRO}" value="${cityName}">${cityName}</option>`;
            localidad.setAttribute('data-selected', CPRO);
        } else {
            provincias.innerHTML += `<option data-cpro="${CPRO}" value="${cityName}">${cityName}</option>`;
        }

    });
}

const setLocalidades = async (value) => {
    const url = URL_MUNICIPIOS + `&CPRO=${value}`;
    const data = await getData(url);

    //comparaciones para comprobar si estoy editando una direccion y ya hay un elemento seleccionado
    const localidadSelect = (localidad.hasAttribute('data-selected-city')) ? localidad.getAttribute('data-selected-city') : null;

    if (!localidadSelect) {
        localidad.innerHTML = '<option value="" selected disabled>-- Seleccionar localidad --</option>';
    }

    data.forEach((mun) => {

        const { DMUN50 } = mun;
        const nombre = capitalizarPrimeraLetra(DMUN50);

        if (nombre === localidadSelect) {
            localidad.innerHTML += `<option selected value="${nombre}">${nombre}</option>`;
        } else {
            localidad.innerHTML += `<option value="${nombre}">${nombre}</option>`;
        }

    });
}

setProvinciasToSelect()
    .then(() => {
        (localidad.hasAttribute('data-selected')) && setLocalidades(localidad.getAttribute('data-selected'));
    });


//console.log(provincias.options[provincias.selectedIndex].text);

provincias.addEventListener('change', async ({ target }) => {

    localidad.removeAttribute('data-selected');
    localidad.removeAttribute('data-selected-city');

    const select = target.options[target.selectedIndex];
    const cpro = select.getAttribute('data-cpro');

    setLocalidades(cpro);

});

const capitalizarPrimeraLetra = (str) => {
    const palabras = str.split(" ");

    for (let i = 0; i < palabras.length; i++) {
        palabras[i] = palabras[i][0] + palabras[i].substr(1).toLowerCase();
    }

    return palabras.join(" ");
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