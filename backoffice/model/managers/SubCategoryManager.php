<?php

require_once __DIR__ . '/../connection/Db.php';

class SubCategoryManager extends Db
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

    function getSubcategories($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10)
    {
        $sql = "SELECT sc.id, sc.nombre, sc.estado, c.nombre as 'nombre_cat'
        FROM subcategorias sc, categorias c 
        WHERE sc.id_categoria = c.id 
        ORDER BY $order $sort limit $inicio,$registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalProductos = $this->getAllProductsFromSubcategory($fila['id']);

            $data[$i] = $fila;
            $data[$i]['totalProductos'] = $totalProductos;
        }

        return $data;
    }

    function getAllProductsFromSubcategory($id)
    {
        $sql = "SELECT count(referencia) AS total
            FROM productos p, subcategorias sc
            WHERE sc.id = p.subcategoria
            AND sc.id = $id";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();
        return $data['total'];
    }

    function getSubcategoryById($id) {
        $sql = "SELECT id, nombre, descripcion, estado, id_categoria FROM subcategorias WHERE id = $id";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();
        return $data;
    }

    function insert($nombre, $estado, $desc, $id_categoria)
    {
        $sql = "INSERT INTO subcategorias (nombre, descripcion, estado, id_categoria) VALUES ('$nombre', '$desc', $estado, $id_categoria)";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function update($nombre, $estado, $desc, $categoria, $id)
    {
        $sql = "UPDATE subcategorias SET nombre = '$nombre', descripcion = '$desc', estado = $estado, id_categoria = $categoria WHERE id = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function delete($id)
    {
        if($this -> changeProductsCategory($id) === TRUE) {
            $sql = "DELETE FROM subcategorias WHERE id = $id";
        
            if ($this->getConnection()->query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this->getConnection()->error;
            } 
        } else {
            return $this -> getErrorSql();
        }
    }

    //Al borrarse una subcategoria, las subcategorias de los productos se cambian a Sin Categoria
    function changeProductsCategory($id) {
        $sql = "UPDATE productos SET subcategoria = 0 WHERE subcategoria = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function inactiveAllProducts($id) {
        $sql = "UPDATE productos SET estado = 0 WHERE subcategoria = $id";

        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this->getConnection()->error;
        }
    }

    function getSubCategoryLength() {
        $sql = "SELECT COUNT(id) as total FROM subcategorias";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return intval($data['total']);
    }

    function getSubcategoriesSearched($order = 'id', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 10, $search)
    {
        $sql = "SELECT sc.id, sc.nombre, sc.estado, c.nombre as 'nombre_cat'
        FROM subcategorias sc, categorias c 
        WHERE sc.id_categoria = c.id AND sc.nombre LIKE '%".$search."%' ORDER BY $order $sort limit $inicio, $registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalProductos = $this->getAllProductsFromSubcategory($fila['id']);

            $data[$i] = $fila;
            $data[$i]['totalProductos'] = $totalProductos;
        }

        return $data;
    }

    //Retorna la cantidad de marcas que coinciden con la busqueda
    public function getSubategorySearchedLength($busqueda) {
        $sql = "SELECT COUNT(id) as total FROM subcategorias WHERE nombre like '%".$busqueda."%'";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return intval($data['total']);
    }

}

?>
