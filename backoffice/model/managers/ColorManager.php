<?php

require_once __DIR__ .'/../connection/Db.php';

    class ColorManager extends Db {

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

        public function getAllColors() {
            $sql = "SELECT id, codigo_hex, nombre FROM colores";

            $resultado = $this -> getConnection() -> query($sql);

            return $resultado;
        }

        public function getColorById($cod) {
            $sql = "SELECT id, codigo_hex, nombre FROM colores WHERE id=$cod";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        public function getColorsLength() {
            $sql = "SELECT count(codigo_hex) as total FROM colores";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }
    
        public function insert($codigo, $nombre) {
            $sql = "INSERT INTO colores(codigo_hex, nombre) VALUES('$codigo', '$nombre')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function update($codigo, $id, $nombre) {

            $sql = "UPDATE colores SET codigo_hex='$codigo', nombre='$nombre' WHERE id=$id";


            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        public function delete($id) {
            if($this -> setColorToNull($id)) {
                $sql = "DELETE FROM colores WHERE id=$id";

                if ($this -> getConnection() -> query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error SQL: " . $this -> getConnection() -> error;
                }
            }
        }

        public function setColorToNull($id) {
            $sql = "UPDATE productos SET color = null WHERE color = $id";
            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }
    
    
    }


?>