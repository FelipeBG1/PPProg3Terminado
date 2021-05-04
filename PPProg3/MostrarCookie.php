<?php

    $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : 0;
    $origen = isset($_GET["origen"]) ? $_GET["origen"] : 0;  
    
    $nombreCookie = $nombre . "_" . $origen;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se encontro eninguna cookie con ese nombre";

    if(isset($_COOKIE[$nombreCookie]))
    {
        $rta->bool = true;
        $rta->mensaje = "Se encontro una cookie, valor de al cookie: " . $_COOKIE[$nombreCookie] . " ";
    }

    echo json_encode($rta);
?>