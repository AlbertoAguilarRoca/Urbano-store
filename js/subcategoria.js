


const product_box = document.getElementById('product_box');
const loader = document.getElementById('loading');
const load_more_btn = document.getElementById('load_more');
const title = document.getElementById('sub_title');
const colores = document.querySelectorAll('.color');
const tallas = document.querySelectorAll('.talla');
const appy_filter_btn = document.getElementById('appy_filter_btn');
//array de colores y tallas a sobre el que se quiere aplicar un filtro
let colors_to_filter = [];
let tallas_to_filter = [];
//total de productos que se van a cargar al principio
let product_to_load = 0;
//parametros de genero y subcategoria
const original_query = getParams();

showProducts();

load_more_btn.addEventListener('click', () => {
    product_to_load += 6;
    showProducts();
});

appy_filter_btn.addEventListener('click', () => {
    //reseteo los productos a cargar a 0
    product_to_load = 0;
    load_more_btn.removeAttribute('disabled');
    product_box.innerHTML = '';
    showProducts();

});

async function getProducts(query) {

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/ProductController.php${query}`, {
        method: 'GET'
    });
    const data = await resp.json();
    return data;
}


async function showProducts() {
    let query = updateQueryToFilters();
    loader.classList.add('info_loading');

    query = query + '&limit=' + product_to_load;

    const data = await getProducts(query);
    //quito la carga
    loader.classList.remove('info_loading');
    
    title.innerText = `${data.sub_name} (${data.size})`;
    console.log(data)
    if(data.size >= product_to_load) {
        data.productos.forEach( product  => {
            productToDom(product);
        });
    } else {
        load_more_btn.setAttribute('disabled', true);
    }

}

function getParams() {
    let queryDict = {}
    location.search.substring(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]});

    return `?gen=${queryDict.gen}&subcategoria=${queryDict.subcategoria}`;
}

function productToDom(product) {
    const precio = new Decimal(parseFloat(product.precio));
    const iva = parseFloat(product.iva);
    const precio_iva = precio.mul(1 + iva).toNumber().toFixed(2);

    product_box.innerHTML += 
        `<div class="product_card" data-ref-prod="${product.referencia}">
            <div class="product_img">
                <div class="product_discount_porcentaje">15%</div>
                <img src="data:${product.tipo};base64,${product.img}" alt="${product.nombre}">
            </div>
            <div class="product_content">
                <p class="product_brand">${product.marca}</p>
                <h3 class="product_title">${product.nombre}</h3>
                <div class="product_price"><span class="price">${precio_iva} €</div>
            </div>
            <div class="btn_box">
                <button class="btn_product_details"><a href="http://localhost/urban/producto.php?ref=${product.referencia}">Ver detalles</a></button>
            </div>
        </div>`;
}

colores.forEach( color =>  {
    color.addEventListener('click', (e) => {
        const element = e.target;
        const color_id = element.getAttribute('data-color-id');

        if(element.hasAttribute('data-selected')) {
            const idx = colors_to_filter.findIndex( i => color_id === i);
            colors_to_filter.splice(idx, 1);
            element.removeAttribute('data-selected');
        } else {
            element.setAttribute('data-selected', true);
            colors_to_filter.push(color_id);
        }

    });
});

tallas.forEach( talla =>  {
    talla.addEventListener('click', (e) => {
        const element = e.target;
        const talla_id = element.getAttribute('data-talla-id');

        if(element.hasAttribute('data-selected')) {
            const idx = tallas_to_filter.findIndex( i => talla_id === i);
            tallas_to_filter.splice(idx, 1);
            element.removeAttribute('data-selected');
        } else {
            element.setAttribute('data-selected', true);
            tallas_to_filter.push(talla_id);
        }

    });
});

function updateQueryToFilters() {
    let query = original_query;
    let colores = '';
    let tallas = '';

    //si hay colores seccionados, los meto dentro del query a enviar al controlador
    if(colors_to_filter.length > 0) {
        colors_to_filter.forEach( (color, idx) => {
            (idx < colors_to_filter.length - 1) ? colores += `${color},` : colores += color;
        });
        colores = '&colores=' + colores;
        query = query + colores;
    }

    //si hay tallas seccionados, los meto dentro del query a enviar al controlador
    if(tallas_to_filter.length > 0) {
        tallas_to_filter.forEach( (talla, idx) => {
            (idx < tallas_to_filter.length - 1) ? tallas += `${talla},` : tallas += talla;
        });
        tallas = '&tallas=' + tallas;
        query = query + tallas;
    }

    console.log(query);

    return query;
}