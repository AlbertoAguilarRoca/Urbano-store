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

    }

?>