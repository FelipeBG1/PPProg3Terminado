<?php

    require_once "./clases/ProductoEnvasado.php";
    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;


    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "No se pudo modificar el producto";

    
    if($producto_json != 0)
    {
        $producto = json_decode($producto_json);
        $pro = new ProductoEnvasado($producto->id, $producto->nombre,$producto->origen,$producto->codigo_barra,$producto->precio,"");    
        
        if($pro->Modificar())
        {
            $obj->exito = true;
            $obj->mensaje = "Se modifico con exito el producto";
        }
    }

    echo json_encode($obj);

?>