<?php

    namespace App\myClasses;
    use PDO;
    /*
        Clase para la conexión con la base de datos
    */
    class dbConnection {
        
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
                $name = "tech_service";
                $user = "root";
                $password = "";
                $this->DBCon = new PDO('mysql:host=localhost; dbname='.$name, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
                $this->DBCon->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        /**
         * select: Función para generar SELECTS para la base de datos
         * 
         * @param array $valores  Este es un array de los campos que se obtendran con el SELECT.
         * ej:
         *     ["columna1", "columna2", "columna3"]
         * @param string $tabla  Este es el nombre de la tabla sobre la que se realizara el SELECT
         * @param array $joins  Este es un array de arrays para realizar inner JOINS en la consulta
         * ej:
         *      [["nombreTabla", "valor 1 a comparar en el ON", "Valor 2 a comparar en el ON", OPCIONAL: "Operación logica a hacer en el ON"]]
         * @param array $where  Este es un array de arrays para realizar el WHERE de la consulta
         * ej:
         *      [["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica"], 
         *          ["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica", OPCIONAL: "Union con el WHERE ej: AND, OR, etc"]]
         * @param string $extra  Este string es el añadido como para ordenar o limitar la sentencia
         * @return void
         */ 
        public function select(array $valores, string $tabla, array $joins = [], array $where = [], string $extra = null)
        {
            $query = "SELECT ";
            $values = count($valores);
            $countJoins = count($joins);
            $countWhere = count($where);
            $countExtra = count($extra);
            $data = [];
            $answer = null;
            for($x = 0; $x < $values; $x++)
            {
                if($x != $values-1)
                {
                    $query = $query . $valores[$x] . ", ";
                }
                else
                {
                    $query = $query . $valores[$x];
                }
            }
            
            $query = $query . " FROM " . $tabla;
            if($countJoins > 0)
            {
                for($x = 0; $x < $countJoins; $x++)
                {
                    
                    if(count($joins[$x])==3)
                    {
                        $query = $query . " INNER JOIN " . $joins[$x][0] . " ON " . $joins[$x][1] . " = " . $joins[$x][2];
                    }
                    elseif(count($joins[$x])==4)
                    {
                        $query = $query . " INNER JOIN " . $joins[$x][0] . " ON " . $joins[$x][1] . $joins[$x][3] . $joins[$x][2];
                    }
                    else
                    {
                        $query = null;
                        echo "ERROR";
                        return -1;
                    }
                }
            }
            
            if($countWhere > 0)
            {
                for($x = 0; $x < $countWhere; $x++)
                {
                    if($x==0)
                    {
                        if(count($where[$x])==2)
                        {
                            $query = $query . " WHERE " . $where[$x][0] . " = " . $where[$x][1];
                        }
                        elseif(count($where[$x])==3)
                        {
                            $query = $query . " WHERE " . $where[$x][0] . $where[$x][2] . $where[$x][1];
                        }
                        else
                        {
                            $query = null;
                            echo "ERROR join values incorrect";
                            return -1;
                        }
                    }
                    else
                    {
                        if(count($where[$x])==2)
                        {
                            $query = $query . " AND " . $where[$x][0] . " = " . $where[$x][1];
                        }
                        elseif(count($where[$x])==3)
                        {
                            $query = $query . " AND " . $where[$x][0] . $where[$x][2] . $where[$x][1];

                        }
                        elseif(count($where[$x])==4)
                        {
                            $query = $query . " " . $where[$x][3] . " " . $where[$x][0] . $where[$x][2] . $where[$x][1];
                        }
                        else
                        {
                            $query = null;
                            echo "ERROR Where values incorrect";
                            return -1;
                        }
                    }
                
                }
            }
            if($countExtra>0)
            {
                $query = $query . " " . $extra;
            }
            
            $query = $query . ";";
            try
            {

                $select = $this->DBCon->prepare($query);
                $select->execute();
                $answer = $select->fetchAll(PDO::FETCH_ASSOC);
                return $answer;
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }

            
        }

        
        /**
         * Undocumented function
         * 
         * @param string $tabla
         * @param array $campos
         * @param array $datos
         * @return void
         */ 
        public function insert(string $tabla, array $campos, array $datos)
        {

        }

        public function update(string $tabla, array $campos, array $datos, array $where)
        {

        }

        public function delete(string $tabla, array $where)
        {

        }
        
        
    }
