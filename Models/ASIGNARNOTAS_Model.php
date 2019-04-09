<?php
/**
 * Modelo que accede a la base de datos para gestionar la generación de notas
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 16/12/2017
 */
class ASIGNARNOTAS_Model { //declaración de la clase

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

    //Esta función devuelve el resultado de una consulta sql
    function GeneraNotasEntregas($IdTrabajo, $login){

        $id;//almacena IdTrabajo que se pasa como parámetro al método 
        $alias;//almacena una consulta sql
        $correctos;//almacena una consulta sql
        $result;//almacena el resultado de una consulta sql
           
        $id ='QA'.substr($IdTrabajo,2);

        $alias = "SELECT Alias FROM `ENTREGA` 
                    WHERE IdTrabajo = '".$IdTrabajo."' AND login = '".$login."'";

        $correctos = "SELECT DISTINCT IdHistoria, CorrectoP FROM `EVALUACION` 
                        WHERE IdTrabajo = '".$id."' && AliasEvaluado = (".$alias.")";


        $result = $this->mysqli->query($correctos);

        return $result;
    }//fin método GenerarNotasEntregas()

    //Esta función devuelve el resultado de una consulta sql
    function GeneraNotasQAS($IdTrabajo, $login, $alias){

        $id;//almacena IdTrabajo que se pasa como parámetro
        $eva;//almacena una concatenación de caracteres
        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        $id = $IdTrabajo;
        $eva = 'QA'.substr($IdTrabajo, 2);

        $sql= "SELECT EVALUACION.CorrectoP, EVALUACION.CorrectoA, EVALUACION.OK FROM `ASIGNAC_QA` ,`EVALUACION` 
                    WHERE ASIGNAC_QA.LoginEvaluador = EVALUACION.LoginEvaluador AND ASIGNAC_QA.AliasEvaluado = EVALUACION.AliasEvaluado AND EVALUACION.IdTrabajo = '".$eva."' AND EVALUACION.LoginEvaluador = '".$login."' AND EVALUACION.AliasEvaluado = '".$alias."'";

        $resultado = $this->mysqli->query($sql);

        return $resultado;
    }//fin método GenerarNotasQAS()

    //Función que se encarga de insertar una nota en la tabla NOTAS
    function InsertarNotas($login,$IdTrabajo,$NotaTrabajo){

        $sql;//almacena una consulta sql
        
        $sql = "INSERT INTO `NOTA_TRABAJO` (`login`, `IdTrabajo`, `NotaTrabajo`)
                            VALUES ('".$login."', '".$IdTrabajo."', '".$NotaTrabajo."')";
        
        $this->mysqli->query($sql);
    }//fin método InsertarNotas()

    //Función que busca aquellos trabajos que son entregas
    function buscarEntregas($IdTrabajo){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        $sql = "SELECT * FROM `ENTREGA`
                WHERE IdTrabajo = ('$IdTrabajo')";
        
        //si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{
            return $resultado;
        }
    }//fin del método buscarEntregas()

    //función que busca las QAS que se hacen de una entrega
    function buscarQAS($IdTrabajo){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        $sql = "SELECT DISTINCT LoginEvaluador FROM `ASIGNAC_QA`
                WHERE IdTrabajo = ('$IdTrabajo')";
        
        //si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{
            return $resultado;
        }
    }//fin del método buscarQAS()

     //función que busca las QAS que se hacen de una entrega
    function buscarQAS2($IdTrabajo,$LoginEvaluador){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql 

        $sql = "SELECT * FROM `ASIGNAC_QA`
                WHERE IdTrabajo = ('$IdTrabajo') AND LoginEvaluador = ('$LoginEvaluador') ";

        //si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{
            return $resultado;
        }
    }//fin del método buscarQAS()


    //función que busca un trabajo que sea entrega
    function buscarTrabajo( ){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        //construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT * FROM `TRABAJO`
                    WHERE IdTrabajo LIKE '%ET%' ";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{
            return $resultado;
        }
    }//fin método buscarTrabajos()

    //función que busca un trabajo que sea QA
    function buscarTrabajo2( ){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        //construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT * FROM `TRABAJO`
                    WHERE IdTrabajo LIKE '%QA%' ";

        //si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{ 
            return $resultado;
        }
    }//fin método buscarTrabajos2()

    // funcion RellenaDatos2
    // Esta función obtiene de la entidad de la bd los atributos indicados a partir del valor de la clave que esta
    // en el atributo de la clase
    function RellenaDatos2()
    {
        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $Trabajos;//almacena un array
        $row;//convierte el array en un fetcharray

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT TRABAJO.IdTrabajo, NotaTrabajo, PorcentajeNota, login FROM `NOTA_TRABAJO`, `TRABAJO` WHERE login = '".$this->login."' AND TRABAJO.IdTrabajo = NOTA_TRABAJO.IdTrabajo";

        if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados
            return 'It does not exist in DB'; //mensaje de que no existe
        }
        else{ // si existe se devuelve la tupla resultado

            $Trabajos = array();

            //mientras existan elementos
            while($row = $resultado->fetch_array() ){

                //si no existe la clave la introduce en el array
                if(!array_key_exists($row['IdTrabajo'], $Trabajos)){
                    $Trabajos[$row['IdTrabajo']] = array();
                }

                //si no existe la clave la introduce en el array
                if(!array_key_exists($row['login'], $Trabajos[$row['IdTrabajo']])){
                    $Trabajos[$row['IdTrabajo']][$row['login']] = array();
                }
                array_push($Trabajos[$row['IdTrabajo']][$row['login']], $row);
            }
            return $Trabajos;
        }
    } // fin del metodo RellenaDatos2


    //función que busca todos los trabajos
    function Trabajos(){

        $sql;//almacena una consulta sql
        $resultado;//almacena el resultado de una consulta sql

        //construimos la sentencia de busqueda
        $sql = "SELECT * FROM `TRABAJO`";


        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{
            return $resultado;
        }
    }//fin método Trabajos()


    //función que busca todos los datos necesarios para la vista de notas del admin
    function DatosNotasAdmin(){

        $sql;//almacena una consulta sql que trae las notas con los usuarios y los porcentajes de las notas
        $sql2;//almacena consulta sql para los nombresde los trabajos
        $resultado;$resultado2;//almacena el resultado de una consulta sql
        $toret;//array principal para el almacenamiento

        //construimos la sentencia de busqueda
        $sql = "SELECT TRABAJO.IdTrabajo, NOTA_TRABAJO.NotaTrabajo, NOTA_TRABAJO.login, TRABAJO.PorcentajeNota 
                FROM `TRABAJO`,`NOTA_TRABAJO` 
                WHERE NOTA_TRABAJO.IdTrabajo = TRABAJO.IdTrabajo ";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'Query Error about DB';
        }
        //si la busqueda es correcta devolvemos el recordset resultado
        else{

            $sql2 = "SELECT DISTINCT * FROM `TRABAJO`";
            //comprueba que se realiza correctamente la consulta
            //si falla, muestra un error
            //si no; continua con el proceso
            if (!($resultado2 = $this->mysqli->query($sql2))) {
                return 'Query Error about DB';
            }
            else{

                $toret =array();
                //mientras sigua habiendo tuplas
                while($row = $resultado->fetch_array()){
                    //si no existe la clave la introduce en el array
                    if(!array_key_exists($row['login'],$toret)){

                        $toret[$row['login']]=array();


                    }
                    //Realiza el proceso para cada resultado de la consulta $sql2
                    foreach($resultado2 as $row2){
                        //comprueba que los id trabajo coinciden
                        //si coinciden almacena la nota del trabajo y el porcentaje
                        if($row2['IdTrabajo'] == $row['IdTrabajo']){
                            $toret[$row['login']][$row['IdTrabajo']]['Nota'] = $row['NotaTrabajo'];
                            $toret[$row['login']][$row['IdTrabajo']]['Porcentaje'] = $row['PorcentajeNota'];
                        }

                    }

                }
                //devuelve $toret
                return $toret;


            }
        }
    }//fin método DatosNotasAdmin()





}//fin de clase

?>