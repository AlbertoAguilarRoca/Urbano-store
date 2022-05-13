<?php

require_once __DIR__ . '/../connection/Db.php';

class GenericManager extends Db {

    private $error_sql = "";

    function __construct()
    {
        parent::__construct();
    }

    public function setErrorSql($sqlError)
    {
        $this->error_sql = $sqlError;
    }

    public function getErrorSql()
    {
        return $this->error_sql;
    }

    public function getCategories() {
        $sql = "SELECT id, nombre FROM categorias";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }

    public function getSubcategories() {
        $sql = "SELECT id, nombre FROM subcategorias";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }

    public function getColors() {
        $sql = "SELECT id, nombre, codigo_hex FROM colores";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }

    public function getGenders() {
        $sql = "SELECT id, nombre FROM genero";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }

    public function getBrands() {
        $sql = "SELECT id, nombre FROM marcas";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }

    public function getSizes() {
        $sql = "SELECT id, talla FROM tallas";

        $resultado = $this -> getConnection() -> query($sql);
        return $resultado;
    }


}



?>