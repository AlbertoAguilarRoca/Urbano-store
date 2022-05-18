<?php

require_once __DIR__ .'/../connection/Db.php';

    class SizeManager extends Db {

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

        public function getAllSizes() {
            $sql = "SELECT id, talla FROM tallas";

            $resultado = $this -> getConnection() -> query($sql);

            return $resultado;
        }

        public function getAllSizesToFront($min, $max) {
            $sql = "SELECT id, talla FROM tallas WHERE id >= $min AND id <= $max";

            $resultado = $this -> getConnection() -> query($sql);
            $data= [];
            for ($i=0; $i < $resultado -> num_rows; $i++) { 
                $data[$i] = $resultado -> fetch_assoc();
            }
            return $data;
        }

        public function getSizeById($id) {
            $sql = "SELECT id, talla FROM tallas WHERE id=$id";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        public function getSizeLength() {
            $sql = "SELECT count(id) as total FROM tallas";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }
    
        public function insert($talla) {
            $sql = "INSERT INTO tallas(talla) VALUES('$talla')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function update($id, $talla) {

            $sql = "UPDATE tallas SET talla='$talla' WHERE id=$id";


            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function delete($id) {
            if($this -> setSizeToGeneric($id)) {
                $sql = "DELETE FROM tallas WHERE id=$id";

                if ($this -> getConnection() -> query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error SQL: " . $this -> getConnection() -> error;
                }
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function setSizeToGeneric($id) {
            $sql = "UPDATE tallasproductos SET id_talla = 0 WHERE id_talla = $id";
            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

    
    
    }


?>