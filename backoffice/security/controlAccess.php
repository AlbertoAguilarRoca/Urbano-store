<?php

    class ControlAccess {

        private $user = null;

        public function __construct()
        {
            session_start();
            if(isset($_SESSION['user'])) {
                $this -> user = $_SESSION['user'];
            }
        }

        public function getUser() {
            return $this -> user;
        }

        public function setUser($usuario) {
            $_SESSION['user'] = $usuario;
            $this -> user = $usuario;
        }

        public function setUserCredential($email, $password) {
            setcookie("email", $email, time()+60*60*24*30, '/');
            setcookie("pass", $password, time()+60*60*24*30, '/');
        }

        public function deleteUserCredential() {
            setcookie("email", "", time() - 3600, "/");
            setcookie("pass", "", time() - 3600, "/");
        }

        public function logOut() {
            session_destroy();
        }

    }

?>