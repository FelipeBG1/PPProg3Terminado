<?php

    require_once ("./clases/ProductoEnvasado.php"); 
    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;

    $obj = json_decode($producto_json);
    $codigoBarra=$obj->codigo_barra;
    $precio = $obj->precio;
    $nombre = $obj->nombre;
    $origen = $obj->origen;

    $producto = new ProductoEnvasado(0,$nombre,$origen,$codigoBarra,$precio);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($producto->Agregar())
    {
        $rta->bool = true;
        $rta->mensaje = "Se agrego con exito.";
    }

    echo json_encode($rta);
?>