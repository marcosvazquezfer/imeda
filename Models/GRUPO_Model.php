<?php
/**
 * Modelo que accede a la base de datos para gestionar los grupos
 * Created by PhpStorm.
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 28/11/2017
 * Fecha fin:28/11/2017
 */
class GRUPO_Model { //declaración de la clase

    var $IdGrupo; // declaración del atributo login
    var $NombreGrupo; // declaración del atributo DNI
    var $DescripGrupo; // declaración del atributo password
    var $mysqli; // declaración del atributo manejador de la bd


//Constructor de la clase
    function __construct($IdGrupo, $NombreGrupo, $DescripGrupo){

        //asignación de valores de parámetro a los atributos de la clase
        $this->IdGrupo = $IdGrupo;
        $this->NombreGrupo = $NombreGrupo;
        $this->DescripGrupo = $DescripGrupo;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor


//Método ADD()
//Inserta en la tabla  de la bd  los valores de los atributos del objeto. Comprueba si la clave/s esta vacia y si
//existe ya en la tabla
    function ADD()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

        if (($this->IdGrupo <> '')){ // si el atributo clave de la entidad no esta vacio

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `GRUPO` WHERE (IdGrupo = '$this->IdGrupo')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `GRUPO` (`IdGrupo`,`NombreGrupo`, `DescripGrupo`) 
				VALUES ('".$this->IdGrupo."','".$this->NombreGrupo."', '".$this->DescripGrupo."');";

                    if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
                            return 'Unknowed Error';

                    }
                    else{ //si no da error en la insercion devolvemos mensaje de éxito
                        return 'Success insert'; //operacion de insertado correcta
                    }

                }
                else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
                    return 'It is already in DB'; // ya existe
            }
        }
        else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
            return 'Introduce a value'; // introduzca un valor para el usuario
        }
    } // fin del metodo ADD


//funcion de destrucción del objeto: se ejecuta automaticamente
//al finalizar el script
    function __destruct()
    {

    } // fin del metodo destruct


//funcion AllData
//devuelve la tabla
    function AllData(){

        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de la variable resultado

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `GRUPO` ";
        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }//fin metodo AllData


//funcion SEARCH
// hace una búsqueda en la tabla con los datos proporcionados. Si van vacios devuelve todos
    function SEARCH()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql   

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `GRUPO`
				where IdGrupo LIKE '%".$this->IdGrupo."%' AND
						NombreGrupo LIKE '%".$this->NombreGrupo."%' AND
						DescripGrupo LIKE '%".$this->DescripGrupo."%'";
        
        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
         return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCH


// función DELETE
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
    function DELETE()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql    

        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `GRUPO` WHERE (IdGrupo = '".$this->IdGrupo."')";
        
        $result = $this->mysqli->query($sql); // se ejecuta la query
        
        if ($result->num_rows == 1) // si existe una tupla con ese valor de clave
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `GRUPO` WHERE (IdGrupo = '".$this->IdGrupo."')";
            
            $this->mysqli->query($sql); // se ejecuta la query
            
            return 'Correctly delete'; // se devuelve el mensaje de borrado correcto si se ejecuto correctamente
        } 
        else // si no existe el login a borrar 
            return 'It does not exist in DB'; //se devuelve el mensaje de que no existe
    } // fin metodo DELETE


// funcion RellenaDatos
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
    function RellenaDatos()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql 
        $result; //almacena el valor de la variable resultado

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT * FROM `GRUPO` WHERE IdGrupo = '".$this->IdGrupo."'";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB'; 
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin metodo RellenaDatos


// funcion EDIT
// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
// si existe se modifica
    function EDIT()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql 
        $resultado; //almacena la consulta sql

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `GRUPO` WHERE (IdGrupo = '".$this->IdGrupo."')";
        
        $result = $this->mysqli->query($sql); // se ejecuta la query

        if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
        {	
            // se construye la sentencia de modificacion en base a los atributos de la clase
            $sql = "UPDATE `GRUPO` SET 
					NombreGrupo = '".$this->NombreGrupo."',
					DescripGrupo = '".$this->DescripGrupo."'
				WHERE ( IdGrupo = '".$this->IdGrupo."'
				)";
            
            if (!($resultado = $this->mysqli->query($sql))){ // si hay un problema con la query se envia un mensaje de error en la modificacion
                return 'Unknowed Error';
            }
            else{ // si no hay problemas con la modificación se indica que se ha modificado
                return 'Success Modify';
            }
        }
        else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
            return 'It does not exist in DB';
    } // fin del metodo EDIT


}//fin de clase

?>