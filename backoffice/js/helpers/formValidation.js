
export const formValidation = (form) => {

    const formGroups = form.querySelectorAll('.form-group');
    let formValidated = true;

    formGroups.forEach((group) => {

        if (group.hasAttribute('data-required')) {
            const type = group.getAttribute('data-type');
            const input = searchElement(group);

            //Si encuentra el input, pasa a validarlo
            if (!!input) {
                if (selectValidation(type, input)) {
                    group.classList.remove('error-form');
                } else {
                    group.classList.add('error-form');
                    formValidated = false;
                }
            } else {
                formValidated = false;
            }
        }

    });

    return formValidated;
}

//Funcion para informar al usuario si la accion se ha realizado bien o no.
export const setMessageInfo = (resp, form) => {
    const mensaje = document.getElementById('form-message');
    const btn_close = document.querySelector('.form-message-close');
    if (resp === true) {
        mensaje.classList.contains('error') && mensaje.classList.remove('error');
        mensaje.classList.add('success');
        const mensaje_text = document.getElementById('form-message-text');
        mensaje_text.innerText = 'Operación realizada con éxito.';
        form.reset();
    } else {
        mensaje.classList.contains('success') && mensaje.classList.remove('success');
        const mensaje_text = document.getElementById('form-message-text');
        mensaje.classList.add('error');
        mensaje_text.innerText = resp;
    }

    btn_close.addEventListener('click', () => {
        mensaje.classList.contains('success') ? mensaje.classList.remove('success') : mensaje.classList.remove('error');
    });

}

function selectValidation(type, input) {
    switch (type) {
        case 'email':
            return validateEmail(input);
        case 'text':
            return validateInput(input);
        case 'select':
            return validateSelect(input);
        case 'search':
            return validateSearch(input);
        case 'delete':
            return validateDeleteForm(input);
        case 'color':
            return true;
        case 'password-new':
            return validatePassword(input);
        case 'select-date':
            return validateSelectDate(input);
        case 'nif':
            return validateIdentity(input);
        case 'postal':
            return validatePostal(input);
        case 'telefono':
            return validatePhone(input);

        default:
            console.error('Error en la validación de un input -> ' + type);
            break;
    }
}

/* para que una contraseña sea valida:
* No puede estar vacía
* Tiene que tener más de 8 caracteres
* Debe repetir la password y ser la misma en caso de que la tenga
*/
const validatePassword = (input) => {
    const valor = input.value;
    const msn_error = input.parentNode.querySelector('.input-error-info');
    const pass_format = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/;

    //Si el password no es data-required false y esta vacio, no habrá que validarlo
    if (input.parentNode.getAttribute('data-required') == 'false' && valor === '') {
        return true;
    }

    //Si está marcado como invitado, la validación no será necesaria
    const invitado = document.getElementById('invitado');
    if (invitado.checked) {
        return true;
    }

    if (valor.length < 8) {
        msn_error.innerText = 'La contraseña debe tener 8 caracteres mínimo.';
        return false;
    }

    if (!new RegExp(pass_format).test(valor)) {
        msn_error.innerText = 'La contraseña debe tener una mayúscula y un dígito como mínimo.';
        return false;
    }

    if (input.hasAttribute('data-element')) {
        const input2 = document.getElementById(input.getAttribute('data-element'));

        if (valor !== input2.value) {
            msn_error.innerText = 'Las contraseñas deben ser iguales.';
            input2.parentNode.classList.add('error-form');
            return false;
        } else {
            input2.parentNode.classList.remove('error-form');
        }
    }

    return true;
}

const validatePostal = (input) => {
    const valor = input.value;

    const exp = /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/;

    if (new RegExp(exp).test(valor)) {
        return true;
    } else {
        return false;
    }

}

const validatePhone = (input) => {
    const valor = input.value;

    //solo admite numeros sin espacios y con + al principio opcional
    const exp = /(\+[0-9]{2,3})?[0-9]{9,15}/;

    if (new RegExp(exp).test(valor)) {
        //console.log('Es buen numero')
        return true;
    } else {
        //console.log('Malo')
        return false;
    }
}

const validateIdentity = (input) => {

    const valor = input.value;
    const letras = ['A','B','C','D','E','F','G','H','J','N','P','Q','R','S','U','V','W'];
    const tipo = letras.find( letra => valor[0] === letra);


    if(tipo) {
        return validateNif(valor, letras);
    } else {
        return validateDni(valor);
    }

}

const validateDni = (dni) => {
    console.log('DNI')
    var numero;
    var letr;
    var letra;
    var expresion_regular_dni;

    expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

    if (expresion_regular_dni.test(dni) == true) {
        numero = dni.substr(0, dni.length - 1);
        letr = dni.substr(dni.length - 1, 1);
        numero = numero % 23;
        letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra = letra.substring(numero, numero + 1);
        if (letra != letr.toUpperCase()) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }

}


const validateNif = (cif, letters) => {
    console.log('NIF')
    if (!cif || cif.length !== 9) {
        return false;
    }

    var digits = cif.substr(1, cif.length - 2);
    var letter = cif.substr(0, 1);
    var control = cif.substr(cif.length - 1);
    var sum = 0;
    var i;
    var digit;

    if (!letter.match(/[A-Z]/)) {
        return false;
    }

    for (i = 0; i < digits.length; ++i) {
        digit = parseInt(digits[i]);

        if (isNaN(digit)) {
            return false;
        }

        if (i % 2 === 0) {
            digit *= 2;
            if (digit > 9) {
                digit = parseInt(digit / 10) + (digit % 10);
            }

            sum += digit;
        } else {
            sum += digit;
        }
    }

    sum %= 10;
    if (sum !== 0) {
        digit = 10 - sum;
    } else {
        digit = sum;
    }

    if (letter.match(/[ABEH]/)) {
        return String(digit) === control;
    }
    if (letter.match(/[NPQRSW]/)) {
        return letters[digit] === control;
    }

    return String(digit) === control || letters[digit] === control;

}

const validateDeleteForm = (input) => {
    const valor = input.value;
    const textToBeType = input.getAttribute('data-content-delete');
    console.log(textToBeType, valor);
    if (valor === textToBeType) {
        return true;
    } else {
        return false;
    }
}

const validateSearch = (input) => {
    const valor = input.value;
    if (valor && valor.length >= 3) {
        return true;
    } else {
        return false;
    }
}

const validateSelect = (input) => {
    const valor = input.value;
    if (valor && valor != '') {
        return true;
    } else {
        return false;
    }
}

const validateInput = (input) => {
    if (input.value === '') {
        return false;
    } else {
        return true;
    }
}

const validateEmail = (email) => {

    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (email.value.match(mailformat)) {
        return true;
    } else {
        return false;
    }

};


//Rellenar la fecha de cumpleaños no es obligatorio, pero si rellena un campo, debe rellenar el resto
const validateSelectDate = (selects) => {
    let valido = true;

    selects.forEach((select) => { });

    return valido;

}

//Como no sabemos que elemento hay que validar, hay que buscarlo
const searchElement = (group) => {
    let elemento = '';
    if (group.querySelector('.form-input')) {
        elemento = group.querySelector('.form-input');
    } else if (group.querySelector('.form-select')) {
        elemento = group.querySelector('.form-select');
    } else if (group.querySelector('.form-color')) {
        elemento = group.querySelector('.form-color');
    } else if (group.querySelectorAll('.form-select-date-input')) {
        elemento = group.querySelectorAll('.form-select-date-input');
    }

    return elemento;
}