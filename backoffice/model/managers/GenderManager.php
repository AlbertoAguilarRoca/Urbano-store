<?php

require_once __DIR__ .'/../connection/Db.php';

    class GenderManager extends Db {

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

        public function getAllGenders() {
            $sql = "SELECT id, nombre FROM genero";

            $resultado = $this -> getConnection() -> query($sql);

            return $resultado;
        }

        public function getGenderById($id) {
            $sql = "SELECT id, nombre FROM genero WHERE id=$id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        public function getGenderLength() {
            $sql = "SELECT count(id) as total FROM genero";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }
    
        public function insert($nombre) {
            $sql = "INSERT INTO genero(nombre) VALUES('$nombre')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function update($id, $nombre) {

            $sql = "UPDATE genero SET nombre='$nombre' WHERE id=$id";


            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function delete($id) {
            if($this -> setGenderToGeneric($id)) {
                $sql = "DELETE FROM genero WHERE id=$id";

                if ($this -> getConnection() -> query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error SQL: " . $this -> getConnection() -> error;
                }
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function setGenderToGeneric($id) {
            $sql = "UPDATE productos SET genero = 0 WHERE genero = $id";
            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

    
    
    }


?>