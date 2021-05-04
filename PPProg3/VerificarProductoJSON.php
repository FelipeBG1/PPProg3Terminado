<?php

    require_once ("./clases/Producto.php"); 

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se encontro la cookie";

    $obj = Producto::VerificarProductoJSON(new Producto($nombre,$origen));
    $objeto = json_decode($obj);
    $nombreCookie = $nombre . "_" . $origen;

    if(!isset($_COOKIE[$nombreCookie]))
    {
        if($objeto->exito)
        {
            $hora = date("G") . date("i") . date("s");
            setcookie($nombreCookie,$hora . $objeto->mensaje);
    
            $rta->exito=true;
            $rta->mensaje = "Se verifico el producto con exito y se seteo la cookie";
        }
    }
    else
    {
        $rta->mensaje = "Ya esta creada la cookie";
    }
 
    echo json_encode($rta);

?>