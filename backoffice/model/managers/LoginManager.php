<?php 
    
    require_once __DIR__ .'/../connection/Db.php';
    include_once __DIR__ .'/../../helpers/Referencia.php';

    class LoginManager extends Db {

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

        function insert($nombre, $apellidos, $email, $permiso, $password, $puesto, $foto, $tipofoto) {
            $userkey = new Referencia(15);
            $userkey = $userkey -> getRef();
            $sql = "INSERT INTO usuario (nombre, apellidos, email, permiso, password, puesto, foto_usuario, tipo_foto, userKey) 
            VALUES ('$nombre', '$apellidos', '$email', $permiso, '$password', '$puesto', '$foto', '$tipofoto', '$userkey')";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function update($nombre, $apellidos, $email, $permiso, $password, $puesto, $foto, $tipofoto, $id) {
            $sql = "UPDATE usuario SET nombre = '$nombre', apellidos = '$apellidos', email = '$email', permiso = $permiso, 
            password = '$password', puesto = '$puesto', foto_usuario = '$foto', tipo_foto = '$tipofoto'  
            WHERE id = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function delete($id) {
            $sql = "DELETE FROM usuario WHERE id = $id";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        //comprueba si el email existe
        function checkEmail($email) {
            $sql = "SELECT count(email) as email from usuario WHERE email = '$email'";
            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return intval($data['email']);
        }

        function getPassword($email) {
            $sql = "SELECT password FROM usuario WHERE email = '$email'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data['password'];
        }

        function getUserInfo($email) {
            $sql = "SELECT nombre, apellidos, permiso, userkey, foto_usuario, puesto, tipo_foto 
            FROM usuario WHERE email = '$email'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

    }
