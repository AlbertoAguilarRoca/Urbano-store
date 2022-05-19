<?php

    class ControlAcceso {

        private $user = null;

        public function __construct()
        {
            session_start();
            if(isset($_SESSION['cliente'])) {
                $this -> user = $_SESSION['cliente'];
            }
        }

        public function getUser() {
            return $this -> user;
        }

        public function setUser($cliente) {
            $_SESSION['cliente'] = $cliente;
            $this -> user = $cliente;
        }

        public function logOut() {
            session_destroy();
        }

    }

?>