<?php
/**
 * Modelo que accede a la base de datos para gestionar las evaluaciones
 * Created by PhpStorm.
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 28/11/2017
 * Fecha fin:28/11/2017
 */
class EVALUACION_Model { //declaración de la clase

    var $IdTrabajo; // declaración del atributo login
    var $LoginEvaluador; // declaración del atributo DNI
    var $AliasEvaluado; // declaración del atributo password
    var $IdHistoria; // declaración del atributo password
    var $CorrectoA; // declaración del atributo password
    var $ComenIncorrectoA; // declaración del atributo password
    var $CorrectoP; // declaración del atributo password
    var $ComentIncorrectoP; // declaración del atributo password
    var $OK; // declaración del atributo password
    var $mysqli; // declaración del atributo manejador de la bd
    var $id; //Guarda un id
    var $corr; //Guarda una correcion
    var $comen; //Guarda un comentario
    var $alias; //Guarda un alias
    var $resultado; //Guarda el resultado de una query
    var $result; //Guarda el resultado de una query
    var $hist; //Guarda un id de historia
    var $ok; //Guarda la informacion de un ok
    var $sql; //Guarda una sentencia sql


//Constructor de la clase
    function __construct($IdTrabajo, $LoginEvaluador, $AliasEvaluado, $IdHistoria, $CorrectoA, $ComenIncorrectoA, $CorrectoP, $ComentIncorrectoP, $OK){

        
        //asignación de valores de parámetro a los atributos de la clase
        $this->IdTrabajo = $IdTrabajo;
        $this->LoginEvaluador = $LoginEvaluador;
        $this->AliasEvaluado = $AliasEvaluado;
        $this->IdHistoria = $IdHistoria;
        $this->CorrectoA = $CorrectoA;
        $this->ComenIncorrectoA = $ComenIncorrectoA;
        $this->CorrectoP = $CorrectoP;
        $this->ComentIncorrectoP = $ComentIncorrectoP;
        $this->OK = $OK;
        
        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor


//Método ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si
//existe ya en la tabla
    function ADD($IdHistoria)
    {
        if (($this->IdTrabajo <> '') && ($IdHistoria <> '')  && ($this->AliasEvaluado <> '')  && ($this->LoginEvaluador <> '')){ // si el atributo clave de la entidad no esta vacio
            
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `EVALUACION` WHERE (IdTrabajo = '$this->IdTrabajo') && 
                (IdHistoria = '$IdHistoria') && (AliasEvaluado = '$this->AliasEvaluado') && 
                (LoginEvaluador = '$this->LoginEvaluador')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    
                    $sql = "INSERT INTO `EVALUACION` (`IdTrabajo`,`IdHistoria`, `AliasEvaluado`, `LoginEvaluador`,`CorrectoA`,`ComenIncorrectoA`,`CorrectoP`,`ComentIncorrectoP`,`OK`) 
				        VALUES ('".$this->IdTrabajo."','".$IdHistoria."', '".$this->AliasEvaluado."', '".$this->LoginEvaluador."','".$this->CorrectoA."','".$this->ComenIncorrectoA."', '".$this->CorrectoP."', '".$this->ComentIncorrectoP."' , '".$this->OK."');";

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

    //AllData devuelve todos los valores de EVALUACION
    function AllData(){

        //Creamos la sentencia sql para recoger todos los valores de EVALUACION
        $sql = "SELECT * FROM `EVALUACION` ";

        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }

//funcion SEARCH:
// hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
    function SEARCH($IdHistoria)
    {
        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
       			from `EVALUACION`
				where IdTrabajo LIKE '%".$this->IdTrabajo."%' AND
						AliasEvaluado LIKE '%".$this->AliasEvaluado."%' AND
                        LoginEvaluador LIKE '%".$this->LoginEvaluador."%' AND
                        IdHistoria LIKE '%".$IdHistoria."%' AND
                        CorrectoA LIKE '%".$this->CorrectoA."%' AND
                        ComenIncorrectoA LIKE '%".$this->ComenIncorrectoA."%' AND
                        CorrectoP LIKE '%".$this->CorrectoP."%' AND
                        ComentIncorrectoP LIKE '%".$this->ComentIncorrectoP."%' AND
                        OK LIKE '%".$this->OK."%'";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
         return 'Query Error about DB';

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
        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `EVALUACION` WHERE (IdTrabajo = '".$this->IdTrabajo."') && 
            (IdHistoria = '".$this->IdHistoria."') && (AliasEvaluado = '".$this->AliasEvaluado."') && 
            (LoginEvaluador = '".$this->LoginEvaluador."')";
        // se ejecuta la query
        $result = $this->mysqli->query($sql);
        // si existe una tupla con ese valor de clave
        if ($result->num_rows == 1)
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `EVALUACION` WHERE (IdTrabajo = '".$this->IdTrabajo."') && 
                (IdHistoria = '".$this->IdHistoria."') && (AliasEvaluado = '".$this->AliasEvaluado."') && 
                (LoginEvaluador = '".$this->LoginEvaluador."')";
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

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT * FROM `EVALUACION` WHERE IdTrabajo = '".$this->IdTrabajo."' && 
                (IdHistoria = '".$this->IdHistoria."') && (LoginEvaluador = '".$this->LoginEvaluador."')
                && (AliasEvaluado = '".$this->AliasEvaluado."')";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos()

    //fetchHistorias() retorna todas las historias
    function fetchHistorias(){
        //Creamos la sentencia sql para recoger todas las historias
        $sql = "SELECT * FROM `HISTORIA` ORDER BY IdTrabajo,IdHistoria";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }

    //fetchAlias() retorna todas los alias de las entregas
    function fetchAlias(){

        //Creamos la sentencia sql para recoger todas las alias
        $sql = "SELECT Alias FROM `ENTREGA` ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }

    //fetchLogin() retorna todas los logins de las usuario
    function fetchLogin(){

        //Creamos la sentencia sql para recoger todos los logins
        $sql = "SELECT login FROM `USUARIO` ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }
    }
    //fetchEntregas() retorna todas las entregas
    function fetchEntregas(){

        //Creamos la sentencia sql para recoger todas las entregas
        $sql = "SELECT * FROM `ENTREGA` ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }

    }

    //fetchEntregasQA() retorna todas las entregas
    function fetchEntregasQA(){

        //Creamos la sentencia sql que recoge todos los trabajos que sean QA
        $sql = "SELECT * FROM `TRABAJO` WHERE IdTrabajo LIKE 'QA%'";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }

    }
    
    //fetchEntregasAlum() retorna todas las entregas de un alumno que se vayan a corregir
    function fetchEntregasAlum($login){
        
        //Creamos la sentencia sql que recoge las entregas de un alumno
        $sql = "SELECT DISTINCT ENTREGA.* FROM `ENTREGA`,`EVALUACION` 
                WHERE EVALUACION.AliasEvaluado = ENTREGA.Alias && EVALUACION.LoginEvaluador = '".$login."'";

         // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }

    }

    //fetchFormEvaluacion retorna las evaluaciones para un login evaluador y alias dado y un idtrabajo dado
    function fetchFormEvaluacion(){
        
        // construimos la sentencia para recoger todas las evaluacione que se va modificar
        $sql = "SELECT EVALUACION.IdHistoria, HISTORIA.TextoHistoria, EVALUACION.*
                from `EVALUACION`,`HISTORIA`
                where HISTORIA.IdTrabajo LIKE '".$this->IdTrabajo."' AND
                    LoginEvaluador LIKE '%".$this->LoginEvaluador."%' AND
                    AliasEvaluado LIKE '".$this->AliasEvaluado."' AND
                    EVALUACION.IdHistoria=HISTORIA.IdHistoria";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
        return 'Query Error about DB';

        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
        return $resultado;
        }

    }

    //fetchFormEvaluacion retorna las evaluaciones para un login evaluador y alias dado y un idtrabajo dado
    function fetchFormEvaluacionCorr(){
        
         // construimos la sentencia para recoger todas las evaluacione que se va modificar por parte del profesor
        $sql = "SELECT EVALUACION.IdHistoria, HISTORIA.TextoHistoria, EVALUACION.*
                from `EVALUACION`,`HISTORIA` ,`ENTREGA`
                where HISTORIA.IdTrabajo LIKE '".$this->IdTrabajo."' AND
                    ENTREGA.Alias LIKE '".$this->AliasEvaluado."' AND
                    AliasEvaluado LIKE '".$this->AliasEvaluado."' AND
                    EVALUACION.IdHistoria=HISTORIA.IdHistoria
                    GROUP BY EVALUACION.IdHistoria";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
        return 'Query Error about DB';

        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
        return $resultado;
        }

    }

    //fetchQAs retorna todas las evaluaciones para un alias dado y un idtrabajo dado
    function fetchQAs(){
        
        // construimos la sentencia pra recoger todas las evaluciones de una entrega de un usuario en concreto
        $sql = "SELECT * FROM `EVALUACION` 
                WHERE EVALUACION.IdTrabajo = '".$this->IdTrabajo."' && 
                EVALUACION.AliasEvaluado = '".$this->AliasEvaluado."'
                order by IdHistoria, AliasEvaluado";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
        return 'Query Error about DB';

        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
        return $resultado;
        }

    }

    //fetchQAsHistoria retorna todas las historias de un trabajo
    function fetchQAsHistoria($id){
        
        // construimos la sentencia recoge todas las historias de un trabajo dado
        $sql = "SELECT DISTINCT HISTORIA.IdHistoria,HISTORIA.TextoHistoria FROM `EVALUACION`,`HISTORIA` 
                WHERE HISTORIA.IdTrabajo = '".$id."' && 
                EVALUACION.AliasEvaluado = '".$this->AliasEvaluado."' &&
                HISTORIA.IdHistoria = EVALUACION.IdHistoria
                order by IdHistoria";
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }

    }

    //EditEvaluacionHistoria modifica una tupla de EVALUACION por parte del alumno
    function EditEvaluacionHistoria($id,$corr,$comen,$log,$alias,$IdTrabajo){
        
        // construimos la sentencia para modificar una tupla de EVALUCION en los valores del alumno corrector
        $sql = "UPDATE `EVALUACION` SET 
        CorrectoA = '".$corr."',
        ComenIncorrectoA  = '".$comen."'
        WHERE LoginEvaluador = '".$log."' && 
        (AliasEvaluado = '".$alias."') && 
        (IdHistoria = '".$id."') && 
        (IdTrabajo = '".$IdTrabajo."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //EditEvaluacionHistoria modifica una tupla de EVALUACION por parte del profesor
    function EditEvaluacionHistoriaProfesor($id,$corr,$comen,$alias,$IdTrabajo){
        
         // construimos la sentencia para modificar una tupla de EVALUCION en los valores del profesor
        $sql = "UPDATE `EVALUACION` SET 
        CorrectoP = '".$corr."',
        ComentIncorrectoP  = '".$comen."'
        WHERE (AliasEvaluado = '".$alias."') && 
        (IdHistoria = '".$id."') && 
        (IdTrabajo = '".$IdTrabajo."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //DefaultQAS modifica el valor de OK de una tupla de EVALUACION y lo pone a un valor por defecto 
    function DefaultQAS($id,$alias){
        
        //Creamos una sentencia sql para modificar el ok de una tupla de EVALAUCION
        $sql = "UPDATE `EVALUACION` SET 
        OK = '0'
        WHERE (AliasEvaluado = '".$alias."') && 
        (IdTrabajo = '".$id."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //EvaluarQAS modifica el ok de un alumno en concreto por parte del profesor para un login evaluador en concreto
    function EvaluarQAS($id,$alias,$hist,$log,$ok){
        
        //Creamos la sentencia para modificar el ok de una tupla de EVALUACION para un login evaluador en concreto
        $sql = "UPDATE `EVALUACION` SET 
        OK = '".$ok."'
        WHERE LoginEvaluador = '".$log."' && 
        (AliasEvaluado = '".$alias."') && 
        (IdHistoria = '".$hist."') && 
        (IdTrabajo = '".$id."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //Evaluar modifica una tupla que por parte de un profesor
    function Evaluar($id,$alias,$hist,$log,$coment,$corr){
        
        //Contruimos la sentencia sql para modificar una tupla por parte del profesor
        $sql = "UPDATE `EVALUACION` SET 
        ComentIncorrectoP = '".$coment."',
        CorrectoP = '".$corr."'
        WHERE LoginEvaluador = '".$log."' && 
        (AliasEvaluado = '".$alias."') && 
        (IdHistoria = '".$hist."') && 
        (IdTrabajo = '".$id."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //EvaluarIncorrecto modifica una tupla que por parte de un profesor
    function EvaluarIncorrecto($id,$alias,$hist,$log,$coment,$corr){
        
        //Contruimos la sentencia sql para modificar una tupla por parte del profesor
        $sql = "UPDATE `EVALUACION` SET 
        ComentIncorrectoP = '".$coment."',
        CorrectoP = '".$corr."'
        WHERE LoginEvaluador = '".$log."' && 
        (AliasEvaluado = '".$alias."') && 
        (IdHistoria = '".$hist."') && 
        (IdTrabajo = '".$id."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }

    //eliminarvaloresQAS modifica los valores de las tuplas para un alias y un trabajo y los pone a 0
    function eliminarvaloresQAS($id,$alias){
        
        //Creamos la sentencia sql para modificar los valores de las tuplas para un alias y un trabajo y los pone a 0
        $sql = "UPDATE `EVALUACION` SET 
        OK = '0',
        CorrectoP = '0'
        WHERE (AliasEvaluado = '".$alias."') && 
        (IdTrabajo = '".$id."')";
        
        // si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Unknowed Error';
        }
        else{ // si no hay problemas con la modificación se indica que se ha modificado
            return 'Success Modify';
        }

    }



    //Devuelve los valores de la tabla ENTREGA
    function getQAS(){

        $sql; //almacena la consulta SQL
        $resultado; //almacena el resultado de la consulta SQL
        $result; //guarda el valor de resultado

        //sql que almacena la consulta
        $sql = "SELECT DISTINCT ASIGNAC_QA.AliasEvaluado,ASIGNAC_QA.LoginEvaluado,ASIGNAC_QA.IdTrabajo,ENTREGA.Horas,ENTREGA.Ruta 
                FROM `ASIGNAC_QA`,`ENTREGA` WHERE LoginEvaluador LIKE '%".$this->LoginEvaluador."%' AND 
                ASIGNAC_QA.IdTrabajo = ENTREGA.IdTrabajo AND 
                ASIGNAC_QA.AliasEvaluado = ENTREGA.Alias";

        // si da error la ejecución de la query
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se guarda el resultado de la consulta en result y se retorna
            $result = $resultado;
            return $result;
        }

    }

    // funcion getFechasFin()
    // Esta función obtiene de la bd los valores de FechaFinTrabajo de la tabla Trabajo
    function getFechasFin($IdTrabajo){

        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda sql
        $result; //almacena valor de resultado

        // se construye la sentencia sql
        $sql = "SELECT * FROM TRABAJO WHERE IdTRABAJO LIKE '%".$IdTrabajo."%' ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{// si existe se devuelve la tupla resultado de clave FechaFinTrabajo
            $result = $resultado->fetch_assoc();
            return $result['FechaFinTrabajo'];
        }

    }

}//fin de clase

?>