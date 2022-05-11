<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/style.css"; ?>">

    <title>Urbano Clothes Store</title>
</head>

<body>

    <div class="container">

        <!--menu de iconos-->
        <div class="menu-icons">

            <div class="menu-icons-fixed">
                <div class="menu-icons-header">
                    <div id="menu-burger" class="menu-burger">
                        <i class="bi bi-emoji-laughing"></i>
                    </div>
                </div>

                <div class="menu-icons-list">
                    <div class="menu-icons-list-item" data-title="Catálogo" data-name="catalogo">
                        <button><i class="bi bi-shop-window"></i></button>
                        <span class="menu-list-item-popover">Catálogo</span>
                    </div>

                    <div class="menu-icons-list-item" data-title="Estadísticas" data-name="estadisticas">
                        <button><i class="bi bi-graph-up"></i></button>
                        <span class="menu-list-item-popover">Estadísticas</span>
                    </div>

                    <div class="menu-icons-list-item" data-title="Métodos de pago" data-name="paymethods">
                        <button><i class="bi bi-credit-card"></i></button>
                        <span class="menu-list-item-popover">Métodos de pago</span>
                    </div>

                    <div class="menu-icons-list-item" data-title="Métodos de envío" data-name="delivery">
                        <button><i class="bi bi-truck"></i></button>
                        <span class="menu-list-item-popover">Métodos de envío</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="menu" id="header-menu">

            <div class="menu-container">

                <div class="menu-user">
                    <div class="menu-user-foto" id="profile-foto">
                        <?php
                            $foto = $tipoFoto = "";
                            if(isset($_SESSION['user']['foto_usuario']) && $_SESSION['user']['foto_usuario'] != "") {
                                $foto = $_SESSION['user']['foto_usuario'];
                                $tipoFoto = $_SESSION['user']['tipo_foto'];
                        ?>
                            <img src="data:<?php echo $tipoFoto; ?>;base64,<?php echo base64_encode($foto); ?>" alt="Foto usuario">
                        <?php
                            }
                        ?>
                    </div>

                    <div class="menu-user-info">

                        <div class="user-info-content">
                            <h3 class="user-info-name">
                                <?php 
                                    echo $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellidos'][0].'.';
                                ?>
                            </h3>
                            <p class="user-job">
                                <?php echo $_SESSION['user']['puesto'] ?> 
                            </p>
                        </div>
                        <button id="chevron-user" class="chevron"><i class="bi bi-chevron-down"></i></button>

                    </div>
                    <div class="menu-user-options">
                        <ul>
                            <li class="user-options-item"><a href="#">Perfil</a></li>
                            <li class="user-options-item"><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/logOut.php"; ?>">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>

                <div class="menu-nav">

                    <!--menu de catalogo-->
                    <div class="menu-nav-content" id="catalogo">

                        <div class="menu-dashboard">
                            <a href="#">Dashboard</a>
                        </div>

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3>Pedidos</h3>
                                <button class="chevron"><i class="bi bi-chevron-down"></i></button>
                            </div>

                            <ul class="menu-nav-content-group-list">
                                <li><a href="#">Pedidos</a></li>
                                <li><a href="#">Facturas</a></li>
                            </ul>
                        </div>

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3>Catálogo</h3>
                                <button class="chevron"><i class="bi bi-chevron-down"></i></button>
                            </div>

                            <ul class="menu-nav-content-group-list">
                                <li><a href="#">Productos</a></li>
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/catalogo/categorias/"; ?>">Categorías</a></li>
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/catalogo/atributos/colores/"; ?>">Atributos y características</a></li>
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/catalogo/marcas/"; ?>">Marcas</a></li>
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/catalogo/descuentos/comerciales/"; ?>">Descuentos</a></li>
                                <li><a href="#">Stock</a></li>
                            </ul>
                        </div>

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3>Clientes</h3>
                                <button class="chevron"><i class="bi bi-chevron-down"></i></button>
                            </div>

                            <ul class="menu-nav-content-group-list">
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/clientes/"; ?>"">Clientes</a></li>
                                <li><a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/urban/backoffice/clientes/direcciones/"; ?>"">Direcciones</a></li>
                            </ul>
                        </div>

                    </div>
                    <!--final de menu catalogo-->

                    <!--menu de estadisticas-->
                    <div class="menu-nav-content" id="estadisticas">
                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3><a href="#">Estadísticas</a></h3>
                            </div>
                        </div>
                    </div>
                    <!--final de menu estadisticas-->

                    <!--menu de metodos de pago-->
                    <div class="menu-nav-content" id="paymethods">

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3><a href="#">Métodos de pago</a></h3>
                            </div>
                        </div>

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3><a href="#">Preferencias</a></h3>
                            </div>
                        </div>

                    </div>
                    <!--final de menu metodos de pago-->

                    <!--menu de metodos de pago-->
                    <div class="menu-nav-content" id="delivery">

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3><a href="#">Métodos de Envío</a></h3>
                            </div>
                        </div>

                        <div class="menu-nav-content-group">
                            <div class="menu-nav-content-group-title">
                                <h3><a href="#">Empresas</a></h3>
                            </div>
                        </div>

                    </div>
                    <!--final de menu metodos de pago-->

                </div>
                <!--final de .menu-nav-->

            </div>
            <!--final de .menu-container-->

        </div>
        <!--final de .menu-->

        