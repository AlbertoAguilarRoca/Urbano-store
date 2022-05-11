
/* Archivo js para controlar las funcionalidades del menu */

//flecha del menu de usuario
const chevronUser = document.getElementById('chevron-user');
//menu de usuario
const menuUser = document.querySelector('.menu-user');
//Contenedores de las areas del menu abiertas
const menuGroups = document.querySelectorAll('.menu-nav-content-group');
//Listado de iconos
const icons = document.querySelectorAll('.menu-icons-list-item');
const menuHeader = document.getElementById('header-menu');

chevronUser.addEventListener('click', () => {
    menuUser.classList.toggle('show-options');
});

menuGroups.forEach((group) => {
    const chevron = group.querySelector('.chevron');
    if (chevron) {
        chevron.addEventListener('click', () => {

            const showList = document.querySelector('.show-list');
            if (showList && !group.classList.contains('show-list')) {
                //Si hay una lista mostrandose, y no la tiene el propio elemento, borra la clase.
                showList.classList.remove('show-list');
            }
            group.classList.toggle('show-list');
        });
    }
});

icons.forEach((icon) => {

    icon.addEventListener('click', () => {
        //Leo el modulo que quiero abrir
        const menuName = icon.getAttribute('data-name');

        //selecciono el menu que quiero abri, y el que estaba abierto previamente en caso de existir.
        const menuSelected = document.getElementById(menuName);
        const lastSelected = document.querySelector('.selected');

        //compruebo los id's de los iconos seleccionados para comparar si son los mismos
        const menuSelected_id = menuSelected.getAttribute('id');
        const lastSelected_id = (lastSelected) ? lastSelected.getAttribute('id') : null;

        const iconActive = document.querySelector('.active');

        if(iconActive && !icon.classList.contains('active')) {
            iconActive.classList.remove('active');
        }

        if (menuSelected_id === lastSelected_id) {
            //Si hago click en el mismo boton, cierro el menu y las opciones de usuario.
            icon.classList.remove('active');
            menuHeader.classList.remove('show-menu');
            menuSelected.classList.remove('selected');
            menuUser.classList.remove('show-options');
        } else {
            //si clico en otro boton, abro el menu correspondiente
            icon.classList.add('active');
            menuHeader.classList.add('show-menu');
            lastSelected && lastSelected.classList.remove('selected');
            menuSelected.classList.add('selected');
        }

    });

});