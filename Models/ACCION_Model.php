
<?php
/**
 * Modelo que accede a la base de datos para gestionar las acciones
 * Created by PhpStorm.
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 30/11/2017
 * Fecha fin:30/11/2017
 */
class ACCION_Model { //declaración de la clase

    var $IdAccion; // declaración del atributo IdAccion
    var $NombreAccion; // declaración del atributo NombreAccion
    var $DescripAccion; // declaración del atributo DescripAccion
    var $mysqli; // declaración del atributo manejador de la bd


//Constructor de la clase
    function __construct($IdAccion, $NombreAccion, $DescripAccion){

        //asignación de valores de parámetro a los atributos de la clase
        $this->IdAccion = $IdAccion;
        $this->NombreAccion = $NombreAccion;
        $this->DescripAccion = $DescripAccion;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor


//Método ADD()
//Inserta en la tabla de la bd los valores de los atributos del objeto. 
//Comprueba si la clave/s esta vacia y si existe ya en la tabla
    function ADD()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

        if (($this->IdAccion <> '')){ // si el atributo clave de la entidad no esta vacio

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `ACCION` WHERE (IdAccion = '$this->IdAccion')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `ACCION` (`IdAccion`,`NombreAccion`, `DescripAccion`) 
				VALUES ('".$this->IdAccion."','".$this->NombreAccion."', '".$this->DescripAccion."');";

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
        $result; //almacena el valor de resultado

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `ACCION` ";
        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB';
        }
        else{ // si existe
            $result = $resultado; //guarda en result el valor de resultado
            return $result; //muestra result
        }
    } //fin AllData


//funcion SEARCH:
// hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
    function SEARCH()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `ACCION`
				where IdAccion LIKE '%".$this->IdAccion."%' AND
						NombreAccion LIKE '%".$this->NombreAccion."%' AND
						DescripAccion LIKE '%".$this->DescripAccion."%'";
        // si se produce un error en la busqueda 
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB'; //mostramos el mensaje de error en la consulta

        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCH


// función DELETE():
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
    function DELETE()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `ACCION` WHERE (IdAccion = '".$this->IdAccion."')";
        // se ejecuta la query
        $result = $this->mysqli->query($sql);
        // si existe una tupla con ese valor de clave
        if ($result->num_rows == 1)
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `ACCION` WHERE (IdAccion = '".$this->IdAccion."')";
            // se ejecuta la query
            $this->mysqli->query($sql);
            // se devuelve el mensaje de borrado correcto
            return 'Correctly delete';
        } // si no existe el login a borrar se devuelve el mensaje de que no existe
        else

            return 'It does not exist in DB';
    } // fin metodo DELETE


// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
    function RellenaDatos()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de resultado

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT * FROM `ACCION` WHERE IdAccion = '".$this->IdAccion."'";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos()


// funcion EDIT()
// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria. Si existe se modifica
    function EDIT()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena el valor de una consulta sql
        $resultado; //almacena el valor de una consulta sql
        
        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `ACCION` WHERE (IdAccion = '".$this->IdAccion."')";
        // se ejecuta la query
        $result = $this->mysqli->query($sql);
        // si el numero de filas es igual a uno es que lo encuentra

        if ($result->num_rows == 1)
        {	// se construye la sentencia de modificacion en base a los atributos de la clase

            $sql = "UPDATE `ACCION` SET 
					NombreAccion = '".$this->NombreAccion."',
					DescripAccion = '".$this->DescripAccion."'
				WHERE ( IdAccion = '".$this->IdAccion."'
				)";
            // si hay un problema con la query se envia un mensaje de error en la modificacion
            if (!($resultado = $this->mysqli->query($sql))){
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