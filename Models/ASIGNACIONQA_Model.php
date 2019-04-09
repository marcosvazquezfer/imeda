
<?php

/**
 * Modelo que accede a la base de datos para gestionar las funcionalidades
 * Autor: Ruben -Grupo Imeda
 * Fecha inicio: 27/11/2017
 */

class AsignacionQA_Model { //declaración de la clase

    var $IdTrabajo; // declaración del atributo IdTrabjo
    var $LoginEvaluador; // declaración del atributo LoginEvaluador
    var $LoginEvaluado; // declaración del atributo LoginEvaluado
    var $Alias; // declaración del atributo Alias
    var $mysqli; // declaración del atributo manejador de la bd


//Constructor de la clase
    function __construct($IdTrabajo, $LoginEvaluador,$LoginEvaluado,$Alias){

        //asignación de valores de parámetro a los atributos de la clase
        $this->IdTrabajo = $IdTrabajo;
        $this->LoginEvaluador = $LoginEvaluador;
        $this->LoginEvaluado = $LoginEvaluado;
        $this->Alias = $Alias;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor



//Metodo ADD()
//Inserta en la tabla de la bd los valores de los atributos del objeto. 
//Comprueba si la clave/s esta vacia y si existe ya en la tabla
    function ADD()
    {

        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `ASIGNAC_QA` WHERE (IdTrabajo = '$this->IdTrabajo') 
                                                      AND (LoginEvaluador = '$this->LoginEvaluador') 
                                                      AND (LoginEvaluado = '$this->LoginEvaluado') 
                                                      AND (AliasEvaluado = '$this->Alias')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `ASIGNAC_QA` (`IdTrabajo`,`LoginEvaluador`,`LoginEvaluado`, `AliasEvaluado`) 
				VALUES ('".$this->IdTrabajo."','".$this->LoginEvaluador."','".$this->LoginEvaluado."', '".$this->Alias."');";

                    if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje

                        return 'Unknowed Error';

                    }
                    else{ //si no da error en la insercion devolvemos mensaje de exito
                        return 'Success insert'; //operacion de insertado correcta
                    }

                }
                else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
                    return 'It is already in DB'; // ya existe
            }


    } // fin del metodo ADD

// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
    function RellenaDatos()
    {	
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //variable que albergara el valor de resultado

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT * FROM `ASIGNAC_QA` WHERE (IdTrabajo = '$this->IdTrabajo') 
                                                      AND (LoginEvaluador = '$this->LoginEvaluador') 
                                                      AND (LoginEvaluado = '$this->LoginEvaluado') 
                                                      AND (AliasEvaluado = '$this->Alias')";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados
            return 'It does not exist in DB'; //se devuelve el mensaje de que no existe
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos()

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
         $result; //variable que albergara el valor de resultado

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `ASIGNAC_QA` ";
        if (!($resultado = $this->mysqli->query($sql))){ //Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB'; 
        }
        else{ // si existe 
            $result = $resultado; //guarda el valor deresultado en result
            return $result; //devuelve result
        }
    } //fin AllData

//funcion SEARCH
//hace una búsqueda en la tabla con los datos proporcionados. Si van vacios devuelve todos
    function SEARCH()
    { 	
         $sql; //variable que alberga la sentencia sql
         $resultado; //almacena la consulta sql

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `ASIGNAC_QA`
				where IdTrabajo LIKE '%".$this->IdTrabajo."%' AND
						LoginEvaluador LIKE '%".$this->LoginEvaluador."%' AND
						LoginEvaluado LIKE '%".$this->LoginEvaluado."%' AND
						AliasEvaluado LIKE '%".$this->Alias."%' ";
       
        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo SEARCH


//funcion EDIT
// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
// si existe se modifica
    function EDIT()
    {
         $sql; //variable que alberga la sentencia sql
         $result; //almacena el valor de una consulta sql
         $resultado; //almacena el valor de una consulta sql

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `ASIGNAC_QA` WHERE (IdTrabajo = '".$this->IdTrabajo."') AND (LoginEvaluador = '".$this->LoginEvaluador."') AND (LoginEvaluado = '".$this->LoginEvaluado."') AND (AliasEvaluado = '".$this->Alias."') ";

        $result = $this->mysqli->query($sql);// se ejecuta la query
        
        if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
        {	
            // se construye la sentencia de modificacion en base a los atributos de la clase
            $sql = "UPDATE `ASIGNAC_QA` SET 
					IdTrabajo = '".$this->IdTrabajo."',
					LoginEvaluador = '".$this->LoginEvaluador."',
					LoginEvaluado = '".$this->LoginEvaluado."',
					AliasEvaluado = '".$this->Alias."'
				WHERE ( IdTrabajo = '".$this->IdTrabajo."') AND ( LoginEvaluador = '".$this->LoginEvaluador."') AND ( LoginEvaluado = '".$this->LoginEvaluado."') AND ( AliasEvaluado = '".$this->Alias."') ";
            
            if (!($resultado = $this->mysqli->query($sql))){// si hay un problema con la query se envia un mensaje de error en la modificacion

                return 'Unknowed Error';
            }
            else{ // si no hay problemas con la modificación 

                return 'Success Modify'; //se indica que se ha modificado
            }
        }
        else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
            return 'It does not exist in DB';
    } // fin del metodo EDIT

// funcion DELETE()
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
    function DELETE()
    {	
         $sql; //variable que alberga la sentencia sql
         $result; //almacena el valor de una consulta sql
         $sql2; //variable que alberga la sentencia sql2

        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `ASIGNAC_QA` WHERE (IdTrabajo = '$this->IdTrabajo') 
                                                  AND (LoginEvaluador = '$this->LoginEvaluador') 
                                                  AND (LoginEvaluado = '$this->LoginEvaluado') 
                                                  AND (AliasEvaluado = '$this->Alias')";

        // se ejecuta la query
        $result = $this->mysqli->query($sql);
        // si existe una tupla con ese valor de clave
        if ($result->num_rows == 1)
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `ASIGNAC_QA` WHERE (IdTrabajo = '$this->IdTrabajo') AND (LoginEvaluador = '$this->LoginEvaluador') AND (LoginEvaluado = '$this->LoginEvaluado') AND (AliasEvaluado = '$this->Alias')";
            // se ejecuta la query
            if($this->mysqli->query($sql)){
                $sql2 = "DELETE FROM `EVALUACION` WHERE (WHERE (IdTrabajo = '$this->IdTrabajo') AND (LoginEvaluador = '$this->LoginEvaluador') AND (AliasEvaluado = '$this->Alias')";
                // se ejecuta la query
                if($this->mysqli->query($sql2)){
                    return "Correctly delete";
                }
            }
            // se devuelve el mensaje de borrado correcto
            return "Correctly delete";
        } // si no existe el login a borrar se devuelve el mensaje de que no existe
        else
            return "It does not exist";
    } // fin metodo DELETE


//funcion buscarTrabajos
//devuelve los trabajos que sean ET
    function buscarTrabajos($trabajo)
    { 
         $sql; //variable que alberga la sentencia sql
         $resultado; //almacena el resultado de una consulta sql

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `TRABAJO`
				where IdTrabajo LIKE '%$trabajo%' ";

        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el resultado
            return $resultado;
        }
    } // fin metodo buscarTrabajos


//funcion buscarEntregas
//busca las entregas de un trabajo
    function buscarEntregas($NombreTrabajo)
    { 	
        $idTrabajo; //almacena el valor de idTrabajo de la tabla
         $sql; //variable que alberga la sentencia sql
         $resultado; //almacena el resultado de una consulta sql

        $idTrabajo= "SELECT IdTrabajo from `TRABAJO` WHERE (NombreTrabajo = '$NombreTrabajo')";
        // se construye la sentencia sql
        $sql = "SELECT *
       			from `ENTREGA`
				where IdTrabajo=($idTrabajo)";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo buscarEntregas


//funcion InsertarAsignarQA
//funcion que inserta una asignacion de qa
    function InsertarAsignaQA($NombreTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado)
    { 	
         $idTrabajo; //almacena el valor de idTrabajo de la tabla
         $trabajo; //
         $id; //almacena un trabajo
         $sql; //variable que alberga la sentencia sql
         $LoginEvaluador; //contiene el valor de la variable LoginEvaluador de la tabla
         $LoginEvaluado; //contiene el valor de la variable LoginEvaluado de la tabla
         $AliasEvaluado; //contiene el valor de la variable AliasEvaluado de la tabla
         $resultado; //almacena el resultado de una consulta sql

        
        $idTrabajo= "SELECT IdTrabajo from `TRABAJO` WHERE (NombreTrabajo = '$NombreTrabajo')";
        $trabajo=$this->mysqli->query($idTrabajo);
        $trabajo=$trabajo->fetch_array();
        $id=$trabajo['IdTrabajo'];

        // se construye la sentencia sql
        $sql = "INSERT INTO `ASIGNAC_QA` (`IdTrabajo`,`LoginEvaluador`,`LoginEvaluado`,`AliasEvaluado`) 
				VALUES ('".$id."','".$LoginEvaluador."','".$LoginEvaluado."','".$AliasEvaluado."');";

        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo InsertaAsignaQA


//funcion asignaciones
//devuelve todas las asignaciones
    function asignaciones($NombreTrabajo){

         $NombreTrabajo; //almacena un substring
         $idtrabajo; //concatena una cadena con el substring almacenado en NombreTrabajo
         $sql; //variable que alberga la sentencia sql
         $resultado; //almacena el resultado de una consulta sql
         $result; //almacena el valor de resultado

        $NombreTrabajo=substr($NombreTrabajo,2);
        $idtrabajo="ET".$NombreTrabajo;

        // se construye la sentencia sql
        $sql = "SELECT LoginEvaluador, AliasEvaluado FROM `ASIGNAC_QA` WHERE (IdTrabajo= '".$idtrabajo."')";
        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    } //fin metodo asignaciones


//funcion historias
//devuelve todas las historias
    function historias($NombreTrabajo){

         $NombreTrabajo; //almacena un substring
         $idtrabajo; //concatena una cadena con el substring almacenado en NombreTrabajo
         $sql; //variable que alberga la sentencia sql
         $resultado; //almacena el resultado de una consulta sql
         $result; //almacena el valor de resultado

        $NombreTrabajo=substr($NombreTrabajo,2);
        $idtrabajo="ET".$NombreTrabajo;

        // se construye la sentencia sql
        $sql = "SELECT IdHistoria FROM `HISTORIA` WHERE (IdTrabajo= '".$idtrabajo."') ";

        if (!($resultado = $this->mysqli->query($sql))){// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'It does not exist in DB'; 
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    } //fin metodo historias


//funcion InsertaHistoria
//inserta una historia
    function InsertaHistoria($NombreTrabajo,$LoginEvaluador,$AliasEvaluado,$idHistoria)
    { 	
         $idTrabajo; //almacena un trabajo
         $trabajo; //almacena la consulta
         $id; //almacena el nombre del trabajo que se le pasa como parametro
         $sql; //variable que alberga la sentencia sql
         $LoginEvaluador; //contiene el valor de la variable LoginEvaluador de la tabla
         $AliasEvaluado; //contiene el valor de la variable AliasEvaluado de la tabla
         $idHistoria; //contiene el valor de la variable idHisoria de la tabla
         $resultado; //almacena el resultado de una consulta sql

        $idTrabajo= "SELECT IdTrabajo from `TRABAJO` WHERE (NombreTrabajo = '$NombreTrabajo')";
        $trabajo=$this->mysqli->query($idTrabajo);
        $trabajo=$trabajo->fetch_array();
        $id=$NombreTrabajo;

        // se construye la sentencia sql
        $sql = "INSERT INTO `EVALUACION` (`IdTrabajo`,`LoginEvaluador`,`AliasEvaluado`,`IdHistoria`,`CorrectoA`,`ComenIncorrectoA`,`CorrectoP`,`ComentIncorrectoP`,`OK`) 
				VALUES ('".$id."','".$LoginEvaluador."','".$AliasEvaluado."','".$idHistoria."','1','','1','','1');";
                
        
        if (!($resultado = $this->mysqli->query($sql))){// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    } // fin metodo InsertaAsignaQA


}//fin de clase

?> 
