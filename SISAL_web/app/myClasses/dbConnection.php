<?php
/*
    Clase para la conexión con la base de datos
*/
class BaseDeDatos {
    
    private $DBCon;
    /**
     * Constructor de la clase
     * Genera y abre la conexión con la base de datos mediante PHP_ROUND_HALF_DOWN
     * En caso de error genera una exepción y la muestra mediante echo
     */
    public function __construct()
    {
        //CADENA DE CONEXION PDO(localhost,nombre de la bd, usuario, contraseña)
        try
        {
            $name = "";
            $user = "";
            $password = "";
            $this->DBCon = new PDO('mysql:host=localhost; dbname='.$name, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
            $DBCon->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
     }

    
   }