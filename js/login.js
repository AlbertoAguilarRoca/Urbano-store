import { formValidation, setMessageInfo } from "../backoffice/js/helpers/formValidation.js";


const form = document.getElementById('form-cliente');

form.addEventListener('submit', async(e) => {
    e.preventDefault();

    if(formValidation(form)) {
        const formData = new FormData(form);
        const resp = await sendData(formData);
        console.log(resp)

        resp && window.location.replace('http://localhost/urban/');
        
        setMessageInfo(resp, form);
    } else {
        console.log('Formulario con errores');
    }
});


const sendData = async (formData) => {

    const resp = await fetch('http://localhost/urban/backoffice/controllers/ClientLoginController.php', {
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