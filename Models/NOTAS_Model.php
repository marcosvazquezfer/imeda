<?php
/**
 * Modelo que accede a la base de datos para gestionar las notas
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
class NOTAS_Model { //declaración de la clase

    var $login; // declaración del atributo login
    var $IdTrabajo; // declaración del atributo IdTrabajo
    var $NotaTrabajo; // declaración del atributo NotaTrabajo
    var $mysqli; // declaración del atributo manejador de la bd


    //Constructor de la clase
    function __construct($login, $IdTrabajo, $NotaTrabajo){

        //asignación de valores de parámetro a los atributos de la clase
        $this->login = $login;
        $this->IdTrabajo = $IdTrabajo;
        $this->NotaTrabajo = $NotaTrabajo;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor


    //Método ADD
    //Inserta en la tabla  de la bd  los valores de los atributos del objeto. Comprueba si la clave/s esta vacia y si
    //existe ya en la tabla
    function ADD()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql

        if (($this->login <> '') && ($this->IdTrabajo <> '')){ // si el atributo clave de la entidad no esta vacio
            
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `NOTA_TRABAJO` WHERE (login = '$this->login') && (IdTrabajo = '$this->IdTrabajo')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `NOTA_TRABAJO` (`login`,`IdTrabajo`, `NotaTrabajo`) 
				                VALUES ('".$this->login."','".$this->IdTrabajo."', '".$this->NotaTrabajo."');";

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
        $result; //variable que albergara el valor de resultado

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `NOTA_TRABAJO` ";
        if (!($resultado = $this->mysqli->query($sql))){ //Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB';
        }
        else{ // si existe
            $result = $resultado;//guarda el valor deresultado en result
            return $result;//devuelve result
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
       			from `NOTA_TRABAJO`
				where login LIKE '%".$this->login."%' AND
						IdTrabajo LIKE '%".$this->IdTrabajo."%' AND
						NotaTrabajo LIKE '%".$this->NotaTrabajo."%'";
        
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
        $sql = "SELECT * FROM `NOTA_TRABAJO` WHERE (login = '".$this->login."')";
        
        $result = $this->mysqli->query($sql); // se ejecuta la query
        
        if ($result->num_rows == 1) // si existe una tupla con ese valor de clave
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `NOTA_TRABAJO` WHERE (login = '".$this->login."') ";
            
            $this->mysqli->query($sql); // se ejecuta la query
            
            return 'Correctly delete';// se devuelve el mensaje de borrado correcto
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
        $sql = "SELECT * FROM `NOTA_TRABAJO` WHERE login = '".$this->login."'";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados
            return 'It does not exist in DB'; //mensaje de que no existe
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos

    // funcion RellenaDatos2
    // Esta función obtiene de la entidad de la bd los atributos indicados a partir del valor de la clave que esta
    // en el atributo de la clase
    function RellenaDatos2()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de la variable resultado

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT IdTrabajo, NotaTrabajo FROM `NOTA_TRABAJO` WHERE login = '".$this->login."'";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados
            return 'It does not exist in DB'; //mensaje de que no existe
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos


    // funcion EDIT
    // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
    // si existe se modifica
    function EDIT()
    {
        $sql; //variable que alberga la sentencia sql
        $result; //almacena la consulta sql
        $resultado; //almacena la consulta sql

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `NOTA_TRABAJO` WHERE (login = '".$this->login."') && (IdTrabajo = '".$this->IdTrabajo."')";
        
        $result = $this->mysqli->query($sql);// se ejecuta la query

        if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
        {	
            // se construye la sentencia de modificacion en base a los atributos de la clase
            $sql = "UPDATE `NOTA_TRABAJO` SET 
					NotaTrabajo = '".$this->NotaTrabajo."'
				WHERE ( login = '".$this->login."'
				) && ( IdTrabajo = '".$this->IdTrabajo."'
                )";
            
            if (!($resultado = $this->mysqli->query($sql))){ // si hay un problema con la query se envia un mensaje de error 
                return 'Unknowed Error';
            }
            else{ // si no hay problemas con la modificación se indica que se ha modificado
                return 'Success Modify';
            }
        }
        else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
            return 'It does not exist in DB';
    } // fin del metodo EDIT


    //funcion getNotasAlum
    //nos permite obtener de la tabla las notas del alumno
    function getNotasAlum($id){

        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de la variable resultado

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `NOTA_TRABAJO` WHERE login='".$id."'";
        if (!($resultado = $this->mysqli->query($sql))){ // si hay un problema con la query se envia el mensaje correspondiente
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }//fin metodo getNotasAlum


    //funcion getHist
    //nos permite obtener la historia
    function getHist($id){

        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de la variable resultado
        
        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `HISTORIA` WHERE IdTrabajo='".$id."'";

        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }//fin metodo getHist


    //funcion fetchQAs
    //recoge la evaluacion pasandole una id de trabajo y un alias
    function fetchQAs($IdTrabajo,$log){

        $ID; //almacena substring
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        $ID = substr($IdTrabajo,2);

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `ENTREGA` 
        WHERE ENTREGA.IdTrabajo = '".$IdTrabajo."' && 
        ENTREGA.login = '".$log."'";
        
        if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            return 'Query Error about DB';
        }
        else if($resultado->num_rows == 1){ // si existe una tupla con ese valor de clave
            
            $log=$resultado->fetch_array();

            // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
            $sql = "SELECT * FROM `EVALUACION` 
            WHERE EVALUACION.IdTrabajo = '".'QA'.$ID."' && 
            EVALUACION.AliasEvaluado = '".$log['Alias']."'
            order by IdHistoria, AliasEvaluado";
            
            if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
                return 'Query Error about DB';
            }
            else{ // si la busqueda es correcta devolvemos el recordset resultado
                return $resultado;
            }
        }else{ //si no existe esa tupla se envia mensaje de que no existe en la bd
            return 'It does not exist in DB';
        } 

    }//fin metodo fetchQAs


    //funcion fetchQAscorr
    //recoge la correccion de las QAs
    function fetchQAscorr($IdTrabajo,$log){

        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
            
            // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
            $sql = "SELECT * FROM `EVALUACION` 
            WHERE EVALUACION.IdTrabajo = '".$IdTrabajo."' && 
            EVALUACION.LoginEvaluador = '".$log."'
            order by IdHistoria";
            
            if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
                return 'Query Error about DB';
            }
            else{ // si la busqueda es correcta devolvemos el recordset resultado
                return $resultado;
            }     

    }//fin metodo fetchQAscorr

    //fetchTrabAlu recoge todos los resultados de los trabajos de un alumno dado
    function fetchTrabAlu(){
        
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql

        //Construimos la sentencia sql correspondiente
        $sql = "SELECT TRABAJO.IdTrabajo ,ENTREGA.login, NOTA_TRABAJO.NotaTrabajo FROM `TRABAJO`,`ENTREGA`,`EVALUACION`,`NOTA_TRABAJO` 
                WHERE ((TRABAJO.IdTrabajo=ENTREGA.IdTrabajo && ENTREGA.login='".$this->login."') 
                || (EVALUACION.IdTrabajo=TRABAJO.IdTrabajo && EVALUACION.LoginEvaluador='".$this->login."')) &&
                (NOTA_TRABAJO.login='ana' && NOTA_TRABAJO.IdTrabajo = TRABAJO.IdTrabajo)
                GROUP BY TRABAJO.IdTrabajo";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            
            return $resultado;

        }     
 
    }

}//fin de clase

?>