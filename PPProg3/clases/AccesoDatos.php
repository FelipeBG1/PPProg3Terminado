<?php
class AccesoDatos{

    private static $objetoAccesoDatos;
    private $objetoPDO;

    public function __construct()
    {
        try
        {
            $user = 'root';
            $pass = "";
            $this->objetoPDO = new PDO('mysql:host=localhost; dbname=productos_bd', $user, $pass);
                    
        }
        catch(PDOException $e)
        {
            echo "Error " . $e->getMessage();
        }
    }


    public function RetornarConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }

    public static function DameUnObjetoAcceso()
    {
        if (!isset(self::$objetoAccesoDatos)) {       
            
            self::$objetoAccesoDatos = new AccesoDatos(); 
        }
 
        return self::$objetoAccesoDatos;        
    }

    public function __clone()
    {
        trigger_error('La clonacion de este objeto no esta; permitida!', E_USER_ERROR);
    }
    
}