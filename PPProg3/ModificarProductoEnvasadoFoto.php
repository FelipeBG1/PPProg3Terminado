<?php

    require_once "./clases/ProductoEnvasado.php";
    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "No se pudo modificar el producto"; 
    $pathFoto = "";

    if($producto_json != 0)
    {
        $producto = json_decode($producto_json);

        foreach(ProductoEnvasado::Traer() as $item)
        {
            if($item->id == $producto->id)
            {
                $pathFoto = $item->foto;
                $nombre = $item->nombre;
                $origen = $item->origen;
                break;
            }
        }

        $productoModificar = new ProductoEnvasado($producto->id,$producto->nombre,$producto->origen,$producto->codigoBarra,$producto->precio,"");
        
        if(getimagesize($foto["tmp_name"]) != FALSE)
        {
            $tipo = pathinfo($foto["name"],PATHINFO_EXTENSION);
            $destinoFoto = "./productos/imagenes/";
            $hora = date("G") . date("i") . date("s");
            $nombreFoto = "{$productoModificar->id}.{$productoModificar->nombre}.{$hora}.{$tipo}";

            $destinoFoto .= $nombreFoto;

            if($tipo == "jpg" || $tipo == "bmp" || $tipo == "gif" || $tipo== "png" || $tipo == "jpeg")
            {                  
                move_uploaded_file($foto["tmp_name"],$destinoFoto);     
            }             
        }

        $productoModificar->pathFoto = $destinoFoto;


        if($productoModificar->Modificar())
        {
            $array = explode(".",$pathFoto);
            $nuevoNombre = "{$nombre}.{$origen}.modificado.{$array[3]}.{$tipo}";
            $destinoFoto2 = "./productosModificados/";
            $destinoFoto2 .= $nuevoNombre;
                     
            if($pathFoto != "")
            {
                copy($productoModificar->pathFoto,$destinoFoto2);
                unlink($pathFoto);
                $obj->exito = true;
                $obj->mensaje = "Se modifico el producto con exito";

            }
            
        }
    }

    echo json_encode($obj);
?>