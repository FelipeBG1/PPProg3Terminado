<?php

    require_once "./clases/ProductoEnvasado.php";
    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;
    $sinParametros = isset($_GET["sinParametros"]) ? $_GET["sinParametros"] : 0;

    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "No se pudo eliminar el producto";

    if($sinParametros != "Si")
    {
        if($producto_json != 0)
        {
            $producto = json_decode($producto_json);
            $productoBorrar = new ProductoEnvasado($producto->id,$producto->nombre,$producto->origen,$producto->codigoBarra,$producto->precio,$producto->pathFoto);
            
            if(ProductoEnvasado::Eliminar($producto->id))
            {
                $productoBorrar->GuardarEnArchivo();
                $obj->exito = true;
                $obj->mensaje = "Se elimino el producto con exito";
    
            }
        }
        echo json_encode($obj);
    }
    else
    {
            echo "<table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    CODIGO_BARRA
                </td>
                <td>
                    NOMBRE
                </td>
                <td>
                    ORIGEN
                </td>
                <td>
                    PRECIO
                </td>
                <td>
                    FOTO
                </td>
            </tr>";
            
            $nombreArchivo = "./archivos/productos_envasados_borrados.txt";
            if(file_exists($nombreArchivo))
            {
                $archivo = fopen($nombreArchivo,"r");
                
                if(filesize($nombreArchivo))
                {
                    while (!feof($archivo)){
                    
                        $linea = fgets($archivo);
                        $linea = is_string($linea) ? trim($linea) : false;
                        $array = explode(" - ",$linea);
                        echo "<tr>
                            <td>
                                $array[0];
                            </td>
                            <td>
                                $array[1];
                            </td>
                            <td>
                                $array[2];
                            </td>
                            <td>
                                $array[3]
                            </td>
                            <td>
                                $array[4]
                            </td>
                            <td>
                                <img src=$array[5] alt=fotoProducto width=50px height=50px>
                            </td>
                        </tr>";
    
                    }
                   
                }
                 fclose($archivo); 
            }    
        
    }

    
    
 
    
?>