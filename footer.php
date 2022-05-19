



<script>
    //si el carrito tiene productos, modifico el numero
    let prod_carrito = [];
    const sesion_productos = sessionStorage.getItem('carrito');
    productos_carrito = JSON.parse(sesion_productos);

    const cesta = document.getElementById('total_productos_cesta');
    if(sesion_productos && productos_carrito.length > 0) {
        cesta.innerText = productos_carrito.length;
        cesta.classList.remove('no_products');
    } else {
        cesta.classList.add('no_products');
    }

</script>

<script src="http://localhost/urban/js/header.js"></script>
</body>
</html>