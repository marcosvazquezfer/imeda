<?php
/**
 * Modelo que accede a la base de datos para gestionar los trabajos
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 03/12/2017
 * Fecha fin: 03/12/2017
 *
 *
 *Editado para la gestionar las entregas
 * Autor: Mauri
 * Fecha nicio: 10/12/2017
 * Fech fin: 13/12/2017
 */
class TRABAJO_Model { //declaración de la clase

    var $IdTrabajo; // declaración del atributo IdTrabajo
    var $NombreTrabajo; // declaración del atributo NombreTrabajo
    var $FechaIniTrabajo; // declaración del atributo FechaIniTrabajo
    var $FechaFinTrabajo; //declaración del atributo FechaFinTrabajo
    var $PorcentajeNota; //declaración del atributo PorcentajeNota
    var $mysqli; // declaración del atributo manejador de la bd


//Constructor de la clase
    function __construct($IdTrabajo, $NombreTrabajo, $FechaIniTrabajo, $FechaFinTrabajo, $PorcentajeNota){

        //asignación de valores de parámetro a los atributos de la clase
        $this->IdTrabajo = $IdTrabajo;
        $this->NombreTrabajo = $NombreTrabajo;

        if ($FechaIniTrabajo == ''){
            $this->FechaIniTrabajo = $FechaIniTrabajo;
        }
        else{ // si no viene vacia le cambiamos el formato para que se adecue al de la bd
            $this->FechaIniTrabajo = date( 'Y-m-d',strtotime($FechaIniTrabajo));
        }
        if ($FechaFinTrabajo == ''){
            $this->FechaFinTrabajo = $FechaFinTrabajo;
        }
        else{ // si no viene vacia le cambiamos el formato para que se adecue al de la bd
            $this->FechaFinTrabajo = date( 'Y-m-d',strtotime($FechaFinTrabajo));
        }

        $this->PorcentajeNota = $PorcentajeNota;

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

        if (($this->IdTrabajo <> '')){ // si el atributo clave de la entidad no esta vacio

            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM `TRABAJO` WHERE (IdTrabajo = '$this->IdTrabajo')";

            if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }
            else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `TRABAJO` (`IdTrabajo`,`NombreTrabajo`, `FechaIniTrabajo`, `FechaFinTrabajo`, `PorcentajeNota`) 
				VALUES ('".$this->IdTrabajo."','".$this->NombreTrabajo."', '".$this->FechaIniTrabajo."', '".$this->FechaFinTrabajo."', '".$this->PorcentajeNota."');";

                    if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
                        return 'Unknowed Error';

                    }
                    else{ //si no da error en la insercion 
                        return 'Success insert'; //devolvemos mensaje de que se ha insertado de forma correcta
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
        $sql = "SELECT * FROM `TRABAJO` ";
        if (!($resultado = $this->mysqli->query($sql))){ //Si la busqueda no da resultados, se devuelve el mensaje de que no existe
            return 'It does not exist in DB';
        }
        else{ // si existe 
            $result = $resultado; //guarda el valor de resultado en result
            return $result; //devuelve result
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
       			from `TRABAJO`
				where IdTrabajo LIKE '%".$this->IdTrabajo."%' AND
						NombreTrabajo LIKE '%".$this->NombreTrabajo."%' AND
						FechaIniTrabajo LIKE '%".$this->FechaIniTrabajo."%' AND
                        FechaFinTrabajo LIKE '%".$this->FechaFinTrabajo."%' AND
                        PorcentajeNota LIKE '%".$this->PorcentajeNota."%'";
        
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
        $rutas; //almacena las rutas
        $row; //convierte el array en un fetch_array
        $entreg; //crea la ruta de donde se almacena una entrega, concatenando
        $archivo; //crea la ruta de donde se almacena un trabajo, concatenando
        $sql1; //variable que alberga la sentencia sql1

        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `TRABAJO` WHERE (IdTrabajo = '".$this->IdTrabajo."')";
        // se ejecuta la query
        $result = $this->mysqli->query($sql);
        // si existe una tupla con ese valor de clave
        if ($result->num_rows == 1)
        {
            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `TRABAJO` WHERE (IdTrabajo = '".$this->IdTrabajo."')";

            $this->mysqli->query($sql);// se ejecuta la query


            if(substr($this->IdTrabajo,0,2) == 'ET') { //coge la subcadena de IdTrabajo y comprueba que es igual a 'ET'
                $rutas = $this->getRutas();
                while ($row = $rutas->fetch_array()) {  //mientras que convierte el array
                    if($row['Ruta']!=''){ //si el array no es vacio
                        $entreg='/var/www/html/'.substr($row['Ruta'],2); //concatena para crear la ruta a entrega
                        unlink($entreg); //para borrar el archivo
                    } 

                }

                $archivo = '/var/www/html/Files/' . $this->IdTrabajo; //concatena para crear la ruta al archivo
                rmdir($archivo); //borra la carpeta donde esta el archivo
            }
            // se construye la sentencia sql de borrado
            $sql1 = "DELETE FROM `ENTREGA` WHERE (IdTrabajo = '".$this->IdTrabajo."')";

            $this->mysqli->query($sql1);//se ejecuta la query

            return 'Correctly delete';// se devuelve el mensaje de borrado correcto
        } 
        else// si no existe el login a borrar se devuelve el mensaje de que no existe
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
        $sql = "SELECT * FROM `TRABAJO` WHERE IdTrabajo = '".$this->IdTrabajo."'";

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
        $sql = "SELECT * FROM `TRABAJO` WHERE (IdTrabajo = '".$this->IdTrabajo."')";
        
        $result = $this->mysqli->query($sql); // se ejecuta la query

        if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
        {	
            // se construye la sentencia de modificacion en base a los atributos de la clase
            $sql = "UPDATE `TRABAJO` SET 
					NombreTrabajo = '".$this->NombreTrabajo."',
					FechaIniTrabajo = '".$this->FechaIniTrabajo."',
                    FechaFinTrabajo = '".$this->FechaFinTrabajo."',
                    PorcentajeNota = '".$this->PorcentajeNota."'
				WHERE ( IdTrabajo = '".$this->IdTrabajo."'
				)";
            
            if (!($resultado = $this->mysqli->query($sql))){// si hay un problema con la query se envia un mensaje de error en la modificacion
                return 'Unknowed Error';
            }
            else{ // si no hay problemas con la modificación se indica que se ha modificado
                return 'Success Modify';
            }
        }
        else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
            return 'It does not exist in DB';
    } // fin del metodo EDIT


//funcion getRutas
//nos permite obtener las rutas 
    function getRutas(){

        $sql; //variable que alberga la sentencia sql
        $resultado; //almacena la consulta sql
        $result; //almacena el valor de la variable resultado

        // se construye la sentencia de modificacion en base a los atributos de la clase
        $sql = "SELECT ENTREGA.Ruta  FROM ENTREGA WHERE IdTrabajo LIKE '%".$this->IdTrabajo."%' ";

        if (!($resultado = $this->mysqli->query($sql))){// si no se encuentra en la query 
            return 'It does not exist in DB'; //mensaje de que no existe en la bd
        }
        else{// si existe se devuelve la tupla resultado
            $result = $resultado;
            return $result;
        }

    }//fin metodo getRutas

}//fin de clase

?>