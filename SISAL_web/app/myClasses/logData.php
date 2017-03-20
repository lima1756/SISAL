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
         * variable type
         * Almacena el tipo de usuario que accede
         * @var string
         */
        private static $type;

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
            $connect = new dbConnection();
            if(sizeof(self::$data)==0)
            {
                if(isset($_SESSION['authData']))
                {
                    self::$data = $_SESSION['authData'];
                    self::$type = $_SESSION['authType'];
                    return true;
                }
                if(isset($_COOKIE['sessionKey']))
                {
                    self::$data = $connect->select(["*"], "usuarios", [["sessionKey", $_COOKIE['sessionKey']]]);
                    if(sizeof($connect->select(["*"], "medicos", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                    {
                        self::$type = "medicos";
                    }
                    elseif(sizeof($connect->select(["*"], "recepcionistas", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                    {
                        self::$type = "recepcionistas";
                    }
                    elseif(sizeof($connect->select(["*"], "pacientes", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                    {
                        self::$type = "pacientes";
                    }
                    elseif(sizeof($connect->select(["*"], "administradores", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                    {
                        self::$type = "administradores";
                    }
                    return true;
                }
            }
            else
            {
                return true;
            }
            return false;
        }

        /**
         * logIn function
         * Funcion para generar el logIn, en caso que se obtengan los datos correctamente se regresa un true señalando que fue correcto
         * En caso contrario regresa un false indicando que no se realizo el logIn correctamente
         * La contraseña que se recibe se hashea para ser comparada con la contraseña ya hasheada en la base de datos.
         * @param string $name usuario o correo para el inicio de sesión
         * @param string $pass contraseña para el inicio de sesión
         * @param boolean $stay Este campo lo que hace es que si se recibe en true almacenara en la base de datos una llave y 
         *          la guardara en una cookie para que si vuelve a acceder se obtengan los datos automaticamente a partir de esa cookie.
         * @return void
         */
        public static function logIn($name, $pass, $stay = false)
        {
            $cipher_pass = hash("sha256", $pass);
            $connect = new dbConnection();
            $obtainedData = $connect->select(["*"], "usuarios", [["usuario", $name],["pass", $cipher_pass]]);
            if(sizeof($obtainedData) == 0)
                $obtainedData = $connect->select(["*"], "usuarios", [["email", $name],["pass", $cipher_pass]]);
            self::$data = $obtainedData;                
            if(sizeof(self::$data)!=0)
            {
                if(sizeof($connect->select(["*"], "medicos", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                {
                    self::$type = "medicos";
                    
                }
                elseif(sizeof($connect->select(["*"], "recepcionistas", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                {
                    self::$type = "recepcionistas";
                }
                elseif(sizeof($connect->select(["*"], "pacientes", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                {
                    self::$type = "pacientes";
                }
                elseif(sizeof($connect->select(["*"], "administradores", [["id_usuario", self::$data[0]['id_usuario']]]))>0)
                {
                    self::$type = "administradores";
                }
                else
                {
                    self::$type = "";
                    self::$data = array();
                    return false;
                }
                if($stay)
                {
                    $tiempo = getdate();
                    $key = "";
                    foreach($tiempo as $v)
                    {
                        $key .= $v;
                    }
                    foreach(self::$data[0] as $v)
                    {
                        $key .= $v;
                    }
                    $cipherKey = hash("sha256", $key);
                    $connect->update("usuarios", ["sessionKey"], [[$cipherKey]], [["id_usuario", self::$data[0]['id_usuario']]]);
                    setcookie("sessionKey", $cipherKey, time()+3600*3600*10, "/");
                }
                $_SESSION['authData'] = self::$data;
                $_SESSION['authType'] = self::$type;
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * getData
         * Este método obtiene el dato solicitado de los datos ya almacenados.
         * @param [type] $columna
         * @return string: Regresa el dato solicitado o en caso de no existir regresa un string con tal aclaración
         */
        public static function getData($columna)
        {
            if(sizeof(self::$data)!=0 || self::retrieveSession())
            {
                if(isset(self::$data[0][$columna]))
                {
                    return self::$data[0][$columna];   
                }
            }
                return "No existe tal valor";
        }
        

        public function __clone()
        {
            trigger_error("Operación Invalida: No puedes clonar una instancia de ". get_class($this) ." class.", E_USER_ERROR );
        }
    }