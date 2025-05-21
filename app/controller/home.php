<?php
session_start();
require_once '../config/conexion.php';

class Home extends Conexion {
    public function obtener_datos() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_productos");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function agregar_producto() {
        if (isset($_POST['codigo']) && !empty($_POST['codigo']) && 
            isset($_POST['nombre']) && !empty($_POST['nombre']) && 
            isset($_POST['uCompra']) && !empty($_POST['uCompra']) && 
            isset($_POST['uVenta']) && !empty($_POST['uVenta']) && 
            isset($_POST['uCantidad']) && !empty($_POST['uCantidad']) && 
            isset($_POST['pCompra']) && !empty($_POST['pCompra']) && 
            isset($_POST['pCosto']) && !empty($_POST['pCosto']) && 
            isset($_POST['precio']) && !empty($_POST['precio']) && 
            isset($_POST['cantidad_minima']) && !empty($_POST['cantidad_minima']) &&
            isset($_POST['cantidad_maxima']) && !empty($_POST['cantidad_maxima']) ){
            
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $uCompra = $_POST['uCompra'];
            $uVenta = $_POST['uVenta'];
            $uCantidad = $_POST['uCantidad'];
            $pCompra = $_POST['pCompra'];
            $pCosto = $_POST['pCosto'];
            $precio = $_POST['precio'];
            $cantidadMinima = $_POST['cantidad_minima'];
            $cantidad_maxima = $_POST['cantidad_maxima'];

            if (!is_numeric($codigo)) {
                echo json_encode([0,"Solo puedes ingresar numeros en el codigo"]);
            } else if(!is_numeric($precio)){
                echo json_encode([0,"Solo puedes ingresar numeros en el precio"]);
            } else if($precio <= 0){
                echo json_encode([0,"No puedes ingresar numeros negativos"]);
            } else if(!is_numeric($cantidadMinima)){
                echo json_encode([0,"Ingresa solo numeros en cantidad minima"]);
            } else if($cantidadMinima < 0){
                echo json_encode([0,"No puedes ingresar numeros negativos"]);
            } else if($uCantidad < 0){
                echo json_encode([0,"No puedes ingresar numeros negativos"]);
            } else if($pCompra < 0){
                echo json_encode([0,"No puedes ingresar numeros negativos"]);
            } else if($pCosto < 0){
                echo json_encode([0,"No puedes ingresar numeros negativos"]);
            } else if($cantidad_maxima < $cantidadMinima){
                echo json_encode([0,"La cantidad maxima tiene que ser mayor a tu cantidad minima"]);
            } else if($cantidad_maxima < $uCantidad){
                echo json_encode([0,"La cantidad maxima tiene que ser mayor a tu cantidad"]);
            } else {
                $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_productos 
                                                                WHERE producto_codigo = :codigo OR producto_nombre = :nombre");
                $consulta->bindParam(':codigo',$codigo);
                $consulta->bindParam(':nombre',$nombre);
                $consulta->execute();
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $this->cerrar_conexion();

                if ($datos) {
                    echo json_encode([0,"Este producto ya esta ingresado"]);
                } else {
                    $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_productos (producto_codigo,producto_nombre,
                    producto_uCompra,producto_uVenta,producto_uCantidad,producto_pCompra,producto_pCosto,
                    producto_precio,producto_cantidad,producto_cantidad_minima,producto_cantidad_maxima) 
                    VALUES(:codigo,:nombre,:uCompra,:uVenta,:uCantidad,:pCompra,:pCosto,:precio,0,:cantidad_minima,:cantidad_maxima)");
                    
                    $insercion->bindParam(':codigo',$codigo);
                    $insercion->bindParam(':nombre',$nombre);
                    $insercion->bindParam(':uCompra',$uCompra);
                    $insercion->bindParam(':uVenta',$uVenta);
                    $insercion->bindParam(':uCantidad',$uCantidad);
                    $insercion->bindParam(':pCompra',$pCompra);
                    $insercion->bindParam(':pCosto',$pCosto);
                    $insercion->bindParam(':precio',$precio);
                    $insercion->bindParam(':cantidad_minima',$cantidadMinima);
                    $insercion->bindParam(':cantidad_maxima',$cantidad_maxima);
                    $insercion->execute();
                    $this->cerrar_conexion();
                    
                    if ($insercion) {
                        echo json_encode([1,"Producto registrado"]);
                    } else {
                        echo json_encode([0,"Producto NO registrado"]);
                    }
                }
            }

        } else {
            echo json_encode([0,"No puedes dejar campos vacios"]);
        }
    }

    public function editar_producto() {
        $id = $_POST['id'];
        $codigo = $_POST['codigo-editar'];
        $nombre = $_POST['nombre-editar'];
        $uCompra = $_POST['uCompra-editar'];
        $uVenta = $_POST['uVenta-editar'];
        $uCantidad = $_POST['uCantidad-editar'];
        $pCompra = $_POST['pCompra-editar'];
        $pCosto = $_POST['pCosto-editar'];
        $precio = $_POST['precio-editar'];
        $cantidadMinima = $_POST['cantidad_minima-editar'];
        $cantidad_maxima = $_POST['cantidad_maxima-editar'];

        if (empty($codigo) || empty($nombre) || empty($precio) || empty($cantidadMinima) || empty($uCompra) || 
            empty($uVenta) || empty($uCantidad) || empty($pCompra) || empty($pCosto) || empty($cantidad_maxima)) {
            echo json_encode([0,"Campos incompletos"]);
        } else if (!is_numeric($codigo)) {
            echo json_encode([0,"Solo puedes ingresar numeros en el codigo"]);
        } else if(!is_numeric($precio)){
            echo json_encode([0,"Solo puedes ingresar numeros en el precio"]);
        } else if($precio <= 0){
            echo json_encode([0,"No puedes ingresar numeros negativos"]);
        } else if(!is_numeric($cantidadMinima)){
            echo json_encode([0,"Ingresa solo numeros en cantidad minima"]);
        } else if($cantidadMinima < 0){
            echo json_encode([0,"Solo numeros positivos en cantidad minima"]);
        }else if($uCantidad < 0){
            echo json_encode([0,"No puedes ingresar numeros negativos"]);
        } else if($pCompra < 0){
            echo json_encode([0,"No puedes ingresar numeros negativos"]);
        } else if($pCosto < 0){
            echo json_encode([0,"No puedes ingresar numeros negativos"]);
        } else if($cantidad_maxima < $cantidadMinima){
            echo json_encode([0,"La cantidad maxima tiene que ser mayor a tu cantidad minima"]);
        } else if($cantidad_maxima < $uCantidad){
            echo json_encode([0,"La cantidad maxima tiene que ser mayor a tu cantidad"]);
        } else {
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_productos 
            SET producto_codigo = :codigo, producto_nombre = :nombre, producto_uCompra = :uCompra, producto_uVenta = :uVenta,
                producto_uCantidad = :uCantidad, producto_pCompra = :pCompra, producto_pCosto = :pCosto, producto_precio = :precio,
                producto_cantidad_minima = :cantidadMinima, producto_cantidad_maxima = :cantidad_maxima
            WHERE producto_id = :id");
            
            $actualizacion->bindParam(':codigo',$codigo);
            $actualizacion->bindParam(':nombre',$nombre);
            $actualizacion->bindParam(':uCompra',$uCompra);
            $actualizacion->bindParam(':uVenta',$uVenta);
            $actualizacion->bindParam(':uCantidad',$uCantidad);
            $actualizacion->bindParam(':pCompra',$pCompra);
            $actualizacion->bindParam(':pCosto',$pCosto);
            $actualizacion->bindParam(':precio',$precio);
            $actualizacion->bindParam(':cantidadMinima',$cantidadMinima);
            $actualizacion->bindParam(':id',$id);
            $actualizacion->bindParam(':cantidad_maxima',$cantidad_maxima);
            $actualizacion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Producto actualizado"]);
        }
    }

    public function eliminar_producto() {
        $id = $_POST['id'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_productos WHERE producto_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Producto eliminado']);
        } else {
            echo json_encode([0,'Error al eliminar el producto']);
        }
    }

    public function productos_vender () {
        $productos = $this->obtener_conexion()->prepare("SELECT 
            t_ventas.venta_id,
            t_ventas.id_producto,
            t_ventas.venta_cantidad,
            t_productos.producto_id,
            t_productos.producto_codigo,
            t_productos.producto_nombre,
            t_productos.producto_precio
            FROM 
                t_ventas
            JOIN 
                t_productos ON t_ventas.id_producto = t_productos.producto_id;");
        
        $productos->execute();
        $datos_producto = $productos->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos_producto);
    }

    public function agregar_producto_vender () {
        $id = $_POST['id_producto'];
       
        $consulta = $this->obtener_conexion()->prepare("SELECT id_producto FROM t_ventas WHERE id_producto = :id");
        $consulta->bindParam(':id',$id);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();

        if ($datos) {
            echo json_encode([0,"El producto ya esta en venta, puedes aumentar su cantidad"]);
        } else {
            $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_ventas(id_producto,venta_cantidad) VALUES(:id_producto,1)");
            
            $insercion->bindParam(':id_producto',$id);
            $insercion->execute();
            $this->cerrar_conexion();
    
            echo json_encode([1,"Producto agregado"]);
        }

    }

    public function eliminar_producto_vender () {
        $id = $_POST['id_venta'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_ventas WHERE venta_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        echo json_encode([1,'Producto eliminado']);
    }

    public function aumentar_cantidad () {
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];

        $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_ventas 
        SET venta_cantidad = :cantidad WHERE venta_id = :id");
        
        $actualizacion->bindParam(':cantidad',$cantidad);
        $actualizacion->bindParam(':id',$id);
        $actualizacion->execute();
        $this->cerrar_conexion();
        echo json_encode([1,"Producto actualizado"]);
    }

    public function productos_por_comprar () {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM `t_productos` WHERE producto_cantidad <= producto_cantidad_minima");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function calculando_total_venta () {
        date_default_timezone_set("America/Mexico_City");
        $efectivo = $_POST['efectivo'];
        $transferencia = $_POST['transferencia'];
        $tarjeta = $_POST['tarjeta'];
        $fecha = date("Y-m-d");
         
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM `t_calculado` WHERE calculado_fecha = :fecha");
        $consulta->bindParam(':fecha',$fecha);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();

        if ($datos) {
        
            $total_efectivo = $datos[0]['calculado_efectivo'] + $efectivo;
            $total_transferencia = $datos[0]['calculado_transferencia'] + $transferencia;
            $total_tarjeta = $datos[0]['calculado_tarjeta'] + $tarjeta;
                
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_calculado 
            SET calculado_efectivo = :efectivo, calculado_transferencia = :transferencia, calculado_tarjeta = :tarjeta
            WHERE calculado_fecha = :fecha");
            
            $actualizacion->bindParam(':fecha',$fecha);
            $actualizacion->bindParam(':efectivo',$total_efectivo);
            $actualizacion->bindParam(':transferencia',$total_transferencia);
            $actualizacion->bindParam(':tarjeta',$total_tarjeta);
            $actualizacion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Venta exitosa"]);
           
        } else {
            $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_calculado (calculado_fecha,calculado_efectivo,
                                                                                calculado_transferencia,calculado_tarjeta) 
            VALUES(:fecha,:efectivo,:transferencia,:tarjeta)");
            
            $insercion->bindParam(':fecha',$fecha);
            $insercion->bindParam(':efectivo',$efectivo);
            $insercion->bindParam(':transferencia',$transferencia);
            $insercion->bindParam(':tarjeta',$tarjeta);
            $insercion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Venta exitosa"]);
        }
    }

    public function reiniciando_ventas () {
        $consulta = $this->obtener_conexion()->prepare("SELECT id_producto, venta_cantidad  FROM t_ventas");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();

        for ($i=0; $i < count($datos); $i++) { 
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_productos 
            SET producto_cantidad = producto_cantidad - :cantidad
            WHERE producto_id = :id");
            
            $actualizacion->bindParam(':cantidad',$datos[$i]['venta_cantidad']);
            $actualizacion->bindParam(':id',$datos[$i]['id_producto']);
            $actualizacion->execute();
            $this->cerrar_conexion();

        }

        $eliminar = $this->obtener_conexion()->prepare("TRUNCATE TABLE t_ventas");
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Productos eliminados']);
        } else {
            echo json_encode([0,'Error al eliminar el producto']);
        }
    }

    public function obtener_datos_calculado() {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");

        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_calculado WHERE calculado_fecha = :fecha");
        $consulta->bindParam(':fecha',$fecha);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();

        echo json_encode($datos);
    }

    public function corte_caja() {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        $hora = date("h:i:s A");
        $contado = $_POST['contado'];
        $calculado = $_POST['calculado'];
        $diferencia = $_POST['diferencia'];
        $usuario = $_SESSION['usuario']['usuario_usuario'];

         $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_corte (corte_fecha,corte_hora,corte_contado,corte_calculado,
                                                                               corte_diferencia,corte_usuario) 
        VALUES(:fecha,:hora,:contado,:calculado,:diferencia,:usuario)");
        
        $insercion->bindParam(':fecha',$fecha);
        $insercion->bindParam(':hora',$hora);
        $insercion->bindParam(':contado',$contado);
        $insercion->bindParam(':calculado',$calculado);
        $insercion->bindParam(':diferencia',$diferencia);
        $insercion->bindParam(':usuario',$usuario);
        $insercion->execute();
        $this->cerrar_conexion();

        $eliminar = $this->obtener_conexion()->prepare("TRUNCATE TABLE t_calculado");
        $eliminar->execute();
        $this->cerrar_conexion();

        if ($insercion) {
            echo json_encode([1,"Corte de caja realizada"]);
        } else {
            echo json_encode([0,"Error al realizar corte"]);
        }
    }

    public function obtener_cortes_caja() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_corte");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function visualizar_corte() {
        $corte_id = $_POST['id_corte'];

        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_corte WHERE corte_id = :id");
        $consulta->bindParam(':id',$corte_id);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function obtener_provedores() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_provedores");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function agregar_provedor() {
        $nombre = $_POST['nombre'];
        $empresa = $_POST['empresa'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $direccion = $_POST['direccion'];
        $rfc = $_POST['rfc'];
        $pago = $_POST['pago'];

        if (empty($nombre) && empty($empresa)) {
            echo json_encode([0,"Nombre o empresa son datos obligatorios"]);
        } else if(is_numeric($nombre)) {
            echo json_encode([0,"No se admiten numeros en el nombre"]);
        } else if(!is_numeric($telefono)) {
            echo json_encode([0,"No se admiten letras en telefono"]);
        } else {

            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_provedores WHERE provedor_nombre = :nombre");
            $consulta->bindParam(':nombre',$nombre);
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $this->cerrar_conexion();
    
            if ($datos) {
                echo json_encode([0,"Este provedor ya esta ingresado"]);
            } else {
                $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_provedores (provedor_nombre,provedor_empresa,
                provedor_telefono,provedor_email,provedor_direccion,provedor_rfc,provedor_pago) 
                VALUES(:nombre,:empresa,:telefono,:email,:direccion,:rfc,:pago)");
                            
                $insercion->bindParam(':nombre',$nombre);
                $insercion->bindParam(':empresa',$empresa);
                $insercion->bindParam(':telefono',$telefono);
                $insercion->bindParam(':email',$email);
                $insercion->bindParam(':direccion',$direccion);
                $insercion->bindParam(':rfc',$rfc);
                $insercion->bindParam(':pago',$pago);
                $insercion->execute();
                $this->cerrar_conexion();
        
                if ($insercion) {
                    echo json_encode([1,"Provedor registrado"]);
                } else {
                    echo json_encode([0,"Provedor NO registrado"]);
                }
            }
    
        }

    }

    public function editar_provedor() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre-editar'];
        $empresa = $_POST['empresa-editar'];
        $telefono = $_POST['telefono-editar'];
        $email = $_POST['email-editar'];
        $direccion = $_POST['direccion-editar'];
        $rfc = $_POST['rfc-editar'];
        $pago = $_POST['pago-editar'];

        if (empty($nombre) && empty($empresa)) {
            echo json_encode([0,"Nombre o empresa son datos obligatorios"]);
        } else if(is_numeric($nombre)) {
            echo json_encode([0,"No se admiten numeros en el nombre"]);
        } else if(!is_numeric($telefono)) {
            echo json_encode([0,"No se admiten letras en telefono"]);
        } else {
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_provedores 
            SET provedor_nombre = :nombre, provedor_empresa = :empresa, provedor_telefono = :telefono,
                provedor_email = :email, provedor_direccion = :direccion, provedor_rfc = :rfc, provedor_pago = :pago
            WHERE provedor_id = :id");
            
            $actualizacion->bindParam(':nombre',$nombre);
            $actualizacion->bindParam(':empresa',$empresa);
            $actualizacion->bindParam(':telefono',$telefono);
            $actualizacion->bindParam(':email',$email);
            $actualizacion->bindParam(':direccion',$direccion);
            $actualizacion->bindParam(':rfc',$rfc);
            $actualizacion->bindParam(':pago',$pago);
            $actualizacion->bindParam(':id',$id);
            $actualizacion->execute();
            $this->cerrar_conexion();
            echo json_encode([1,"Producto actualizado"]);
        }
    }

    public function eliminar_provedor() {
         $id = $_POST['id'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_provedores WHERE provedor_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Provedor eliminado']);
        } else {
            echo json_encode([0,'Error al eliminar el provedor']);
        }
    }

    public function agregar_lista_producto() {
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre-producto'];
        $cantidad_comprar = $_POST['cantidad-comprar'];
        $precio_comprar = $_POST['precio-comprar'];
        $total = $cantidad_comprar * $precio_comprar;

        if (empty($cantidad_comprar) || empty($precio_comprar)) {
            echo json_encode([0,"Tienes que ingresar la cantidad y el precio"]);
        } else if ($cantidad_comprar <= 0){
            echo json_encode([0,"Tienes que ingresar una cantidad valida"]);
        } else if($precio_comprar <= 0){
            echo json_encode([0,"Tienes que ingresar un precio valido"]);
        }else {
            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_lista_compras WHERE lista_codigo = :codigo");
            $consulta->bindParam(':codigo',$codigo);
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $this->cerrar_conexion();

            if ($datos) {
                echo json_encode([0,"Este producto ya esta en la lista"]);
            } else {
                $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_lista_compras(lista_cantidad,lista_codigo,
                                                        lista_producto,lista_precio,lista_total,id_producto) 
                VALUES(:cantidad_comprar,:codigo,:nombre,:precio_comprar,:total,:id)");
                
                $insercion->bindParam(':cantidad_comprar',$cantidad_comprar);
                $insercion->bindParam(':codigo',$codigo);
                $insercion->bindParam(':nombre',$nombre);
                $insercion->bindParam(':precio_comprar',$precio_comprar);
                $insercion->bindParam(':total',$total);
                $insercion->bindParam(':id',$id);
                $insercion->execute();
                $this->cerrar_conexion();

                if ($insercion) {
                    echo json_encode([1,"Producto agregado"]);
                } else {
                    echo json_encode([0,"Producto NO agregado"]);
                }
            }
        }

    }

    public function obtener_lista_comprar() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_lista_compras");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function eliminar_producto_lista() {
        $id = $_POST['id'];

        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_lista_compras WHERE lista_id = :id");
        $eliminar->bindParam(':id',$id);
        $eliminar->execute();
        $this->cerrar_conexion();
        if ($eliminar) {
            echo json_encode([1,'Producto eliminado']);
        } else {
            echo json_encode([0,'Error al eliminar el producto']);
        }
    }

    public function agregar_compra($fecha,$hora,$provedor,$usuario,$total_pagar){
        $insercion = $this->obtener_conexion()->prepare("INSERT INTO t_compras (comprar_fecha,comprar_hora,
                    comprar_provedor,comprar_usuario,comprar_total) 
                    VALUES(:fecha,:hora,:provedor,:usuario,:total_pagar)");
                                
        $insercion->bindParam(':fecha',$fecha);
        $insercion->bindParam(':hora',$hora);
        $insercion->bindParam(':provedor',$provedor);
        $insercion->bindParam(':usuario',$usuario);
        $insercion->bindParam(':total_pagar',$total_pagar);
        $insercion->execute();
        $this->cerrar_conexion();

        $consulta = $this->obtener_conexion()->prepare("SELECT id_producto, lista_cantidad  FROM t_lista_compras");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();

        for ($i=0; $i < count($datos); $i++) { 
            $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_productos 
            SET producto_cantidad = producto_uCantidad * :cantidad
            WHERE producto_id = :id");
            
            $actualizacion->bindParam(':cantidad',$datos[$i]['lista_cantidad']);
            $actualizacion->bindParam(':id',$datos[$i]['id_producto']);
            $actualizacion->execute();
            $this->cerrar_conexion();

        }
        
        $eliminar = $this->obtener_conexion()->prepare("TRUNCATE TABLE t_lista_compras");
        $eliminar->execute();
        $this->cerrar_conexion();

        if ($actualizacion) {
            echo json_encode([1,"Compra exitosa"]);
        } else {
            echo json_encode([0,"Error al generar la compra"]);
        }
    }

    public function finalizar_compra() {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        $hora = date("h:i:s A");
        $provedor = $_POST['provedor'];
        $usuario = $_SESSION['usuario']['usuario_usuario'];
        $total_pagar = $_POST['total-pagar'];
        $forma_pago = $_POST['forma-pago'];

        if (empty($total_pagar)) {
            echo json_encode([0,"Tienes que ingresar la cantidad a pagar"]);
        } else if(empty($forma_pago)){
            echo json_encode([0,"Escoge una forma de pago"]);
        } else {

            if ($forma_pago == 'caja') {
                $corte = $this->obtener_conexion()->prepare("SELECT calculado_efectivo FROM t_calculado 
                                                             WHERE calculado_fecha = :fecha");
                $corte->bindParam(':fecha',$fecha);
                $corte->execute();
                $datosCorte = $corte->fetchAll(PDO::FETCH_ASSOC);
                $this->cerrar_conexion();
                
                if($datosCorte){
                    if ($datosCorte[0]['calculado_efectivo'] >= $total_pagar) {
                        $actualizacion = $this->obtener_conexion()->prepare("UPDATE t_calculado 
                        SET calculado_efectivo = calculado_efectivo - :pagar
                        WHERE calculado_fecha = :fecha");
                        
                        $actualizacion->bindParam(':pagar',$total_pagar);
                        $actualizacion->bindParam(':fecha',$fecha);
                        $actualizacion->execute();
                        $this->cerrar_conexion();

                        $this->agregar_compra($fecha,$hora,$provedor,$usuario,$total_pagar);

                    }else {
                        echo json_encode([0,"No tienes suficiente dinero en caja"]);
                    }
                } else {
                    echo json_encode([0,"Todavia no tienes ventas"]);
                }

            } else if($forma_pago == 'otro'){
                $this->agregar_compra($fecha,$hora,$provedor,$usuario,$total_pagar);
            }

        }

    }
}

$consulta = new Home();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>