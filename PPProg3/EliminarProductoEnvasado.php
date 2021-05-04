<?php
    require_once "./clases/ProductoEnvasado.php";
    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;

    if($producto_json != 0)
    {
        $obj = new stdClass();
          
        $producto = json_decode($producto_json);

        $productoEnvasado = new ProductoEnvasado($producto->id,$producto->nombre,$producto->origen);
        
        
        if(ProductoEnvasado::Eliminar($producto->id))
        {
            $objeto = json_decode($productoEnvasado->GuardarJSON("./archivos/productos_eliminados.json"));
            if(!$objeto->exito)
            {
                $obj->exito=false;
                $obj->mensaje = "Se elimino el producto de al base de datos pero no se pudo guardar el producto eliminado en el archivo";
            }
            else
            {
                $obj->exito=true;
                $obj->mensaje = "Se elimino el producto de al base de datos y se guardo el producto eliminado en el archivo";
            }
        }
        else
        {
            $obj->exito=false;
            $obj->mensaje = "No se pudo eliminar el producto de la base de datos";
        }


        echo json_encode($obj);
    }

?>