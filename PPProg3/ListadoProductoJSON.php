<?php

    require_once ("./clases/Producto.php"); 
    
    $array = Producto::TraerJSON();

    echo json_encode($array);
?>