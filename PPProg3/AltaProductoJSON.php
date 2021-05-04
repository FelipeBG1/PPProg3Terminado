<?php

    require_once "./clases/Producto.php";
    
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;

    $obj = new stdClass();
    $obj->exito = true;
    $obj->mensaje = "No se pudo agregar el producto al archivo";
    
    if($nombre != 0 && $origen != 0)
    {
        $producto = new Producto($nombre,$origen);

        $obj = $producto->GuardarJSON("archivos/productos.json");
    }

    echo json_encode($obj);

?>