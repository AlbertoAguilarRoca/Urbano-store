<?php

require_once __DIR__ .'/../connection/Db.php';
include_once __DIR__ . '/../../helpers/Referencia.php';

    class PedidoManager extends Db {

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
    
        function insert($ref_pedido, $cliente, $importe, $estado_pedido, $metodo_pago, $codigo_descuento, $dir_envio, $dir_fac) {
            $sql = "INSERT INTO pedidos(ref_pedido, cliente, importe, estado_pedido, fecha, metodo_pago, cod_descuento, direccion_envio, direccion_factura) VALUES ('$ref_pedido', '$cliente', $importe, $estado_pedido, CURRENT_TIMESTAMP,'$metodo_pago', '$codigo_descuento', $dir_envio, $dir_fac)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function insertProductos($id_pedido, $ref_producto, $cantidad) {
            $sql = "INSERT INTO productospedidos(id_pedido, ref_producto, cantidad) VALUES ($id_pedido, '$ref_producto', $cantidad)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }
    
        function getIdPedidoByRef($ref) {
            $sql = "SELECT id FROM pedidos WHERE ref_pedido = '$ref'";
            
            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['id'];
        }
    
    
    }
?>