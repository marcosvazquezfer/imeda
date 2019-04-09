<?php
/**
 * Modelo que accede a la base de datos para gestionar las entregas
 * Created by PhpStorm.
 * Autor: Mauri
 * Fecha inicio: 07/11/2017
 * Fecha fin:19/11/2017
 */

class ENTREGA_Model{ //declaración de la clase

    var $login; //declaración del atributo login
    var $IdTrabajo; //declaración del atributo IdTrabajo
    var $Alias; //declaración del atributo Alias
    var $Horas; //declaración del atributo Horas
    var $Ruta; //declaración del atributo Ruta
    var $mysqli; //declaración del atributo manejador de la bd


    //Constructor de la clase
    function __construct($login, $IdTrabajo, $Alias, $Horas, $Ruta)
    {

        //asignación de valores de parámetro a los atributos de la clase
        $this->login = $login;
        $this->IdTrabajo = $IdTrabajo;
        $this->Alias = $Alias;
        $this->Horas = $Horas;
        $this->Ruta = $Ruta;

        // incluimos la funcion de acceso a la bd
        include '../Models/DB/BdAdmin.php';
        // conectamos con la bd y guardamos el manejador en un atributo de la clase
        $this->mysqli = ConnectDB();

    } // fin del constructor




    //Inserta en la tabla de la bd los valores de los atributos del objeto.
    //Comprueba si la clave/s esta vacia y si existe ya en la tabla
    function ADD()
    {
        $sql; //almacena consulta SQL sobre la tabla ENTREGA tanto consulta como inserción
        $sql2; //almacena consulta SQL sobre la tabla TRABAJO
        $sql3; //almacena consulta SQL sobre la tabla USUARIO
        $result; //almacena resultado consulta de la tabla ENTREGA
        $result2; //almacena resultado consulta de la tabla TRABAJO
        $result3; //almacena resultado consulta de la tabla USUARIO

        if (($this->IdTrabajo <> '')) { // si el atributo clave de la entidad no esta vacio

            // construimos el sql para ver si ya existe un trabajo con esas claves
            $sql = "SELECT * FROM `ENTREGA` where   IdTrabajo LIKE '%" . $this->IdTrabajo . "%' AND login LIKE '%" . $this->login . "%'";

            // construimos el sql2 para buscar las IdTrabajos existentes
            $sql2="SELECT * FROM TRABAJO WHERE IdTrabajo = '$this->IdTrabajo'";

            // construimos el sql para ver si existe el login en la tabla usuario
            $sql3="SELECT * FROM USUARIO WHERE login = '$this->login'";

            // si da error la ejecución de la query devolvemos mensaje
            if (!($result = $this->mysqli->query($sql)) || !($result2 = $this->mysqli->query($sql2)) || !($result3 = $this->mysqli->query($sql3))) {

                return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara

            } else { // si la ejecución de la query no da error

                //Si no existe una entrega con este login e IdTrabajo y existe tanto el login como el trabajo realizamos la insercion
                if ((($result->num_rows == 0) && ($result2->num_rows == 1) && ($result3->num_rows == 1))) {

                    //construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO `ENTREGA` (`login`,`IdTrabajo`, `Alias`,`Horas`,`Ruta`) 
            VALUES ('" . $this->login . "','" . $this->IdTrabajo . "', '" . $this->Alias . "', '" . $this->Horas . "', '" . $this->Ruta . "')";


                    //si da error en la ejecución del insert devolvemos mensaje
                    //sino devolvemos mensaje de exito
                    if (!$this->mysqli->query($sql)) {
                        return 'Unknowed Error';

                    }else{

                        //si ruta no es vacio
                        if($this->Ruta !=''){
                            move_uploaded_file($_FILES['Ruta']['tmp_name'],$this->Ruta); //mueve archivo a la carpeta definida
                        }
                        return 'Success insert';
                    }

                } else { // si ya existe la entrega o no existe el trabajo o login
                    if ($result2->num_rows != 1) { //si no existe el trabajo
                        return 'No existe un trabajo con esa ID';
                    } else {
                        //si no existe un usuario con ese login
                        if ($result3->num_rows != 1) {
                            return 'No existe un usuario con ese Login';
                        } else { //si no se da ninguno de los casos anteriores
                            return 'It is already in DB';
                        }
                    }
                }
            }
        } else { //si el atributo clave de la bd es vacio
            return 'Introduce a value'; //solicitamos que introduzca un valor para el usuario
        }
    } // fin del metodo ADD


//funcion de destrucción del objeto: se ejecuta automaticamente
//al finalizar el script
    function __destruct()
    {

    } // fin del metodo destruct



    //Devuelve tupla de la Tabla ENTREGA en funcion de un IdTrabajo
    function AllData2()
    {
        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda
        $result; //almacenará el valor de la busqueda pasado por resultado

        // construimos la sentencia SQL
        $sql = "SELECT * FROM `ENTREGA` WHERE IdTrabajo LIKE '%" . $this->IdTrabajo . "%'";

        //Si la busqueda no da resultados, se muestra mensaje
        if (!($resultado = $this->mysqli->query($sql))) {

            return 'It does not exist in DB';

        } else { // si existe se guarda el resultado de la consulta en result y se retorna
            $result = $resultado;
            return $result;
        }
    }//fin funcion AllData2




    //devuelve los datos de toda la tabla
    function AllData()
    {
        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda
        $result; //almacenará el valor de la busqueda pasado por resultado

        // construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `ENTREGA` ";

        //Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))) {
            return 'It does not exist in DB';
        } else { // si existe se guarda el resultado de la consulta en result y se retorna
            $result = $resultado;
            return $result;
        }
    }//fin funcion AllData


//funcion SEARCH:
//Realiza una búsqueda en la tabla con los datos proporcionados.
    function SEARCH()
    {
        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda

        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
        $sql = "SELECT *
                 from `ENTREGA`
            where   IdTrabajo LIKE '%" . $this->IdTrabajo . "%' AND
                    login LIKE '%" . $this->login . "%' AND
                  Horas LIKE '%" . $this->Horas . "%' AND
                  Ruta LIKE '%" . $this->Ruta . "%' AND
                  Alias LIKE '%" . $this->Alias . "%'";

        // Si la busqueda no da resultados, se devuelve el mensaje de error de consulta
        if (!($resultado = $this->mysqli->query($sql))) {
            return 'Query Error about DB';

        } else { // si la busqueda es correcta devolvemos resultado
            return $resultado;
        }
    } // fin metodo SEARCH



//funcion SearchEntregas:
//Realiza una búsqueda en la tabla por el valor de la clave para buscar entregas, si existe devuelve el valor y si no
//muestra un mensaje de error
    function SearchEntregas()
    {

        // construimos la sentencia de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `ENTREGA` WHERE login LIKE '%" . $this->login . "%' AND
                  IdTrabajo LIKE '%" . $this->IdTrabajo . "%'";

        // Si la busqueda no da resultados, se devuelve el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))) {

            return 'Query Error about DB';

        } else { // si la busqueda es correcta devolvemos  resultado
            return $resultado;
        }
    } // fin metodo SearchEntregas






// función DELETE():
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
    function DELETE()
    {
        $sql; //almacena sentencia sql
        $result; //almacena resultado busqueda sql
        $archivo; // ruta absoluta de la entrega almacenada en la BD

        // se construye la sentencia sql de busqueda con los atributos de la clase
        $sql = "SELECT * FROM `ENTREGA` WHERE IdTrabajo = '" . $this->IdTrabajo . "' AND login = '" . $this->login ."' ";

        // se ejecuta la query
        $result = $this->mysqli->query($sql);

        // si existe una entrega con esa IdTrabajo y ese login realizamos el DELETE
        if ($result->num_rows == 1) {

            // se construye la sentencia sql de borrado
            $sql = "DELETE FROM `ENTREGA` WHERE IdTrabajo = '" . $this->IdTrabajo . "' AND login = '" . $this->login ."'";

            // se ejecuta la query
            $this->mysqli->query($sql);

            //si Ruta no está vacio
            if($this->Ruta!=''){

                $archivo='/var/www/html/' . substr($this->Ruta,2); //obtenemos la ruta absoluta

                //se elimina el archivo
                unlink($archivo);
            }
            return 'Correctly delete';
        } // si no existe el login a borrar se devuelve el mensaje de que no existe
        else
            return 'It does not exist in DB';
    } // fin metodo DELETE




    // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
    // en el atributo de la clase
    function RellenaDatos()
    {

        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda sql
        $result; //almacena valor de resultado

        // se construye la sentencia de busqueda de la tupla
        $sql = "SELECT * FROM `ENTREGA` WHERE login LIKE '%" . $this->login . "%' AND
                  IdTrabajo LIKE '%" . $this->IdTrabajo . "%'";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))) {
            return 'It does not exist in DB';

        } else { // si existe se devuelve la tupla resultado
            $result = $resultado->fetch_array();
            return $result;
        }
    } // fin del metodo RellenaDatos()


    // funcion getFechasFin()
    // Esta función obtiene de la bd los valores de FechaFinTrabajo de la tabla Trabajo
    function getFechasFin(){

        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda sql
        $result; //almacena valor de resultado

        // se construye la sentencia sql
        $sql = "SELECT * FROM TRABAJO WHERE IdTRABAJO LIKE '%".$this->IdTrabajo."%' ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{// si existe se devuelve la tupla resultado de clave FechaFinTrabajo
            $result = $resultado->fetch_assoc();
            return $result['FechaFinTrabajo'];
        }

    }


    // funcion getFechasIni()
    // Esta función obtiene de la bd los valores de FechaFinTrabajo de la tabla Trabajo
    function getFechasIni(){

        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda sql
        $result; //almacena valor de resultado

        // se construye la sentencia sql
        $sql = "SELECT * FROM TRABAJO WHERE IdTRABAJO LIKE '%".$this->IdTrabajo."%' ";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{// si existe se devuelve la tupla resultado de clave FechaIniTrabajo
            $result = $resultado->fetch_assoc();
            return $result['FechaIniTrabajo'];
        }

    }

    // funcion DevolverUsuarios()
    // Esta función obtiene de la bd los datos de un usuario partiendo de un login
    function DevolverUsuarios()
    {

        $sql; //almacena sentencia sql
        $resultado; //almacena resultado busqueda sql
        $fila; //array que almacena valor de la consulta
        $filas; //fetch de resultado
        $i; //indice

        // se construye la sentencia sql
        $sql = "SELECT login
                 from USUARIO
            where login LIKE '%".$this->login."%'";

        // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
        if (!($resultado = $this->mysqli->query($sql))) {
            return 'It does not exist in DB';
        } else {

            $i = 0; //inicializamos a 0 el indice
            $fila = array(); //creamos array

            //convertimos el resultado en un fetch array
            //mientras tenga filas introducimos en fila los valores
            while ($filas = $resultado->fetch_assoc()) {
                $fila[$i] = $filas;
                $i++;
            }

            return $fila;


        }

    }




    // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
    // si existe se modifica
    function EDIT()
    {
        $sql;  //almacena consulta sobre la tabla TRABAJO
        $sql2; //almacena consulta update sobre la tabla ENTREGA
        $resultado; //almacena resultado de la consulta sql2
        $result; //almacena resultado de la consulta sql
        $antiguaRuta; //fecth de result
        $archivo; // ruta absoluta de la entrega almacenada en la BD

        // se construye la sentencia de busqueda de la tupla en la bd
        $sql = "SELECT * FROM `ENTREGA` WHERE login LIKE '%" . $this->login . "%' AND
						IdTrabajo LIKE '%" . $this->IdTrabajo . "%'";

        // se ejecuta la query
        $result = $this->mysqli->query($sql);

        // si el numero de filas es igual a uno es que lo encuentra
        if ($result->num_rows == 1) {    // se construye la sentencia de modificacion en base a los atributos de la clase

            $sql2 = "UPDATE `ENTREGA` SET 
					Alias = '" . $this->Alias . "',
					Ruta = '" . $this->Ruta . "',
					Horas = '" . $this->Horas . "'
				WHERE ( IdTrabajo = '" . $this->IdTrabajo . "') AND ( login = '" . $this->login . "')";
            // si hay un problema con la query se envia un mensaje de error en la modificacion
            if (!($resultado = $this->mysqli->query($sql2))) {
                return 'Unknowed Error';
            } else { // si no hay problemas con la modificación se indica que se ha modificado

                //si la Ruta de la Entrega no está vacia y es distinta de la nueva Ruta
                $antiguaRuta=$result->fetch_assoc(); //convertimos antiguaRuta en un fetch de result
                if($antiguaRuta['Ruta']!='' && $antiguaRuta['Ruta']!=$this->Ruta){
                    $archivo='/var/www/html/'.substr($antiguaRuta['Ruta'],2);
                    unlink($archivo);
                }
                //movemos el Archivo a la ruta especifica el atributo Ruta
                move_uploaded_file($_FILES['Ruta']['tmp_name'],$this->Ruta);
                return 'Success Modify';
            }
        } else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
            return 'It does not exist in DB';
    } // fin del metodo EDIT



    //crea la entrega para un usuario y un Trabajo y le asigna un Alias
    function generarEntregas()
    {
        $indice;//guarda los 2 primeros caracteres de IdTrabajo
        $sql2; //almacena consulta sobre la tabla TRABAJO
        $sql3; //almacena consulta sobre la tabla USUARIO
        $sql4; //almacena consulta sobre la tabla ENTREGA
        $resultado; //almacena resultado de la consulta sql4
        $resultado2; //almacena resultado de la consulta sql2
        $resultado3; //almacena resultado de la consulta sql3

        $sql2="SELECT * FROM TRABAJO WHERE IdTrabajo = '$this->IdTrabajo'";
        $sql3="SELECT * FROM USUARIO WHERE login = '$this->login'";
        $resultado2 = $this->mysqli->query($sql2);
        $resultado3 = $this->mysqli->query($sql3);
        $indice = substr($this->IdTrabajo, 0, 2);

        //si indice es igual a la cadena ET
        if ($indice == 'ET') {

            //si ambas consultas devuelven una fila
            if($resultado2->num_rows ==1 && $resultado3->num_rows ==1){

                //inserta la ENTREGA con el login del usuario, la IdTrabajo y el Alias generado
                $sql4 = "INSERT INTO `ENTREGA` (`login`,`IdTrabajo`, `Alias`, `Horas`, `Ruta`) 
            
            VALUES ('".$this->login."','".$this->IdTrabajo."', '".$this->generateRandomString(6)."', '', '')";
                $resultado = $this->mysqli->query($sql4);

            }

        }
    }


    //devuelve los trabajos
    function getTrabajos(){

        $sql; //almacena la consulta SQL
        $resultado; //almacena el resultado de la consulta SQL
        $trabajos; //guarda el valor de resultado

        //consulta sobre TRABAJO
        $sql = "SELECT * FROM `TRABAJO` WHERE 1";
        // si da error la ejecución de la query devolvemos mensaje error
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else{ // si existe se guarda el resultado de la consulta en trabajos y se retorna
            $trabajos=$resultado;
            return $trabajos;
        }
    }

    //devuelve true si existe una entrega para un usuario y para un determinado trabajo
    function EntregaCreada(){

        $sql; //almacena la consulta SQL
        $resultado; //almacena el resultado de la consulta SQL

        //consulta sobre ENTREGA
        $sql = "SELECT * FROM `ENTREGA` WHERE login LIKE '%" . $this->login . "%' AND
                  IdTrabajo LIKE '%" . $this->IdTrabajo . "%'";

        // si da error la ejecución de la query devolvemos falso
        if (!($resultado = $this->mysqli->query($sql))) {
            return false;
        }else{
            //si la consulta devuelve una fila retornamos true
            //sino falso
            if($resultado->num_rows ==1){
                return true;
            }else{
                return false;
            }
        }
    }

    //Genera cadena aleatoria de un tamaño pasado como parametro
    function generateRandomString($length) {
        $characters; //almacena los posibles valores que puede tomar el String a devolver
        $charactersLength; //obtiene la longitud de la cadena characters
        $randomString;//almacena la cadena aleatoria a devolver


        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


        $charactersLength = strlen($characters);


        $randomString = '';

        //asigna un carcarter a la variable randomString hasta el tamaño solicitado
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    //Devuelve los valores de la tabla TRABAJO
    function fetchIdTrabajo(){

        $sql; //almacena la consulta SQL
        $resultado; //almacena el resultado de la consulta SQL
        $result; //guarda el valor de resultado

        //sql que almacena la consulta
        $sql = "SELECT * FROM `TRABAJO`";

        // si da error la ejecución de la query
        //sino devolvemos resultado
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se guarda el resultado de la consulta en result y se retorna
            $result = $resultado;
            return $result;
        }

    }


    //Devuelve los valores de la tabla Usuario
    function fetchLogin(){

        $sql; //almacena la consulta SQL
        $resultado; //almacena el resultado de la consulta SQL
        $result; //guarda el valor de resultado

        //sql que almacena la consulta
        $sql = "SELECT * FROM `USUARIO`";

        // si da error la ejecución de la query
        //sino devolvemos resultado
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB';
        }
        else{ // si existe se guarda el resultado de la consulta en result y se retorna
            $result = $resultado;
            return $result;
        }

    }





}//fin de clase

?>

