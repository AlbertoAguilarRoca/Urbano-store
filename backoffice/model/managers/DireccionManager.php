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

        public function insert($id_cliente, $nif, $razon_social, $es_empresa, $direccion, $direccion2, $codigo_postal, $provincia, $localidad, $telefono) {
            $sql = "INSERT INTO direccion(id_cliente, nif, razon_social, es_empresa, direccion, direccion2, codigo_postal, provincia, localidad, telefono) 
            VALUES ('$id_cliente', '$nif', '$razon_social', $es_empresa, '$direccion', '$direccion2', $codigo_postal, '$provincia', '$localidad', '$telefono')";

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