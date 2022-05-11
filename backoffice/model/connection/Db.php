<?php 

    class Db {

        private $host = 'localhost';
        private $user = 'root';
        private $password = 'root';
        private $dataBase = 'newway';
        private $port = 3306;

        private $connection;

        private $error = false;
        private $error_connection;

        public function __construct()
        {
            $this -> connection = new mysqli($this -> host, $this -> user, $this -> password, $this -> dataBase, $this -> port);

            if($this-> connection -> connect_error) {
                $this -> error = true;
                $this -> error_connection = $this-> connection -> connect_error;

                die('Error de conexión: '.$this -> error_connection);
            }
            
        }

        function getConnection() {
            return $this -> connection;
        }

    }
    
?>