

const main_foto = document.getElementById('main_foto');
const loader = document.getElementById('loading');
const addBtn = document.getElementById('add_btn');
const select_size = document.getElementById('select_size');
//array con toda la info del producto
let producto_info = {};

productInfoToDom()
    .then(() => {
        const gallery = document.querySelectorAll('.mini_img img');
        append_main_foto(gallery[0]);
        setListenerToImg(gallery);
    });

function setListenerToImg(gallery) {
    gallery.forEach( foto => {
        foto.addEventListener('click', () => {
            append_main_foto(foto);
        });
    });
}

function append_main_foto(foto) {
    main_foto.removeChild(main_foto.firstChild);
    const foto_cloned = foto.cloneNode(false);
    main_foto.append(foto_cloned);
}

async function getProductInfo() {
    const query = location.search;

    const peticion = await fetch(`http://localhost/urban/backoffice/controllers/ProductCardController.php${query}`, {
        method: 'GET'
    });

    const data = await peticion.json();
    producto_info = data;
    return data;
}

async function productInfoToDom() {
    loader.classList.add('info_loading');
    const prod = await getProductInfo();

    const gallery_box = document.querySelector('.gallery_mini');


    //imagenes
    prod.imagenes.forEach( img => {
        gallery_box.innerHTML += 
            `<div class="mini_img">
                <img src="data:${img.tipo};base64,${img.img}" alt="${img.nombre}">
            </div>`;
    });

    //titulo
    const titulo = document.querySelector('.product_sheet_info .product_title');
    titulo.innerText = prod.info.nombre;
    //marca
    const marca = document.querySelector('.product_sheet_info .product_brand');
    marca.innerText = prod.info.marca;
    //precio
    const product_price = document.querySelector('.product_sheet_info .product_price');
    if(prod.descuento) {
        //el producto tiene descuento
    } else {
        const precio = new Decimal(parseFloat(prod.info.precio));
        const iva = 1 + parseFloat(prod.info.iva);
        product_price.innerText = precio.mul(iva).toNumber().toFixed(2) + ' €';
    }
    //color
    const product_color = document.querySelector('.product_color');
    const name_color = document.querySelector('.color_name');
    if(prod.info.color != 'Sin color') {
        name_color.innerText = prod.info.color;
    } else {
        product_color.style.display = 'none';
    }

    //imagenes de productos rel
    const lista_pro_rel = document.querySelector('.related_product_list');
    prod.prod_rel.forEach( i => {
        lista_pro_rel.innerHTML += 
            `<li class="related_product_list_item">
                <a href="http://localhost/urban/producto.php?ref=${i.ref}">
                    <img src="data:${i.tipo};base64,${i.img}" alt="${i.nombre}">
                </a>
            </li>`;
    });

    //tallas
    
    prod.tallas.forEach( talla => {
        //compruebo si el product tiene stock de esa talla
        const checkSize = prod.tallas_stock.findIndex( stock =>  stock.id_talla === talla.id);
        if(checkSize != -1) {
            select_size.innerHTML += `<option value="${talla.id}">${talla.talla}</option>`;
        } else {
            select_size.innerHTML += `<option value="${talla.id}" disabled>${talla.talla} - Agotado</option>`;
        }

    });

    loader.classList.remove('info_loading');
}

//boton para añadir producto al carrito
addBtn.addEventListener('click', () => {
    const select_box = document.querySelector('.select_box');

    if(select_size.value == '') {
        select_box.classList.add('error');
        return;
    }

    //cojo los productos del carrito si hay
    let productos_carrito = [];
    const sesion_productos = sessionStorage.getItem('carrito');

    if(sesion_productos) {
        productos_carrito = JSON.parse(sesion_productos);
    }

    //compruebo si el producto que estoy metiendo está ya en el carrito
    let checkIfProductIsAdded = false
    
    productos_carrito.forEach( p => {
        if(p.ref === producto_info.referencia && p.talla_id === select_size.value) {
            checkIfProductIsAdded = true;
        }
    });

    if(checkIfProductIsAdded) {
        return;
    } 

    productos_carrito.push({
        ref: producto_info.referencia,
        cantidad: 1,
        talla_id: select_size.value,
        img: producto_info.imagenes[0].img,
        tipo: producto_info.imagenes[0].tipo,
        nombre: producto_info.imagenes[0].nombre,
        color: producto_info.info.color,
        precio: producto_info.info.precio,
        iva: producto_info.info.iva,
        talla_text: select_size.options[select_size.selectedIndex].text
    });

    sessionStorage.setItem('carrito', JSON.stringify(productos_carrito));

    const cesta = document.getElementById('total_productos_cesta');


    cesta.innerText = productos_carrito.length;
    cesta.classList.remove('no_products');

});

