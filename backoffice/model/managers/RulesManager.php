<?php

require_once __DIR__ . '/../connection/Db.php';

class RulesManager extends Db {

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

    function getRules($order = 'id_regla', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 50)
    {
        $sql = "SELECT id_regla, nombre, grupo, fecha_inicio, fecha_fin, tipo_reduccion, reduccion, tasas_incluidas 
        FROM reglascomerciales ORDER BY $order $sort limit $inicio,$registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalCondiciones = $this->countConditions($fila['id_regla']);

            $data[$i] = $fila;
            $data[$i]['totalConditions'] = $totalCondiciones;
        }

        return $data;
    }

    function getRuleById($id_regla) {
        $sql = "SELECT id_regla, nombre, grupo, fecha_inicio, fecha_fin, tipo_reduccion, reduccion, tasas_incluidas 
        FROM reglascomerciales WHERE id_regla = '$id_regla'";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();

        return $data;
    }

    function getRuleCondById($id_regla) {
        $sql = "SELECT tipo, valor_id, valor_nombre 
        FROM reglascomerciales_cond WHERE id_regla = '$id_regla'";

        $resultado = $this->getConnection()->query($sql);

        return $resultado;
    }

    function getRulesSearched($order = 'id_regla', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 50, $search)
    {
        $sql = "SELECT id_regla, nombre, grupo, fecha_inicio, fecha_fin, tipo_reduccion, reduccion, tasas_incluidas FROM reglascomerciales WHERE id_regla LIKE '%".$search."%' OR nombre LIKE '%".$search."%' OR fecha_inicio LIKE '%".$search."%' OR fecha_fin LIKE '%".$search."%'
        ORDER BY $order $sort limit $inicio,$registros_x_pagina";

        $resultado = $this->getConnection()->query($sql);
        $data = [];

        for ($i = 0; $i < $resultado->num_rows; $i++) {
            $fila = $resultado->fetch_assoc();

            $totalCondiciones = $this->countConditions($fila['id_regla']);

            $data[$i] = $fila;
            $data[$i]['totalConditions'] = $totalCondiciones;
        }

        return $data;
    }

    function getRulesLength() {
        $sql = "SELECT count(id_regla) as total FROM reglascomerciales";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();

        return $data['total'];
    }

    function getRulesSearchedLength($search) {
        $sql = "SELECT count(id_regla) as total FROM reglascomerciales WHERE id_regla LIKE '%".$search."%' OR nombre LIKE '%".$search."%' OR fecha_inicio LIKE '%".$search."%' OR fecha_fin LIKE '%".$search."%'";

        $resultado = $this->getConnection()->query($sql);
        $data = $resultado->fetch_assoc();

        return $data['total'];
    }

    public function insert_rule($id_regla, $nombre, $grupo, $fecha_inicio, $fecha_fin, $tipo_reduccion, $reduccion, $tasas_incluidas) {
        $sql = "INSERT INTO reglascomerciales (id_regla, nombre, grupo, fecha_inicio, fecha_fin, tipo_reduccion, reduccion, tasas_incluidas)
        VALUES ('$id_regla', '$nombre', '$grupo', '$fecha_inicio', '$fecha_fin', '$tipo_reduccion', '$reduccion', '$tasas_incluidas')";

        if ($this -> getConnection() -> query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this -> getConnection() -> error;
        }
    }

    public function insert_conditions($id_regla, $tipo, $valor_id, $valor_nombre) {
        $sql = "INSERT INTO reglascomerciales_cond (id_regla, tipo, valor_id, valor_nombre) 
        VALUES('$id_regla', '$tipo', '$valor_id', '$valor_nombre')";

        if ($this -> getConnection() -> query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this -> getConnection() -> error;
        }
    }

    public function update($id_regla, $nombre, $grupo, $fecha_inicio, $fecha_fin, $tipo_reduccion, $reduccion, $tasas_incluidas) {
        $sql = "UPDATE reglascomerciales SET nombre = '$nombre', grupo = '$grupo', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', tipo_reduccion = '$tipo_reduccion', reduccion = $reduccion, tasas_incluidas = '$tasas_incluidas' WHERE id_regla = '$id_regla'";

        if ($this -> getConnection() -> query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this -> getConnection() -> error;
        }
    }

    function delete($id_regla) {
        $sql = "DELETE FROM reglascomerciales WHERE id_regla = '$id_regla'";

        if ($this -> getConnection() -> query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this -> getConnection() -> error;
        }
    }

    function delete_cond($id_regla) {
        $sql = "DELETE FROM reglascomerciales_cond WHERE id_regla = '$id_regla'";

        if ($this -> getConnection() -> query($sql) === TRUE) {
            return true;
        } else {
            return "Error SQL: " . $this -> getConnection() -> error;
        }
    }

    public function checkIfIdRuleExist($id_regla) {
        $sql = "SELECT count(id_regla) as total FROM reglascomerciales WHERE id_regla = '$id_regla';";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return $data['total'];
    }

    public function countConditions($id_regla) {
        $sql = "SELECT count(id_regla) as total FROM reglascomerciales_cond WHERE id_regla =  '$id_regla';";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return $data['total'];
    }

}
