<?php

    require_once "./clases/Producto.php";
    require_once "./clases/IParte1.php";
    require_once "./clases/IParte2.php";
    require_once "./clases/IParte3.php";
    require_once "./clases/AccesoDatos.php";

    class ProductoEnvasado extends Producto implements IParte1 ,IParte2, IParte3{

        public $id;
        public $codigoBarra;
        public $precio;
        public $pathFoto;

        public function __construct($id = 0, $nombre, $origen,$codigoBarra = 0, $precio = 0, $pathFoto = "",)
        {
            $this->id = $id;
            $this->codigoBarra = $codigoBarra;
            $this->precio = $precio;
            $this->pathFoto = $pathFoto;
            parent::__construct($nombre,$origen);
            
        }

        public function ToJSON ()
        {           
            $objeto = new stdClass();
            $objeto->id = $this->id;
            $objeto->codigoBarra = $this->codigoBarra;
            $objeto->precio = $this->precio;  
            $objeto->pathFoto = $this->pathFoto;
            $objeto->nombre = $this->nombre;
            $objeto->origen = $this->origen;            

            return json_encode($objeto);
        }

        public function Agregar()
        {
            $retorno = false;
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) VALUES (:codigo_barra,:nombre,:origen,:precio,:foto)");

            $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();
            
            if($consulta->rowCount() == 1)
            {
                $retorno = true;            
            }

            return $retorno;
        }

        public static function Traer()
        {    
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos");        
            
            try
            {
                $consulta->execute();
            
                return $consulta->fetchAll(PDO::FETCH_OBJ);  
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
                    
        }

        public static function Eliminar($id)
        {
            $retorno = false;
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id = :id");
        
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            try{
                $consulta->execute();
    
                if($consulta->rowCount() == 1)
                {
                    $retorno = true;            
                }
    
                return $retorno;
            }
            catch(PDOException $e)
            {
                echo "Error" . $e->getMessage();
            }
        }


        public function Modificar()
        {
            $retorno = false;
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        

            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, 
                                                            codigo_barra = :codigo_barra, precio = :precio, foto = :foto WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
    
            try{
                $consulta->execute();
    
                if($consulta->rowCount() == 1)
                {
                    $retorno = true;            
                }
    
                return $retorno;
            }
            catch(PDOException $e)
            {
                echo "Error" . $e->getMessage();
            }
        }

        public function Existe($array)
        {
            $finded = false;
            
            foreach($array as $item)
            {
                if($item->nombre == $this->nombre && $item->origen == $this->origen)
                {
                    $finded = true;
                }
            }

            return $finded;
        }

        public function GuardarEnArchivo()
        {
            $nombreArchivo = "./archivos/productos_envasados_borrados.txt";
            $destinoFoto = "./productosBorrados/";
            $archivo = fopen($nombreArchivo,"a");
            $datosGuardar = $this->id . " - " . $this->nombre . " - " . $this->origen . " - " . $this->codigoBarra . " - ". $this->precio . " - " . $this->pathFoto;

            $flag = false;
            if(fwrite($archivo,$datosGuardar))
            {
                $array = explode(".",$this->pathFoto);
                $tipo = pathinfo($this->pathFoto,PATHINFO_EXTENSION);
                $hora = date("G") . date("i") . date("s");
                $nombreFoto = "{$this->id}.{$this->nombre}.borrado.{$hora}.{$tipo}";

                $destinoFoto .= $nombreFoto;

                copy($this->pathFoto,$destinoFoto);
                unlink($this->pathFoto);

            }
        }

    }
?>