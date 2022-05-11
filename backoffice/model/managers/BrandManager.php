<?php 
    
    require_once __DIR__ .'/../connection/Db.php';

    class BrandManager extends Db {

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

        function insert($nombre, $estado, $desc = '', $contacto = '') {
            $sql = "INSERT INTO marcas (nombre, descripcion, contacto, estado) VALUES ('$nombre', '$desc', '$contacto', $estado)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function update($id, $nombre, $estado, $desc = '', $contacto = '') {
            $sql = "UPDATE marcas SET nombre = '$nombre', descripcion = '$desc', contacto = '$contacto', estado = $estado WHERE id = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete($id) {
            if($this -> changeProductsBrand($id) === TRUE) {

                $sql = "DELETE FROM marcas WHERE id = $id";

                if ($this -> getConnection() -> query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error SQL: " . $this -> getConnection() -> error;
                }
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        //Al borrar una marca, cambia los productos asociados a esa marca a una marca generica 'Sin marca'
        function changeProductsBrand($id) {
            $sql = "UPDATE productos SET marca = 0 WHERE marca = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function getBrandById($id) {
            $sql = "SELECT id, nombre, descripcion, contacto, estado FROM marcas WHERE id = $id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        function getBrands($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10) {
            $sql = "SELECT id, nombre, contacto, estado FROM marcas ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            $data = [];

            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $fila = $resultado -> fetch_assoc();

                $totalProductos = $this -> getAllProductsFromBrand($fila['id']);

                $data[$i] = $fila;
                $data[$i]['totalProductos'] = $totalProductos;
            }

            return $data;
        }

        function getSearchedBrands($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10, $busqueda) {
            $sql = "SELECT id, nombre, contacto, estado FROM marcas WHERE nombre like '%".$busqueda."%' OR contacto like '%".$busqueda."%' OR estado like '%".$busqueda."%' ORDER BY $order $sort limit $inicio,$registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            $data = [];

            for($i = 0; $i < $resultado -> num_rows; $i++) {
                $fila = $resultado -> fetch_assoc();

                $totalProductos = $this -> getAllProductsFromBrand($fila['id']);

                $data[$i] = $fila;
                $data[$i]['totalProductos'] = $totalProductos;
            }

            return $data;
        }

        //Retorna la cantidad de productos que hay de una marca
        private function getAllProductsFromBrand($brandId) {
            $sql = "SELECT COUNT(referencia) as total FROM productos WHERE marca = $brandId";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        //Retorna todos los registros de las marcas
        public function getAllBrandRecords() {
            $sql = "SELECT COUNT(id) as total FROM marcas";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return intval($data['total']);
        }

        //Retorna la cantidad de marcas que coinciden con la busqueda
        public function getAllBrandRecordsSearched($busqueda) {
            $sql = "SELECT COUNT(id) as total FROM marcas WHERE nombre like '%".$busqueda."%' OR contacto like '%".$busqueda."%' OR estado like '%".$busqueda."%'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return intval($data['total']);
        }

    }
