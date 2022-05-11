/* Fichero para controlar las validaciones y consumo de api de las direcciones */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";
import { API_KEY } from "../api/api-key.js";

const form = document.getElementById('form-direccion');
const formGroups = form.querySelectorAll('.form-group');
const formDelete = document.getElementById('form-delete');
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

form.addEventListener('submit', async(e) => {
    e.preventDefault();

    if(formValidation(form)) {
        console.log('Formulario valido');
        const formData = new FormData(form);
        const resp = await sendData(formData);
        
        //Establece el contador de caracteres a 0
        resp && setLengthToInitial();
        setMessageInfo(resp, form);
    } else {
        console.log('Formulario con errores');
    }

});

const sendData = async (formData) => {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('id_cliente');

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/DireccionController.php?id_cliente=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}


checkEmpresa.addEventListener('change', showFormCompany);

/* datos de provincias */
const getData = async (url) => {
    const peticion = await fetch(url, {
        method: 'GET'
    });
    
    const data = await peticion.json();
    
    return data.data;
}

const setProvinciasToSelect = async () => {
    const data = await getData(URL_PROVINCIAS);
    
    data.forEach( (city) => {
        const { CPRO, PRO } = city;
        const cityName = capitalizarPrimeraLetra(PRO);
        provincias.innerHTML += `<option data-cpro="${CPRO}" value="${cityName}">${cityName}</option>`;
    });   
}

const setLocalidades = async (value) => {
    const url = URL_MUNICIPIOS + `&CPRO=${value}`;
    const data = await getData(url);
    localidad.innerHTML = '<option value="" selected disabled>-- Seleccionar localidad --</option>';

    data.forEach( (mun) => {

        const { DMUN50 } = mun;
        const nombre = capitalizarPrimeraLetra(DMUN50);

        localidad.innerHTML += `<option value="${nombre}">${nombre}</option>`;
    });
}

setProvinciasToSelect();

provincias.addEventListener('change', async ({target}) => {
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

function showFormCompany() {
    const formCompany = document.getElementById('company-client-info');

    const formClientGroups = formCompany.querySelectorAll('.form-group');

    if(checkEmpresa.checked) {
        formCompany.classList.add('show-form');
        formClientGroups[0].setAttribute('data-required', 'true');
        formClientGroups[1].setAttribute('data-required', 'true');
    } else {
        formCompany.classList.remove('show-form');
        formClientGroups[0].removeAttribute('data-required');
        formClientGroups[1].removeAttribute('data-required');
    }
}

//al carga la pagina
showFormCompany();

