<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="http://localhost/urban/style.css">
    <title>Urbano Clothes Store</title>
</head>
<body>
    
    <header class="header" id="header">

        <div class="header_nav">

            <div class="header_burger" id="menu_burger">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="logo">
                <a href="http://localhost/urban/">
                    <picture>
                        <source srcset="src/img/logo-face.svg" media="(max-width: 1000px)" type="image/svg+xml">
                        <img src="src/img/logo.svg" alt="logo">
                    </picture>
                </a>
            </div>

            <div class="search_icon">
                <a class="search_btn" href="#">Buscar</a>
                <i class="bi bi-search"></i>
            </div>

            <div class="sign_in">

                <a href='#'><span class="icon_person"><i class="bi bi-person"></i></span><span class="sign_in_text">Iniciar sesión</span></a>
            </div>

            <div class="cesta_compra">
                <span class="cesta_productos no_products" id="total_productos_cesta"></span>
                <i class="bi bi-bag"></i>
            </div>

        </div>

    </header>

    <nav class="nav" id="nav">

        <div class="nav_head">
            <ul class="nav_head_list">
                <li class="nav_head_item" data-item="hombre">Hombre</li>
                <li class="nav_head_item" data-item="mujer">Mujer</li>
                <li class="nav_head_item" data-item="child">Niño</li>
                <li class="nav_head_item" data-item="skate">Skate</li>
                <li class="nav_head_item" data-item="snow">Snow</li>
            </ul>
        </div>

        <div class="nav_body_container">
            <div class="nav_content show_nav" id="hombre">

                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Ediciones Especiales</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Chaquetas y Abrigos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Sudaderas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="http://localhost/urban/subcategoria.php?gen=1&subcategoria=1">Camisetas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Vaqueros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Pantalones y Chinos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Ropa interior</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Sneakers</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Outdoor</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Gorras y sombreros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Gorros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Mochilas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Bolsos</a>
                    </li>
                </ul>
    
                <div class="nav_img">
                    <div class="nav_img_text">
                        <a href="#">Nueva colección <br>Flower Around</a>
                        <i class="bi bi-arrow-right icon"></i>
                    </div>
                    <img src="src/img/foto-hombre.jpeg" alt="heritage product">
                </div>
    
            </div>
    
            <div class="nav_content" id="mujer">
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Ediciones Especiales</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Chaquetas y Abrigos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Sudaderas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Camisetas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Vestidos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Tops</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Vaqueros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Pantalones y Chinos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Ropa interior</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Sneakers</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Outdoor</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Gorras y sombreros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Gorros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Mochilas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Bolsos</a>
                    </li>
                </ul>
    
                <div class="nav_img">
                    <div class="nav_img_text">
                        <a href="#">Nueva colección <br>Flower Around</a>
                        <i class="bi bi-arrow-right icon"></i>
                    </div>
                    <img src="src/img/foto-mujer.jpeg" alt="heritage product">
                </div>
            </div> 

            <div class="nav_content" id="child">
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Chaquetas y Abrigos</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Sudaderas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Camisetas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Vaqueros</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Pantalones y Chinos</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Sneakers</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Outdoor</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Chanclas</a>
                    </li>
                </ul>
    
                <div class="nav_img">
                    <div class="nav_img_text">
                        <a href="#">Nueva colección <br>Zapatillas Vans</a>
                        <i class="bi bi-arrow-right icon"></i>
                    </div>
                    <img src="src/img/foto-kid.jpeg" alt="heritage product">
                </div>
            </div> 

            <div class="nav_content" id="skate">
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Alex Ramirez</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Kalis Collection</a>
                    </li>
                </ul>
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Zapatillas de Skate</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Ropa</a>
                    </li>
                </ul>
    
                <div class="nav_img">
                    <div class="nav_img_text">
                        <a href="#">Nueva colección <br>Zapatillas Vans</a>
                        <i class="bi bi-arrow-right icon"></i>
                    </div>
                    <img src="src/img/foto-skate.jpeg" alt="heritage product">
                </div>
            </div>

            <div class="nav_content" id="snow">
    
                <ul class="nav_content_list">
                    <li class="nav_content_list_item">
                        <a href="#">Sudaderas</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Chaquetones de snow</a>
                    </li>
                    <li class="nav_content_list_item">
                        <a href="#">Pantalones de Snow</a>
                    </li>
                </ul>
    
                <div class="nav_img">
                    <div class="nav_img_text">
                        <a href="#">Nueva colección <br>Zapatillas Vans</a>
                        <i class="bi bi-arrow-right icon"></i>
                    </div>
                    <img src="src/img/foto-snow.jpeg" alt="heritage product">
                </div>
            </div>

        </div> <!-- end nav body container -->
    </nav>