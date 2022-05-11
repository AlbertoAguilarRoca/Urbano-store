
/*
    Archivo para controlar el funcionamiento de las barras de estado de los formularios.
*/

const statusEl = document.getElementById('status');
const statusCheckbox = document.getElementById('status-checkbox');
const statusInfo = document.getElementById('status-info');


statusEl.addEventListener('click', () => {

    if(statusEl.classList.contains('inactivo')) {

        if(statusEl.getAttribute('data-availability') === 'not-available') {
            return;
        }

        statusEl.classList.remove('inactivo');
        statusInfo.innerText = 'Activo';
        statusCheckbox.checked = true;

    } else {
        statusEl.classList.add('inactivo');
        statusInfo.innerText = 'Inactivo';
        statusCheckbox.checked = false;
    }

});