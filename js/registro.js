
import { formValidation, setMessageInfo } from "../backoffice/js/helpers/formValidation.js";
import { lenthCounterForm, setLengthToInitial } from "../backoffice/js/helpers/lengthCounterInput.js";

const form = document.getElementById('form-cliente');
const formGroups = form.querySelectorAll('.form-group');

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

        resp && setTimeout(() => {
            window.location.replace('http://localhost/urban/login.php')
        }, 3000);
    } else {
        console.log('Formulario con errores');
    }

});

const sendData = async (formData) => {

    const resp = await fetch('http://localhost/urban/backoffice/controllers/RegisterController.php', {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}

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