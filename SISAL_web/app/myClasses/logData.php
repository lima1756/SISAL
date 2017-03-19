<?php
    namespace App\myClasses;
    use App\myClasses\dbConnection;
    session_start();
    /**
     * Clase que almacena y genera los datos de sesión
     */
    class logData
    {
        /**
         * variable data
         * Almacena el array de datos del usuario
         * @var array() 
         */
        private static $data;

        /**
         * Constructor
         * Al ser esta clase un "Singleton" el constructor es privado
         */
        private function __construct() {}

        /**
         * retrieveSession
         * Esta función sirve para verificar si ya tiene datos almacenados el array, en caso de
         * no tenerlos se revisa en los datos de sesión para recuperarlos
         * en caso de no existir regresa falso
         * @return boolean
         */
        private static function retrieveSession()
        {
            if(sizeof(self::$data)==0)
            {
                if(isset($_SESSION['authData']))
                {
                    self::$data = $_SESSION['authData'];
                    return true;
                }
            }
            else
            {
                return true;
            }
            return false;
        }

        public static function logIn($name, $pass, $stay = false)
        {
            $cipher_pass = hash("sha256", $pass);
            $connect = new dbConnection();
            if($stay)
            {
                $obtainedData = $connect->select(["*"], "usuarios", [["usuario", $name],["pass", $cipher_pass]]);
                if(sizeof($obtainedData) == 0)
                    $obtainedData = $connect->select(["*"], "usuarios", [["email", $name],["pass", $cipher_pass]]);
                self::$data = $obtainedData;
            }
            else
            {
                $obtainedData = $connect->select(["*"], "usuarios", [["usuario", $name],["pass", $cipher_pass]]);
                if(sizeof($obtainedData) == 0)
                    $obtainedData = $connect->select(["*"], "usuarios", [["email", $name],["pass", $cipher_pass]]);
                self::$data = $obtainedData;
            }
            if(sizeof(self::$data)!=0)
            {
                $_SESSION['authData'] = self::$data;
                return true;
            }
            else
            {
                return false;
            }
        }
        public static function getData($columna)
        {
            if(sizeof(self::$data)!=0 || self::retrieveSession())
                return self::$data[0][$columna];
            else
                return "No existe tal valor";
        }
        

        public function __clone()
        {
            trigger_error("Operación Invalida: No puedes clonar una instancia de ". get_class($this) ." class.", E_USER_ERROR );
        }
    }