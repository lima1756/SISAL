<?php

    namespace App\myClasses;
    use PDO;

    /**
     * Clase para la conexión con la base de datos
     */ 
    class dbConnection {
        /**
         * Propiedad que almacena la conexión con la base de datos
         * 
         * @var PDO $DBCon
         */        
        private static $DBCon = "";
        
        
        /**
         * Constructor de la clase
         * Llama a la creación de la instancia.
         * @return boolean regresa el valor devuelto por la creación de la instancia
         */
        private function __construct()
        {
            return self::createInstance();
        }

        /**
         * createInstance
         * Crea la instancia para la conexión con la base de datos
         * @return boolean regresa verdadero si ya existe la conexión PDO o si fue creada exitosamente
         */
        private static function createInstance()
        {
            if(!is_a(self::$DBCon, "PDO"))
            {
                try
                {
                    $name = "SISAL";
                    $user = "root";
                    $password = "";
                    self::$DBCon = new PDO('mysql:host=localhost; dbname='.$name, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
                    self::$DBCon->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                    return true;
                }
                catch(PDOException $e)
                {
                    echo $e->getMessage();
                    return false;
                }
            }
            return true;
        }
        /**
         * select: Función para generar SELECTS para la base de datos
         * 
         * @param array $valores  Este es un array de los campos que se obtendran con el SELECT.
         * ej:
         *     ["columna1", "columna2", "columna3"]
         * @param string $tabla  Este es el nombre de la tabla sobre la que se realizara el SELECT
         * @param array $where  Este es un array de arrays para realizar el WHERE de la consulta
         * ej:
         *      [["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica"], 
         *          ["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica", OPCIONAL: "Union con el WHERE ej: AND, OR, etc"]]
         * @param array $joins  Este es un array de arrays para realizar inner JOINS en la consulta
         * ej:
         *      [["nombreTabla", "valor 1 a comparar en el ON", "Valor 2 a comparar en el ON", OPCIONAL: "Operación logica a hacer en el ON"]]
         * @param string $extra  Este string es el añadido como para ordenar o limitar la sentencia
         * @return void
         */ 
        public static function select(array $valores, $tabla, array $where = [], array $joins = [], $extra = null)
        {
            if(self::createInstance())
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
                                $query = $query . " WHERE " . $where[$x][0] . " = " . "?";
                                array_push($data, $where[$x][1]);
                            }
                            elseif(count($where[$x])==3)
                            {
                                $query = $query . " WHERE " . $where[$x][0] . $where[$x][2] . "?";
                                array_push($data, $where[$x][1]);
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
                                $query = $query . " AND " . $where[$x][0] . " = " . "?";
                                array_push($data, $where[$x][1]);
                            }
                            elseif(count($where[$x])==3)
                            {
                                $query = $query . " AND " . $where[$x][0] . $where[$x][2] . "?";
                                array_push($data, $where[$x][1]);

                            }
                            elseif(count($where[$x])==4)
                            {
                                $query = $query . " " . $where[$x][3] . " " . $where[$x][0] . $where[$x][2] . "?";
                                array_push($data, $where[$x][1]);
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
                    $select = self::$DBCon->prepare($query);
                    $select->execute($data);
                    $answer = $select->fetchAll(PDO::FETCH_ASSOC);
                    return $answer;
                }
                catch(PDOException $e)
                {
                    return $e->getMessage();
                }
            }
            
        }

        
        /**
         * insert: Funcion para generar INSERTS en la base de datos
         * 
         * @param string $tabla  Este es el nombre de la tabla sobre la que se realizara el INSERT
         * @param array $campos  Este es un array de los campos sobre los que se hara el INSERT.
         * ej:
         *      ["columna1", "columna2", "columna3"]
         * @param array $datos   Este es un array de arrays que contiene los datos que se agregaran a la base de datos
         * ej:
         *      [["valorDato Columna1", "valorDato Columna2", valorDato Columan3]]
         * @return void
         *  
         */ 
        public static function insert($tabla, array $campos, array $datos)
        {
            if(self::createInstance())
            {
                $query = "INSERT INTO " . $tabla . " (";
                $countCampos = count($campos);
                $countDatos = count($datos);
                $data = [];
                
                for($x = 0; $x < $countCampos; $x++)
                {
                    if($x == $countCampos-1)
                    {
                        $query = $query . $campos[$x] . ") ";
                    }
                    else
                    {
                        $query = $query . $campos[$x] . ", ";
                    }
                }
                $query = $query . "VALUES ";
                if($countDatos>1)
                {
                    
                    for($x = 0; $x < $countDatos; $x++)
                    {
                        
                        $query = $query . " (" ;
                        $countDato = count($datos[$x]);
                        if($countDato == $countCampos)
                        {
                            if($x == $countDatos-1)
                            {
                                for($y = 0; $y < $countDato; $y++)
                                {
                                    if($y == $countDato-1)
                                    {
                                        $query = $query . "?" . ");";
                                        array_push($data, $datos[$x][$y]);
                                    }
                                    else
                                    {
                                        $query = $query . "?" . ", ";
                                        array_push($data, $datos[$x][$y]);
                                    }
                                }
                            }
                            else
                            {
                                for($y = 0; $y < $countDato; $y++)
                                {
                                    if($y == $countDato-1)
                                    {
                                        $query = $query . "?" . "), ";
                                        array_push($data, $datos[$x][$y]);
                                    }
                                    else
                                    {
                                        $query = $query . "?" . ", ";
                                        array_push($data, $datos[$x][$y]);
                                    }
                                }
                            }
                        }
                        else
                        {
                            
                            return "ERROR campos no corresponden con datos";
                            
                        }
                    }
                }
                else
                {
                    $query = $query . " (";
                    $countDato = count($datos[0]);
                    if($countDato == $countCampos)
                    {
                        for($y = 0; $y < $countDato; $y++)
                        {
                            if($y == $countDato-1)
                            {
                                $query = $query . "?" . ");";
                                array_push($data, $datos[0][$y]);
                            }
                            else
                            {
                                $query = $query . "?" . ", ";
                                array_push($data, $datos[0][$y]);
                            }
                        }
                    }
                    else
                    {
                        return "ERROR campos no corresponden con datos";
                    }
                }
                try
                {
                    var_dump($query);
                    var_dump($data);
                    $insert = self::$DBCon->prepare($query);
                    
                    $insert->execute($data);
                    return 1;
                }
                catch(PDOException $e)
                {
                    return $e->getMessage();
                }
            }
        }

        /**
         * update: Funcion para generar UPDATES en la base de datos
         * 
         * @param string $tabla  Este es el nombre de la tabla sobre la que se realizara el UPDATE
         * @param array $campos  Este es un array de los campos sobre los que se hara el UPDATE.
         * ej:
         *      ["columna1", "columna2", "columna3"]
         * @param array $datos   Este es un array de arrays que contiene los datos por los que seran sustituidos los de la base de datos
         * ej:
         *      ["valorDato Columna1", "valorDato Columna2", valorDato Columan3]
         * @param array $where  Este es un array de arrays para realizar el WHERE del update
         * ej:
         *      [["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica"], 
         *          ["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica", OPCIONAL: "Union con el WHERE ej: AND, OR, etc"]]
         * @return void
         */ 
        public static function update($tabla, array $campos, array $datos, array $where)
        {
            if(self::createInstance())
            {
                $data = [];
                $countCampos = count($campos);
                $countDatos = count($datos);
                $countWhere = count($where);
                $query = "UPDATE " . $tabla . " SET ";
                if($countCampos != $countDatos)
                {
                    return "ERROR, campos a editar diferente que datos";
                }
                else
                {
                    for($x = 0; $x < $countCampos; $x++)
                    {
                        if($x == $countCampos-1)
                        {
                            $query = $query . $campos[$x] . " = ? "; 
                        }
                        else
                        {
                            $query = $query . $campos[$x] . " = ?, "; 
                        }
                        array_push($data, $datos[$x]);
                    }
                    if($countWhere > 0)
                    {
                        for($x = 0; $x < $countWhere; $x++)
                        {
                            
                            if($x==0)
                            {
                                if(count($where[$x])==2)
                                {
                                    $query = $query . " WHERE " . $where[$x][0] . " = " . "?";
                                }
                                elseif(count($where[$x])==3)
                                {
                                    
                                    $query = $query . " WHERE " . $where[$x][0] . $where[$x][2] . "?";
                                }
                                else
                                {
                                    $query = null;
                                    echo "ERROR WHERE values incorrect";
                                    return -1;
                                }
                            }
                            else
                            {
                                if(count($where[$x])==2)
                                {
                                    $query = $query . " AND " . $where[$x][0] . " = " . "?";
                                }
                                elseif(count($where[$x])==3)
                                {
                                    $query = $query . " AND " . $where[$x][0] . $where[$x][2] . "?";

                                }
                                elseif(count($where[$x])==4)
                                {
                                    $query = $query . " " . $where[$x][3] . " " . $where[$x][0] . $where[$x][2] . "?";
                                }
                                else
                                {
                                    $query = null;
                                    echo "ERROR Where values incorrect";
                                    return -1;
                                }
                            }
                            array_push($data, $where[$x][1]);
                            
                        }
                    }
                    
                    try
                    {
                        $insert = self::$DBCon->prepare($query);
                        $insert->execute($data);
                        return 1;
                    }
                    catch(PDOException $e)
                    {
                        return $e->getMessage();
                    }
                }
            }
        }
        
        /**
         * delete: Funcion para generar DELETES en la base de datos
         * 
         * @param string $tabla  Este es el nombre de la tabla sobre la que se realizara el DELETE
         * @param array $where  Este es un array de arrays para realizar el WHERE del DELETE
         * ej:
         *      [["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica"], 
         *          ["campo o valor a comprar 1", "campo o valor a comprar 2", OPCIONAL: "operacion logica", OPCIONAL: "Union con el WHERE ej: AND, OR, etc"]]
         * @return void
         */ 
        public static function delete($tabla, array $where)
        {
            if(self::createInstance())
            {
                $data = [];
                $countWhere = count($where);
                $query = "DELETE FROM " . $tabla;
                if($countWhere > 0)
                {
                    for($x = 0; $x < $countWhere; $x++)
                    {
                        
                        if($x==0)
                        {
                            if(count($where[$x])==2)
                            {
                                $query = $query . " WHERE " . $where[$x][0] . " = " . "?";
                            }
                            elseif(count($where[$x])==3)
                            {
                                
                                $query = $query . " WHERE " . $where[$x][0] . $where[$x][2] . "?";
                            }
                            else
                            {
                                $query = null;
                                echo "ERROR WHERE values incorrect";
                                return -1;
                            }
                        }
                        else
                        {
                            if(count($where[$x])==2)
                            {
                                $query = $query . " AND " . $where[$x][0] . " = " . "?";
                            }
                            elseif(count($where[$x])==3)
                            {
                                $query = $query . " AND " . $where[$x][0] . $where[$x][2] . "?";

                            }
                            elseif(count($where[$x])==4)
                            {
                                $query = $query . " " . $where[$x][3] . " " . $where[$x][0] . $where[$x][2] . "?";
                            }
                            else
                            {
                                $query = null;
                                echo "ERROR Where values incorrect";
                                return -1;
                            }
                        }
                        array_push($data, $where[$x][1]);
                    }
                }
                else
                {
                    return "ERROR no puede haber un Delete sin WHERE";
                }
                try
                {
                    
                    $insert = self::$DBCon->prepare($query);
                    $insert->execute($data);
                    return 1;
                }
                catch(PDOException $e)
                {
                    return $e->getMessage();
                }
            }
        }
        
        /**
         * lastID
         * Esta función retorna el ultimo ID generado automaticamente en un insert
         * @return numeric
         */
        public static function lastID()
        {
            return self::$DBCon->lastInsertId();
        }
    }
