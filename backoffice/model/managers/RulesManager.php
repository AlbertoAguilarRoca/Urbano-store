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

    public function insert_rule($nombre, $grupo, $fecha_inicio, $fecha_fin, $tipo_reduccion, $reduccion, $tasas_incluidas) {
        $sql = "INSERT INTO reglascomerciales (nombre, grupo, fecha_inicio, fecha_fin, tipo_reduccion, reduccion, tasas_incluidas)
        VALUES ('$nombre', '$grupo', '$fecha_inicio', '$fecha_fin', '$tipo_reduccion', '$reduccion', '$tasas_incluidas')";

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

    public function checkIfIdRuleExist($id_regla) {
        $sql = "SELECT count(id_regla) as total FROM reglascomerciales WHERE id_regla = '$id_regla';";

        $resultado = $this -> getConnection() -> query($sql);
        $data = $resultado -> fetch_assoc();
        return $data['total'];
    }

}


?>