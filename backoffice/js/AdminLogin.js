
/*
    En este archivo se controla y valida el acceso a la zona de administracion de la web. La comprobación en base de datos se hara en LoginController.
*/

const email = document.getElementById('email');
const email_label = document.getElementById('label-email');
const password = document.getElementById('password');
const password_label = document.getElementById('label-password');
const form = document.getElementById('form');
const errorArea = document.getElementById('error-area');
const errorText = document.getElementById('error-mensaje');
const eye = document.getElementById('eye');

/**
 * Evento para mostrar la contraseña del usuario
 */
eye.addEventListener('click', () => {
    if (password.type === 'password') {
        password.type = 'text';
    } else {
        password.type = 'password';
    }
});

/**
 * Evento para iniciar sesión
 */
form.addEventListener('submit', (e) => {
    e.preventDefault();

    if (email.value === '' || password.value === '') {

        setErrors();

    } else {
        removeErrors();
        checkUser();
    }

});


async function checkUser() {

    const formData = new FormData(form);

    const login = await fetch('http://localhost/urban/backoffice/controllers/LoginController.php', {
        method: 'POST',
        body: formData
    });

    const respuesta = await login.json();
    const data = await respuesta;

    if (data != true) {
        errorArea.classList.add('error');
        errorText.innerText = data;
    } else {
        removeErrors();
        window.location.replace('http://localhost/urban/backoffice/');
    }
}

function setErrors() {
    errorArea.classList.add('error');
    errorText.innerText = 'Los campos deben estar completos.';

    if (email.value === '') {
        email.classList.add('error-input');
        email_label.classList.add('error-label');
    } else {
        email.classList.remove('error-input');
        email_label.classList.remove('error-label');
    }

    if (password.value === '') {
        password.classList.add('error-input');
        password_label.classList.add('error-label');
    } else {
        password.classList.remove('error-input');
        password_label.classList.remove('error-label');
    }
}

function removeErrors() {
    errorArea.classList.remove('error');
    password.classList.remove('error-input');
    password_label.classList.remove('error-label');
    email.classList.remove('error-input');
    email_label.classList.remove('error-label');
}