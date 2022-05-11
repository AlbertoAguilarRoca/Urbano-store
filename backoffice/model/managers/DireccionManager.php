<?php

require_once __DIR__ .'/../connection/Db.php';


    class DireccionManager extends Db {

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

        public function getAllDirecciones($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100) {
            $sql = "SELECT d.id, c.email, d.codigo_postal, d.direccion, d.provincia, d.es_empresa
            FROM cliente c
            INNER JOIN direccion d
            ON c.id_cliente = d.id_cliente 
            ORDER BY $order $sort LIMIT $inicio, $registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        public function getAllDireccionesSearched($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100, $search) {
            $sql = "SELECT d.id, c.email, d.codigo_postal, d.direccion, d.provincia, d.es_empresa
            FROM cliente c
            INNER JOIN direccion d
            ON c.id_cliente = d.id_cliente
            WHERE c.email LIKE '%".$search."%' OR d.id_cliente LIKE '%".$search."%' OR d.provincia LIKE '%".$search."%' ORDER BY $order $sort LIMIT $inicio, $registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        public function getDireccionById($id) {
            $sql = "SELECT c.email, d.es_empresa, d.nif, d.razon_social, d.direccion, d.direccion2,
            d.codigo_postal, d.provincia, d.localidad, d.telefono
           FROM cliente c
           INNER JOIN direccion d
           ON c.id_cliente = d.id_cliente
           WHERE d.id = $id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        function getAllDireccionesLength() {
            $sql = "SELECT count(id) as total FROM direccion";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        public function getAllDireccionesSearchedLength($search) {
            $sql = "SELECT count(d.id) as total 
            FROM cliente c
            INNER JOIN direccion d
            ON c.id_cliente = d.id_cliente
            WHERE c.email LIKE '%".$search."%' OR d.id_cliente LIKE '%".$search."%' OR d.provincia LIKE '%".$search."%'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        public function insert($id_cliente, $nif, $razon_social, $es_empresa, $direccion, $direccion2, $codigo_postal, $provincia, $localidad, $telefono) {
            $sql = "INSERT INTO direccion(id_cliente, nif, razon_social, es_empresa, direccion, direccion2, codigo_postal, provincia, localidad, telefono) 
            VALUES ('$id_cliente', '$nif', '$razon_social', $es_empresa, '$direccion', '$direccion2', $codigo_postal, '$provincia', '$localidad', '$telefono')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function update($id_cliente ,$nif, $razon_social, $es_empresa, $direccion, $direccion2, $codigo_postal, $provincia, $localidad, $telefono, $id) {
            $sql = "UPDATE direccion SET id_cliente = '$id_cliente', nif = '$nif', razon_social = '$razon_social', es_empresa = $es_empresa, direccion = '$direccion', direccion2 = '$direccion2', codigo_postal = $codigo_postal, provincia = '$provincia', localidad = '$localidad', telefono = '$telefono' WHERE id = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function delete($id) {
            $sql = "DELETE FROM direccion WHERE id = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function getIdbyEmail($email) {
            $sql = "SELECT id_cliente FROM cliente WHERE email = '$email'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            if(is_null($data)) {
                return null;
            } else {
                return $data['id_cliente'];
            }
        }


    }


?>