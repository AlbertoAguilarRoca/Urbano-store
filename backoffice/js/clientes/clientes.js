/* Archivo para controlar la subida y edicion de clientes */

import { formValidation, setMessageInfo } from "../helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../helpers/lengthCounterInput.js";
import { generatePassword } from "../helpers/passwordGenerator.js";

const form = document.getElementById('form-cliente');
const formGroups = form.querySelectorAll('.form-group');
const formDelete = document.getElementById('form-delete');
const generatePassBtn = document.getElementById('generatePass');
const eye = document.getElementById('eye');

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

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/ClientController.php?id_cliente=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}

if(formDelete) {
    formDelete.addEventListener('submit', async (e) => {
        e.preventDefault();
    
        if (formValidation(formDelete)) {
            const params = new URLSearchParams(document.location.search);
            const id = params.get('id_cliente');
            const resp = await fetch(`http://localhost/urban/backoffice/controllers/ClientController.php?id_cliente=${id}`, {
                method: 'DELETE'
            });
    
            const data = await resp.json();
    
            if (data === true) {
                window.location = 'http://localhost/urban/backoffice/clientes/';
                console.log('Borrado correcto');
            } else {
                alert('Error al borrar: ' + data);
            }
    
        } else {
            console.log('Email con errores.');
        }
    
    });
}

generatePassBtn.addEventListener('click', () => {

    const pass = generatePassword(15);
    const passInput1 = document.getElementById('password1');
    const passInput2 = document.getElementById('password2');

    passInput1.value = pass;

    if(passInput2) {passInput2.value = pass}

});


/**
 * Evento para mostrar la contraseña del usuario
 */
eye.addEventListener('click', () => {
    const passInput1 = document.getElementById('password1');
    const passInput2 = document.getElementById('password2');

    changePasswordType(passInput1);

    if(passInput2) { changePasswordType(passInput2);}
});

const changePasswordType = (input) => {
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}