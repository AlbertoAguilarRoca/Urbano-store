<?php

require_once __DIR__ .'/../connection/Db.php';

    class ProductManager extends Db {

        private $error_sql = "";

        function __construct()
        {
            parent::__construct();
        }

        public function setErrorSql($sqlError) {
            $this -> error_sql = $sqlError;
        }

        public function getErrorSql() {
            return $this -> error_sql;
        }

        function getProductFrontSub($consulta) {

            $resultado = $this -> getConnection() -> query($consulta);

            $data = [];
            $data_filter = [];
            $contador = 0;

            for($i = 0; $i < $resultado -> num_rows; $i++) {

                $data[$i] = $resultado -> fetch_assoc();
                //compruebo si tiene stock
                $stock_producto = $this -> checkProductStock($data[$i]['referencia']);

                //si tiene stock, lo meto
                if(intval($stock_producto) > 0) {

                    $data_filter[$contador] = $data[$i];
                    $imgProduc = $this -> getOneProductImgById($data_filter[$contador]['referencia']);
                    $data_filter[$contador]['img'] = base64_encode($imgProduc['img']);
                    $data_filter[$contador]['tipo'] = $imgProduc['tipo'];
                    $data_filter[$contador]['img_nombre'] = $imgProduc['nombre'];
                    $contador++;
                }
            }

            return $data_filter;
        }

        function getSubcategoryName($sub) {
            $sql = "SELECT nombre from subcategorias WHERE id = $sub";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['nombre'];
        }

        function countStockProduct($consulta) {
            $resultado = $this -> getConnection() -> query($consulta);
            $contador = 0;

            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $fila = $resultado -> fetch_assoc();
                //compruebo si tiene stock
                $stock_producto = $this -> checkProductStock($fila['referencia']);
                //si tiene stock, lo meto
                if(intval($stock_producto) > 0) {
                    $contador++;
                }
            }

            return $contador;

        }

        function checkProductStock($ref) {
            $sql = "SELECT sum(cantidad) as total FROM tallasproductos WHERE ref_producto = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        function getOneProductImgById($ref) {
            $sql = "SELECT img, tipo, nombre FROM imagenesproductos WHERE referencia = '$ref' LIMIT 1";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        function getProducts($order = 'estado', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100) {
            $sql = "SELECT p.referencia, p.nombre, m.nombre as marca , sc.nombre as subcategoria, p.precio, p.iva,
            round(p.precio * (1 + iva), 2) as 'precio_con_iva', 
            p.fecha_creacion, g.nombre as genero, p.estado
            FROM productos p, subcategorias sc, marcas m, genero g
            WHERE sc.id = p.subcategoria AND m.id = p.marca AND 
            g.id = p.genero ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            
            $data = [];
            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $data[$i] = $resultado -> fetch_assoc();

                $stock_total = $this -> getAllStock($data[$i]['referencia']);
                $data[$i]['stock_total'] = $stock_total;

            }

            return $data;
        }

        function getProductById($ref) {
            $sql = "SELECT nombre, marca, genero, fecha_creacion, estado, color, precio, iva, resumen, caracteristicas, subcategoria FROM productos WHERE referencia = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        function getTallasById($ref) {
            $sql = "SELECT t.talla as talla, tp.id_talla as 'id_talla', tp.cantidad as cantidad, 
            tp.stock_minimo as 'stock_minimo' 
            FROM productos p, tallasproductos tp, tallas t
            WHERE p.referencia = tp.ref_producto AND tp.id_talla = t.id 
            AND p.referencia = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        function getImgById($ref) {
            $sql = "SELECT nombre, tipo, img FROM imagenesproductos 
            WHERE referencia = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        function getProdRefById($ref) {
            $sql = "SELECT ref_producto_rel FROM productosrelacionados WHERE ref_producto = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        function getProductsSearched($order = 'estado', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100, $search) {
            $sql = "SELECT p.referencia, p.nombre, m.nombre as marca , sc.nombre as subcategoria, p.precio, p.iva,
            round(p.precio * (1 + iva), 2) as 'precio_con_iva', 
            p.fecha_creacion, g.nombre as genero, p.estado
            FROM productos p, subcategorias sc, marcas m, genero g
            WHERE sc.id = p.subcategoria AND m.id = p.marca AND 
            g.id = p.genero AND p.referencia LIKE '%".$search."%' ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            
            $data = [];
            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $data[$i] = $resultado -> fetch_assoc();

                $stock_total = $this -> getAllStock($data[$i]['referencia']);
                $data[$i]['stock_total'] = $stock_total;

            }

            return $data;
        }

        //funcion que retorna el stock de un producto buscado
        function getStock($order = 'tp.cantidad', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100) {
            $sql = "SELECT tp.ref_producto, p.nombre, m.nombre as marca , sc.nombre as subcategoria, tp.cantidad, tp.stock_minimo FROM tallasproductos tp, productos p, subcategorias sc, marcas m
            WHERE tp.ref_producto = p.referencia AND sc.id = p.subcategoria AND m.id = p.marca 
            AND p.estado = 1 AND tp.cantidad > 0 ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            
            $data = [];
            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $data[$i] = $resultado -> fetch_assoc();
            }

            return $data;
        }

        //funcion que retorna el stock de un producto buscado
        function getStockSearched($order = 'tp.cantidad', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100, $search) {
            $sql = "SELECT tp.ref_producto, p.nombre, m.nombre as marca , sc.nombre as subcategoria, tp.cantidad, tp.stock_minimo FROM tallasproductos tp, productos p, subcategorias sc, marcas m
            WHERE tp.ref_producto = p.referencia AND sc.id = p.subcategoria AND m.id = p.marca 
            AND p.estado = 1 AND tp.cantidad > 0 AND p.referencia LIKE '%".$search."%' ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            
            $data = [];
            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $data[$i] = $resultado -> fetch_assoc();
            }

            return $data;
        }

        function getStockLength() {
            $sql = "SELECT count(tp.ref_producto) as total FROM tallasproductos tp, productos p
            WHERE tp.ref_producto = p.referencia AND tp.cantidad > 0";

            $resultado = $this -> getConnection() -> query($sql);
            
            $data = $resultado -> fetch_assoc();

            return $data['total'];
        }

        //funcion que retorna el stock de un producto buscado
        function getStockSearchedLength($search) {
            $sql = "SELECT  count(tp.ref_producto) as total FROM tallasproductos tp, productos p
            WHERE tp.ref_producto = p.referencia AND tp.cantidad > 0 AND p.referencia LIKE '%".$search."%'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['total'];
        }

        function getProductsSearchedLength($search) {
            $sql = "SELECT count(referencia) as total
            FROM productos p, subcategorias sc, marcas m, genero g
            WHERE sc.id = p.subcategoria AND m.id = p.marca AND 
            g.id = p.genero AND p.referencia LIKE '%".$search."%'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        function getProductsLength() {
            $sql = "SELECT count(referencia) as total FROM productos";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];

        }

        function insert($ref, $nombre, $resumen, $estado, $caracteristicas, $marca, $color, $subcategoria, $precio, $iva, $fecha_creacion, $genero) {
            $sql = "INSERT INTO productos (referencia, nombre, resumen, estado, caracteristicas, marca, color, subcategoria, precio, iva, fecha_creacion, genero) VALUES ('$ref', '$nombre', '$resumen', $estado, '$caracteristicas', $marca, $color, $subcategoria, $precio, $iva, '$fecha_creacion', $genero)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function insert_prod_rel($ref, $ref_prod_rel) {
            //COmpruebo si el producto relacionado existe
            if($this -> checkIfRefProductExist($ref_prod_rel) == '1') {
                $sql = "INSERT INTO productosrelacionados (ref_producto, ref_producto_rel) VALUES('$ref', '$ref_prod_rel')";

                if ($this -> getConnection() -> query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error SQL: " . $this -> getConnection() -> error;
                }
            }
        }

        function insert_stock_tallas($ref, $talla_id, $stock, $stock_min) {
            $sql = "INSERT INTO tallasproductos (ref_producto, id_talla, cantidad, stock_minimo) VALUES('$ref', $talla_id, $stock, $stock_min)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function insert_img_prod($nombre, $img, $tipo, $ref) {
            $sql = "INSERT INTO imagenesproductos (nombre, img, tipo, referencia) VALUES('$nombre', '$img', '$tipo', '$ref')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function update($ref, $nombre, $resumen, $estado, $caracteristicas, $marca, $color, $subcategoria, $precio, $iva, $fecha_creacion, $genero) {
            $sql = "UPDATE productos SET nombre = '$nombre', resumen = '$resumen', estado = $estado, caracteristicas = '$caracteristicas', 
            marca = $marca, color = $color, subcategoria = $subcategoria, precio = $precio, iva = $iva, fecha_creacion = '$fecha_creacion', genero = $genero 
            WHERE referencia = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function getAllStock($ref) {
            $sql = "SELECT sum(cantidad) as stock from tallasproductos where ref_producto = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['stock'];
        }

        function checkIfRefProductExist($ref) {
            $sql = "SELECT count(referencia) as total FROM productos WHERE referencia = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        function checkBrandStatus($id) {
            $sql = "SELECT estado FROM marcas WHERE id = $id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['estado'];
        }

        function checkSubcategoryStatus($id) {
            $sql = "SELECT estado FROM subcategorias WHERE id = $id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['estado'];
        }

        function delete($ref) {
            $sql = "DELETE FROM productos WHERE referencia = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_ref_prod($ref) {
            $sql = "DELETE FROM productosrelacionados WHERE ref_producto = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_tallas_prod($ref) {
            $sql = "DELETE FROM tallasproductos WHERE ref_producto = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_img_prod($ref) {
            $sql = "DELETE FROM imagenesproductos WHERE referencia = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_wish_list($ref) {
            $sql = "DELETE FROM listadeseos WHERE ref_producto = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_prod_pedidos($ref) {
            $sql = "DELETE FROM productospedidos WHERE ref_producto = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete_prod_review($ref) {
            $sql = "DELETE FROM producto_review WHERE producto = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

    }

?>