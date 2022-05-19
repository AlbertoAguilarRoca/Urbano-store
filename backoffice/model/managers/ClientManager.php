<?php

require_once __DIR__ .'/../connection/Db.php';
include_once __DIR__ . '/../../helpers/Referencia.php';

    class ClientManager extends Db {

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

        public function checkEmail($email) {
            $sql = "SELECT count(email) as total FROM cliente WHERE email = '$email'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        public function getPassword($email) {
            $sql = "SELECT password FROM cliente WHERE email = '$email'";
            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['password'];
        }

        public function getClientId($email) {
            $sql = "SELECT id_cliente FROM cliente WHERE email = '$email'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['id_cliente'];
        }

        public function getAllClients($order = 'registrado', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100) {
            $sql = "SELECT id_cliente, nombre, apellido1, apellido2, email, fecha_nacimiento, registrado, subscrito, invitado FROM cliente ORDER BY $order $sort LIMIT $inicio, $registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        public function getAllClientsSearched($order = 'registrado', $sort = 'ASC', $inicio = 0, $registros_x_pagina = 100, $search) {
            $sql = "SELECT id_cliente, nombre, apellido1, apellido2, email, fecha_nacimiento, registrado ,subscrito, invitado FROM cliente WHERE id_cliente LIKE '%".$search."%' OR nombre LIKE '%".$search."%' OR apellido1 LIKE '%".$search."%' OR apellido2 LIKE '%".$search."%' OR email LIKE '%".$search."%' ORDER BY $order $sort LIMIT $inicio, $registros_x_pagina";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        public function getClientById($id) {
            $sql = "SELECT nombre, apellido1, apellido2, email, genero, fecha_nacimiento, subscrito, invitado FROM cliente WHERE id_cliente = '$id'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            return $data;
        }

        public function getAllClientsLength() {
            $sql = "SELECT count(id_cliente) as total FROM cliente";

            $resultado = $this -> getConnection() -> query($sql);

            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }

        public function getAllClientsSearchedLength($search) {
            $sql = "SELECT count(id_cliente) as total FROM cliente WHERE id_cliente LIKE '%".$search."%' OR nombre LIKE '%".$search."%' OR apellido1 LIKE '%".$search."%' OR apellido2 LIKE '%".$search."%' OR email LIKE '%".$search."%'";

            $resultado = $this -> getConnection() -> query($sql);

            $data = $resultado -> fetch_assoc();
            return $data['total'];
        }
        
        public function insert($nombre, $apellido1, $apellido2, $email, $pass, $fecha_nacimiento, $subscrito, $invitado, $registrado, $ultima_visita, $genero) {

            $id_cliente = new Referencia(15);
            $id_cliente = $id_cliente -> getRef();

            $sql = "INSERT INTO cliente(id_cliente, nombre, apellido1, apellido2, email, password, fecha_nacimiento, subscrito, invitado, registrado, ultima_visita, genero) VALUES('$id_cliente','$nombre', '$apellido1', '$apellido2', '$email', '$pass', '$fecha_nacimiento', $subscrito, $invitado, '$registrado', '$ultima_visita', '$genero')";

            if($this -> checkClientId($id_cliente)) {
                return "Error: Id de cliente existente";
            }

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }

        }

        public function update($nombre, $apellido1, $apellido2, $email, $pass, $fecha_nacimiento, $subscrito, $invitado, $genero, $id) {

            $sql = "UPDATE cliente SET nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', email = '$email',";

            if(!empty($pass)) {
                $sql = $sql . " password = '$pass',";
            }

            $sql = $sql . " fecha_nacimiento = '$fecha_nacimiento', subscrito = $subscrito, invitado = $invitado, genero = '$genero' WHERE id_cliente = '$id'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }

        }

        public function delete($id) {
            $sql = "DELETE FROM cliente WHERE id_cliente = '$id'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }

        }

        function changeDeleteClients($id) {
            
        }

        function checkClientId($id) {
            $sql = "SELECT count(id_cliente) as 'total' FROM cliente WHERE id_cliente = '$id'";

            $resultado = $this -> getConnection() ->query($sql);

            $data = $resultado -> fetch_assoc();

            if($data['total'] == '1') {
                return true;
            } else {
                return false;
            }

        }


    }








?>