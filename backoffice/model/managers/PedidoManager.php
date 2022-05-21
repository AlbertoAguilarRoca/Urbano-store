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

        function getPedidos($sql) {
            $resultado = $this->getConnection()->query($sql);
            return $resultado;
        }

        function getPedidosLength($filtro) {
            $sql = "SELECT count(ref_pedido) as total FROM pedidos";

            if($filtro != '') {
                $sql = $sql . " WHERE estado_pedido IN (".intval($filtro).")";
            }

            $resultado = $this->getConnection()->query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['total'];
        }

        function getPedidosSearchLength($busqueda, $filtro = '') {
            $sql = "SELECT count(ref_pedido) as total FROM pedidos WHERE ref_pedido LIKE '%".$busqueda."%' OR cliente LIKE '%".$busqueda."%' OR fecha LIKE '%".$busqueda."%'";

            if($filtro != '') {
                $sql = $sql . "AND estado_pedido IN ($filtro)";
            }

            $resultado = $this->getConnection()->query($sql);
            $data = $resultado -> fetch_assoc();

            return $data['total'];
        }
    
        function insert($ref_pedido, $cliente, $importe, $estado_pedido, $metodo_pago, $codigo_descuento, $dir_envio, $dir_fac) {
            $sql = "INSERT INTO pedidos(ref_pedido, cliente, importe, estado_pedido, fecha, metodo_pago, cod_descuento, direccion_envio, direccion_factura) VALUES ('$ref_pedido', '$cliente', $importe, $estado_pedido, CURRENT_TIMESTAMP,'$metodo_pago', '$codigo_descuento', $dir_envio, $dir_fac)";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }

        function insertProductos($id_pedido, $ref_producto, $cantidad, $talla) {
            $sql = "INSERT INTO productospedidos(id_pedido, ref_producto, cantidad, talla) VALUES ($id_pedido, '$ref_producto', $cantidad, '$talla')";

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

        function getEstadosPedidos() {
            $sql = "SELECT id, nombre FROM estadopedido";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        function getPedidoByRef($ref) {
            $sql = "SELECT id, ref_pedido, importe, fecha, estado_pedido, cliente, direccion_envio, direccion_factura, metodo_pago FROM pedidos WHERE ref_pedido = '$ref'";

            $resultado = $this -> getConnection() -> query($sql);
            $data = $resultado -> fetch_assoc();
            return $data;
        }

        function getProductosPedido($id_pedido) {
            $sql = "SELECT pp.ref_producto, p.nombre, c.nombre as color, pp.talla, pp.cantidad
            FROM productospedidos pp, productos p, colores c, pedidos pd
            WHERE pp.ref_producto = p.referencia AND pd.id = pp.id_pedido AND c.id = p.color AND pd.ref_pedido = '$id_pedido'";

            $resultado = $this -> getConnection() -> query($sql);
            return $resultado;
        }

        function updateEstado($estado, $ref) {
            $sql = "UPDATE pedidos SET estado_pedido = $estado WHERE ref_pedido = '$ref'";

            if ($this -> getConnection() -> query($sql) === TRUE) {
                return true;
            } else {
                return "Error SQL: " . $this -> getConnection() -> error;
            }
        }
    
    
    }
?>