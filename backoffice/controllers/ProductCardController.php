<?php

require_once __DIR__ .'/../model/managers/ProductManager.php';
require_once __DIR__ .'/../model/managers/SizeManager.php';
include_once __DIR__.'/../helpers/validateData.php';
include_once __DIR__.'/../helpers/Referencia.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$productManager = new ProductManager();
$sizeManager = new SizeManager();

//inicializacion de variables de productos
$ref = '';

/*INFO QUE NECESITO
// * referencia
//* info: nombre, marca, precio, iva, resumen, carac.
//* imagenes: [ {img, tipo, nombre} ]
//* prod_rel: [ {ref, img(1), tipo, nombre}]
//* tallas: [ {talla_id, talla} ]
//* tallas_stock: [ {tallas} ]
*descuento: {false || true, {info de descuento}}

*/


$producto = [];


if($requestMethod == 'GET') {

    if(isset($_GET['ref'])) {
        $ref = validateData($_GET['ref']);
        $producto['referencia'] = $ref;
    } else {
        echo json_encode('Producto no encontrado');
        exit;
    }

    $producto['info'] = $productManager -> infoProduc($ref);
    $producto['imagenes'] = $productManager -> getImgByIdFilter($ref);
    $producto['prod_rel'] = $productManager -> getRelProdById($ref);
    $producto['tallas_stock'] = $productManager -> getSizeProductByRef($ref);
    $producto['descuento'] = false;

    //compruebo la categoria y muestros las tallas correspondientes
    $min = $max = 0;
    $catId = $productManager -> getCategoryFromSc($producto['info']['subcategoria']);

    if($catId == '1') {
        $min = 8;
        $max = 19;
    } else if($catId == '2') {
        $min = 2;
        $max = 7;
    } else if($catId == '3') {
        $min = 1;
        $max = 7;
    }

    $producto['tallas'] = $sizeManager -> getAllSizesToFront($min, $max);



    echo json_encode($producto);

}



?>