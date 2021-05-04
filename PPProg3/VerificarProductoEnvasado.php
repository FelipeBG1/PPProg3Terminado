<?php

    require_once "./clases/ProductoEnvasado.php";
    $obj_producto = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : 0;

    $retorno = "{}";
    
    
    if($obj_producto != 0)
    {
        $pro = json_decode($obj_producto);
        $array = ProductoEnvasado::Traer();
        $producto = new ProductoEnvasado(0,$pro->nombre,$pro->origen,0,0,"");

        if($producto->Existe($array))
        {
            $retorno = $producto->ToJSON();
        }
    }

    echo $retorno;

?>