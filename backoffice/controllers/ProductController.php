<?php

require_once __DIR__.'/../security/controlAccess.php';
require_once __DIR__ .'/../model/managers/ProductManager.php';
include_once __DIR__.'/../helpers/validateData.php';
include_once __DIR__.'/../helpers/Referencia.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$productManager = new ProductManager();

//inicializacion de variables de productos
$ref = $nombre = $resumen = $estado = $caracteristicas = $marca = $color = $subcategoria = $precio = $iva = $fecha_creacion = $genero = '';

$prod_rel = [];
$stock_tallas = [];

if($requestMethod == 'POST') {

    if(isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if(isset($_POST['resumen'])) {
        $resumen = validateData($_POST['resumen']);
    }

    if(isset($_POST['caracteristicas'])) {
        $caracteristicas = validateData($_POST['caracteristicas']);
    }

    if(isset($_POST['marca'])) {
        $marca = validateData($_POST['marca']);
    }

    if(isset($_POST['subcategoria'])) {
        $subcategoria = validateData($_POST['subcategoria']);
    }

    if(isset($_POST['estado']) && $_POST['estado'] == 'yes') {
        //para que un producto este activo, debe tener asociada una marca y subcategoria activa
        if($productManager -> checkBrandStatus($marca) == '1' && 
        $productManager -> checkSubcategoryStatus($subcategoria) == '1') {
            $estado = 1;
        } else {
            $estado = 0;
        }
    } else {
        $estado = 0;
    }

    if(isset($_POST['color'])) {
        $color = validateData($_POST['color']);
    } else {
        $color = null;
    }

    if(isset($_POST['precio'])) {

        $precio = validateData($_POST['precio']);
        if(preg_match('/^\d+(\.\d{1,2})?$/', $precio) == 0) {
            echo json_encode('Error: el precio contiene errores de formato. Solo será permitido el punto como separador y dos decimales.');
            exit;
        }

        $precio = doubleval($precio);
    }

    if(isset($_POST['iva'])) {
        
        $iva = validateData($_POST['iva']);
        if(preg_match('/^(0\.\d{1,2}|1(\.0{1,2})?)$/', $iva) == 0) {
            echo json_encode('Error: el IVA contiene errores de formato. solo podrás incluir dos decimales como máximo.');
            exit;
        }

        $iva = doubleval($iva);
    }

    if(isset($_POST['fecha_creacion'])) {
        $fecha_creacion = validateData($_POST['fecha_creacion']);
    }

    if(isset($_POST['genero'])) {
        $genero = validateData($_POST['genero']);
    }

    //Productos relacionados
    if(isset($_POST['prod_rel'])) {
        $prod_rel = json_decode($_POST['prod_rel'], true);
    }

    //stock de tallas
    if(isset($_POST['stock_tallas'])) {
        $stock_tallas = json_decode($_POST['stock_tallas'], true);
    }


    if(isset($_POST['_method']) && $_POST['_method'] == 'put') {

        $ref = $_GET['ref'];
        
        $resp = $productManager -> update($ref, $nombre, $resumen, $estado, $caracteristicas, $marca, $color, $subcategoria, $precio, $iva, $fecha_creacion, $genero);

        if($resp == TRUE) {
            //BORRAMOS TODOS LOS DATOS, Y VOLVEMOS A SUBIR LOS ACTUALIZADOS
            $productManager -> delete_ref_prod($ref);
            $productManager -> delete_tallas_prod($ref);

            //INSERT PROD REL
            for ($i=0; $i < count($prod_rel); $i++) { 
                $resp = $productManager -> insert_prod_rel($ref, $prod_rel[$i]['id']);
            }

            //INSERT TALLAS PRODUCTOS
            for ($i=0; $i < count($stock_tallas); $i++) { 
                $resp = $productManager -> insert_stock_tallas($ref, $stock_tallas[$i]['talla_id'], $stock_tallas[$i]['stock'], $stock_tallas[$i]['stock_min']);
            }

            //SI NO HAY ARCHIVOS, NO HAGO NADA
            if( !empty( $_FILES ) && $_FILES['imagenes_producto']['name'][0] != '') {
                
                $productManager -> delete_img_prod($ref);

                for ($i=0; $i < count($_FILES['imagenes_producto']['name']); $i++) { 
                    //compruebo si el tipo de imagen es de los permitidos
                    if($_FILES['imagenes_producto']['type'][$i] == 'image/jpeg' || 
                    $_FILES['imagenes_producto']['type'][$i] == 'image/png' ||
                    $_FILES['imagenes_producto']['type'][$i] == 'image/jpg') {

                        $typeFile = $_FILES['imagenes_producto']['type'][$i];
                        $nameFile = $_FILES['imagenes_producto']['name'][$i];
                        $sizeFile = $_FILES['imagenes_producto']['size'][$i];
                        //Aqui se almacena temporalmente los archivos subidos del servidor
                        $imageUpload = fopen($_FILES['imagenes_producto']['tmp_name'][$i], 'r');
                        $binaryImage = fread($imageUpload, $sizeFile);
                        //Limpiamos los binarios para proceder con la subida
                        $binaryImage = mysqli_escape_string($productManager->getConnection(), $binaryImage);

                        $resp = $productManager -> insert_img_prod($nameFile, $binaryImage, $typeFile, $ref);
                    }
                }
            }

            echo json_encode($resp);

        }

    } else {

        //creamos el id de la regla comercial
        $id = new Referencia(15);
        $ref = $id -> getRef();

        $checkId = intval($productManager -> checkIfRefProductExist($ref));

        //comprueba si ese id ya existe
        while ($checkId != 0) {
            $newId = new Referencia(15);
            $ref = $newId -> getRef();
            $checkId = intval($productManager -> checkIfRefProductExist($ref));
        }

        //INSERT
        $resp = $productManager -> insert($ref, $nombre, $resumen, $estado, $caracteristicas, $marca, $color, $subcategoria, $precio, $iva, $fecha_creacion, $genero);

        if($resp != TRUE) {
            //error al subir productos
            echo json_encode($resp);
            exit;
        }

        //INSERT PROD REL
        for ($i=0; $i < count($prod_rel); $i++) { 
            $resp = $productManager -> insert_prod_rel($ref, $prod_rel[$i]['id']);
        }

        //INSERT TALLAS PRODUCTOS
        for ($i=0; $i < count($stock_tallas); $i++) { 
            $resp = $productManager -> insert_stock_tallas($ref, $stock_tallas[$i]['talla_id'], $stock_tallas[$i]['stock'], $stock_tallas[$i]['stock_min']);
        }

        //INSERT IMAGENES PRODUCTOS
        if( !empty( $_FILES )) { 
            for ($i=0; $i < count($_FILES['imagenes_producto']['name']); $i++) { 
                //compruebo si el tipo de imagen es de los permitidos
                if($_FILES['imagenes_producto']['type'][$i] == 'image/jpeg' || 
                $_FILES['imagenes_producto']['type'][$i] == 'image/png' ||
                $_FILES['imagenes_producto']['type'][$i] == 'image/jpg') {

                    $typeFile = $_FILES['imagenes_producto']['type'][$i];
                    $nameFile = $_FILES['imagenes_producto']['name'][$i];
                    $sizeFile = $_FILES['imagenes_producto']['size'][$i];
                    //Aqui se almacena temporalmente los archivos subidos del servidor
                    $imageUpload = fopen($_FILES['imagenes_producto']['tmp_name'][$i], 'r');
                    $binaryImage = fread($imageUpload, $sizeFile);
                    //Limpiamos los binarios para proceder con la subida
                    $binaryImage = mysqli_escape_string($productManager->getConnection(), $binaryImage);

                    $resp = $productManager -> insert_img_prod($nameFile, $binaryImage, $typeFile, $ref);
                }
            }
        }

        echo json_encode($resp);

    } 


} else if($requestMethod == 'DELETE') {
    $ref = $_GET['ref'];
    //BORRAMOS TALLAS
    $productManager -> delete_tallas_prod($ref);
    //BORRAMOS PRODUCTOS RELACIONADOS
    $productManager -> delete_ref_prod($ref);
    //borramos imagenes
    $productManager -> delete_img_prod($ref);
    //borramos productos de las listas de deseos de los clientes
    $productManager -> delete_wish_list($ref);
    //borramos productos de los pedidos
    $productManager -> delete_prod_pedidos($ref);
    $productManager -> delete_prod_review($ref);
    $resp = $productManager -> delete($ref);

    echo json_encode($resp);
}

?>