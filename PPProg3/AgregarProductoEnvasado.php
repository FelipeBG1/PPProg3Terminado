<?php

    require_once "./clases/ProductoEnvasado.php";
    $codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : 0;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : 0;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $array = ProductoEnvasado::Traer();
    $producto = new ProductoEnvasado(0,$nombre,$origen,$codigoBarra,$precio,"");

    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "No se pudo agregar el producto a la basa de datos";
    
    if($producto->Existe($array))
    {
        $obj->exito = false;
        $obj->mensaje = "No se pudo agregar el producto a la basa de datos porque ya existe";
    }
    else
    {
        if(getimagesize($foto["tmp_name"]) != FALSE)
        {
            $destino = $foto["name"];
            $tipo = pathinfo($destino,PATHINFO_EXTENSION);
            $hora = date("G") . date("i") . date("s");
            $destino = "./productos/imagenes/" . $nombre . "." . $origen . ".". $hora . "." . $tipo;
    
            if($tipo == "jpg" || $tipo == "bmp" || $tipo == "gif" || $tipo== "png" || $tipo == "jpeg")
            {
                if($foto["size"] <= 1000000)
                {
                    move_uploaded_file($foto["tmp_name"],$destino);
                    $flag = true;
                }
            }
        }

        $producto->pathFoto = $destino;
        
        if($producto->Agregar())
        {
            $obj->exito = true;
            $obj->mensaje = "Se agrego el producto a la basa de datos con exito";
        }
    }

    echo json_encode($obj);

?>