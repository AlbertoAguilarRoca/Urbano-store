<?php

require_once __DIR__ . '/../connection/Db.php';

class CategoryManager extends Db
{

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

    function getCategories($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10)
    {
        $sql = "SELECT id, nombre, estado, descripcion FROM categorias ORDER BY $order $sort limit $inicio,$registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalProductos = $this->getAllProductsFromCategory($fila['id']);

            $data[$i] = $fila;
            $data[$i]['totalProductos'] = $totalProductos;
        }

        return $data;
    }

    function getAllCategoryIdAndName() {
        $sql = "SELECT id, nombre, estado FROM categorias";

        $resultado = $this->getConnection()->query($sql);
        return $resultado;
    }

    function getCategoryById($id) {
        $sql = "SELECT nombre, descripcion, estado FROM categorias WHERE id = $id";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();
        return $data;
    }

    function getAllProductsFromCategory($id)
    {
        $sql = "SELECT count(referencia) AS total
            FROM productos p, subcategorias sc, categorias c
            WHERE c.id = sc.id_categoria AND sc.id = p.subcategoria
            AND c.id = $id";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();
        return $data['total'];
    }

    function insert($nombre, $estado, $desc)
    {
        $sql = "INSERT INTO categorias (nombre, descripcion, estado) VALUES ('$nombre', '$desc', $estado)";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function update($nombre, $estado, $desc, $id)
    {
        $sql = "UPDATE categorias SET nombre = '$nombre', descripcion = '$desc', estado = $estado WHERE id = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function delete($id)
    {
        if($this -> changeSubcategories($id) === TRUE) {
            $sql = "DELETE FROM categorias WHERE id = $id";
        
            if ($this->getConnection()->query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this->getConnection()->error;
            }
        } else {
            return $this -> getErrorSql();
        }
    }

    function checkCategoryStatus($id) {
        $sql = "SELECT estado FROM categorias WHERE id = $id";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado -> fetch_assoc();
        return intval($data['estado']);
    }

    //Al borrarse una categoria, las subcategorias se cambian a Sin Categoria
    function changeSubcategories($id) {
        $sql = "UPDATE subcategorias SET id_categoria = 0 WHERE id_categoria = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function inactiveAllSubcategories($id) {
        $sql = "UPDATE subcategorias SET estado = 0 WHERE id_categoria = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    //Deshabilita todos los productos que tienen su subcategoria inhabilitada
    function inactiveAllProductsFromSybcategories() {
        $sql = "UPDATE productos p, subcategorias sc SET p.estado = 0 
        WHERE p.subcategoria = sc.id
        AND sc.estado = 0";
        
        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function getCategoryLength() {
        $sql = "SELECT COUNT(id) as total FROM categorias";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return intval($data['total']);
    }

    function getCategoriesSearched($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10, $search)
    {
        $sql = "SELECT id, nombre, estado, descripcion FROM categorias WHERE nombre LIKE '%".$search."%' ORDER BY $order $sort limit $inicio, $registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalProductos = $this->getAllProductsFromCategory($fila['id']);

            $data[$i] = $fila;
            $data[$i]['totalProductos'] = $totalProductos;
        }

        return $data;
    }

    //Retorna la cantidad de marcas que coinciden con la busqueda
    public function getCategorySearchedLength($busqueda) {
        $sql = "SELECT COUNT(id) as total FROM categorias WHERE nombre like '%".$busqueda."%'";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return intval($data['total']);
    }

}
