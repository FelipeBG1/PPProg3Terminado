<?php

    class Producto{
        
        public $nombre;
        public $origen;

        public function __construct($nombre,$origen)
        {
            $this->nombre = $nombre;
            $this->origen = $origen;         
        }

        public function ToJSON ()
        {           
            $objeto = new stdClass();
            $objeto->nombre = $this->nombre;
            $objeto->origen = $this->origen;           

            return json_encode($objeto);
        }

        public function GuardarJSON($path)
        {
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "Hubo un error al guardar en el archivo";
        
                if(file_exists($path))
                {
                    $aux1 = fopen($path,"r");

                    $aux = fread($aux1, filesize($path));

                    fclose($aux1);

                    $archivo = fopen($path,"w");
                }
                else
                {
                    $archivo = fopen($path,"a");
                }
                

                if(filesize($path) == 0)
                {
                    if(fwrite($archivo, "[". $this->ToJSON() . "]") != 0)
                    {
                        $obj->exito = true;
                        $obj->mensaje = "Se pudo guardar en el archivo";
                        $json = json_encode($obj);
                    }

                    fclose($archivo);
                }
                else
                {

                    $lectura = explode("]", $aux);

                        if(fwrite($archivo, $lectura[0] . "," . $this->ToJSON() . "]") != 0)
                        {
                            $obj->exito = true;
                            $obj->mensaje = "Se pudo guardar en el archivo";
                            $json = json_encode($obj);
                        }

                        fclose($archivo);

                }
            return $json;
        }






        /*
        public function GuardarJSON($path)
        {
            $obj =  new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo guardar el producto en el archivo";

            $array = $this->TraerJSON();

            $aux = new stdClass();
            $aux->nombre = $this->nombre;
            $aux->origen = $this->origen;

            array_push($array,$aux);
            $jsonEncode = json_encode($array);

            $archivo = fopen($path,"w");

            if(fwrite($archivo,$jsonEncode))
            {
                $obj->exito = true;
                $obj->mensaje = "Se agrego el producto con exito";
            }

            return json_encode($obj);
        }
        */
        public static function TraerJSON()
        {
            $nombreArchivo = "archivos/productos.json";
            $array = [];
  
            if(file_exists($nombreArchivo))
            {
                $archivo = fopen($nombreArchivo,"r");

                $json = fread($archivo, filesize($nombreArchivo));
                $array[] = json_decode($json);      
                fclose($archivo);  
        
            }
            
            return $array;    
        }

        public static function VerificarProductoJSON($producto)
        {
           $productosArray = Producto::TraerJSON();
           $arr = [];
           $contador = 0;
           $flag = false;

           $pMayor = 0;
           $nombrePMayor = "";

           $obj = new stdClass();
           $obj->exito = false;
           $obj->mensaje = "No se encontro el producto";

           foreach($productosArray[0] as $item)
           {
                if($item->origen == $producto->origen)
                {
                    $contador++;
                    if($item->nombre == $producto->nombre)
                    {
                        $flag = true;                      
                    }
                }

                array_push($arr, $item->nombre);
           }

           if($flag)
           {
               $obj->exito = true;
               $obj->mensaje = "La cantidad de productos de origen " . $producto->origen . " " . "es " . $contador;
           }
           else
           {
                $arrNombre = array_count_values($arr);

                foreach($arrNombre as $i => $item)
                {
                    $pMayor = $item;
                    $nombrePMayor = $i;

                    if($pMayor < $item)
                    {
                        $arrNombre[$i]->item = $pMayor;
                        $nombrePMayor = $i;
                    }
                }

                $obj->mensaje = "El producto mas popular es '$nombrePMayor', se repite '$pMayor' veces.";
           }

           return json_encode($obj);
        }   

    }
?>