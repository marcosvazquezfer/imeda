<?php
/**
 * Modelo que accede a la base de datos para gestionar acciones a funcionalidades
 * Autor: Ruben -Grupo Imeda
 * Fecha inicio: 02/12/2017
 */

class FUNC_ACCION_Model { //declaración de la clase

    var $IdFuncionalidad; // declaración del atributo idFuncionalidad
    var $IdAccion; // declaración del atributo IdAccion
    var $mysqli;  //declaracion de la variable mysqli


//Constructor de la clase
    function __construct($IdFuncionalidad, $IdAccion){

        //asignación de valores de parámetro a los atributos de la clase
        $this->IdFuncionalidad = $IdFuncionalidad;
        $this->IdAccion = $IdAccion;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor


//Método ADD
//Inserta en la tabla  de la bd  los valores de los atributos del objeto. 
//Comprueba si la clave/s esta vacia y si existe ya en la tabla
    function ADD()
    {

        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

        if (($this->IdFuncionalidad <> '')&&($this->IdAccion <> '')){ // si el atributo clave de la entidad no esta vacio

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '$this->IdFuncionalidad') AND (IdAccion = '$this->IdAccion')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `FUNC_ACCION` (`IdFuncionalidad`,`IdAccion`) 
				VALUES ('".$this->IdFuncionalidad."','".$this->IdAccion."');";

                    if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert 
                        return 'Unknowed Error'; //devolvemos mensaje
                    }
                    else{ //si no da error en la insercion 
                        return 'Success insert'; //devolvemos mensaje de que la insercción se ha realizado correctamente
                    }
                }
                else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
                    return 'It is already in DB'; // devolvemos un mensaje que indique que ya existe
            }
        }
        else{ // si el atributo clave de la bd es vacio 
            return 'Introduce a value'; //solicitamos que se introduzca un valor para el usuario
        }
    } // fin del metodo ADD


//funcion de destrucción del objeto: se ejecuta automaticamente al finalizar el script
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
        $sql = "SELECT * FROM `FUNC_ACCION` ";
        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } //fin metodo AllData


//funcion SEARCH
// hace una búsqueda en la tabla con los datos proporcionados. Si van vacios devuelve todos
    function SEARCH()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `FUNC_ACCION`
				where IdFuncionalidad LIKE '%".$this->IdFuncionalidad."%' AND
						IdAccion LIKE '%".$this->IdAccion."%' ";

        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCH


//funcion SEARCHNOMFUN
// hace una búsqueda en la tabla
    function SEARCHNOMFUN()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT *
       			from `FUNCIONALIDAD`";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCHNOMFUN


//funcion SEARCHNOMBRES
// hace una búsqueda en la tabla con los datos proporcionados
    function SEARCHNOMBRES($funcionalidad)
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        // construimos la sentencia sql
        $sql = "SELECT ACCION.NombreAccion
       			FROM `FUNC_ACCION`,`ACCION`,`FUNCIONALIDAD`
				WHERE FUNCIONALIDAD.NombreFuncionalidad = '".$funcionalidad."'  AND FUNC_ACCION.IdAccion = ACCION.IdAccion  AND FUNC_ACCION.IdFuncionalidad=FUNCIONALIDAD.IdFuncionalidad";

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
        $sql = "SELECT * FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."') AND (IdAccion = '".$this->IdAccion."')";
        
        $result = $this->mysqli->query($sql);// se ejecuta la query
        
        if ($result->num_rows == 1) // si existe una tupla con ese valor de clave
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."') AND (IdAccion = '".$this->IdAccion."') ";
            
            $this->mysqli->query($sql);// se ejecuta la query
            
            return 'Correctly delete'; // se devuelve el mensaje de borrado correcto
        } 
        else // si no existe el login a borrar se devuelve el mensaje de que no existe

            return 'It does not exist in DB';
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
        $sql = "SELECT * FROM `FUNC_ACCION` WHERE IdFuncionalidad = '".$this->IdFuncionalidad."'";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB'; //
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos


}//fin de clase

