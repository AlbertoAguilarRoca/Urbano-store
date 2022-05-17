

const menu_burger = document.getElementById('menu_burger');
const header = document.getElementById('header');
const nav_item = document.querySelectorAll('.nav_head_item');
const nav = document.getElementById('nav');

menu_burger.addEventListener('click', () => {

    header.classList.toggle('show_menu');
    nav.classList.toggle('show_menu_nav');

});


nav_item.forEach(item => {
    item.addEventListener('click', () => {
        const id_nav = item.getAttribute('data-item');
        const nav_to_show = document.getElementById(id_nav);
        //compruebo si existe algun nav abierto
        const nav_display = document.querySelector('.show_nav');

        if(nav_display && nav_display != nav_to_show) {
            nav_display.classList.remove('show_nav');

            nav_to_show.classList.add('show_nav');
        }

    });
});