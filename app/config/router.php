<?php
    if (isset($_REQUEST['viewLogin'])) {
        $vistaLogin = $_REQUEST['viewLogin'];
    }else {
        $vistaLogin = "login";
    }
    switch ($vistaLogin) {
        case "login":{
            require_once './views/login.php';
            break;
        }
        case "informacion":{
            require_once './views/informacion.php';
            break;
        }
        case "registrar_usuario":{
            require_once './views/registrar_usuario.php';
            break;
        }
        case "administrar":{
            require_once './views/administrar.php';
            break;
        }
        case "inicio":{
            require_once './views/home.php';
            break;
        }
        case "caja":{
            require_once './views/caja.php';
            break;
        }
        case "productos":{
            require_once './views/productos.php';
            break;
        }
        case "comprar":{
            require_once './views/comprar.php';
            break;
        }
        case "corte":{
            require_once './views/corte.php';
            break;
        }
        case "detalles":{
            require_once './views/detalles.php';
            break;
        }
        case "provedores":{
            require_once './views/provedores.php';
            break;
        }
        default:{
            require_once './views/error404.php';
        }
        break;
    }
?> 