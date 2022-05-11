/* Archivo para gestionar los pop ups para borrar registros de tablas */

const close_btn_delete = document.getElementById('close-form-delete');
const buttonDelete = document.querySelector('.form-delete-btn');
const overlayDelete = document.querySelector('.overlay-delete');


buttonDelete.addEventListener('click', () => overlayDelete.classList.add('show-delete-form'));

close_btn_delete.addEventListener('click', () => overlayDelete.classList.remove('show-delete-form'));