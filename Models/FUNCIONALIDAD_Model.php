
<?php

/**
 * Modelo que accede a la base de datos para gestionar las funcionalidades
 * Autor: Ruben -Grupo Imeda
 * Fecha inicio: 27/11/2017
 */

class Funcionalidad_Model { //declaración de la clase

	var $IdFuncionalidad; // declaración del atributo IdFuncionalidad
	var $NombreFuncionalidad; // declaración del atributo NombreFuncionalidad
	var $DescripFuncionalidad; // declaración del atributo DescripFuncionalidad
	var $mysqli; // declaración del atributo manejador de la bd

//Constructor de la clase

function __construct($IdFuncionalidad,$NombreFuncionalidad,$DescripFuncionalidad){
	//asignación de valores de parámetro a los atributos de la clase
	$this->IdFuncionalidad = $IdFuncionalidad;
	$this->NombreFuncionalidad = $NombreFuncionalidad;
	$this->DescripFuncionalidad = $DescripFuncionalidad;
	

	// incluimos la funcion de acceso a la bd
	include '../Models/DB/BdAdmin.php';
	// conectamos con la bd y guardamos el manejador en un atributo de la clase
	$this->mysqli = ConnectDB();

} // fin del constructor


//Metodo ADD()
//Inserta en la tabla  de la bd  los valores de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla
function ADD()
{
	$sql; //variable que alberga la sentencia sql
	$result; //almacena la consulta sql

    if (($this->IdFuncionalidad <> '')){ // si el atributo clave de la entidad no esta vacio
		
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `FUNCIONALIDAD` WHERE (IdFuncionalidad = '$this->IdFuncionalidad')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio 

				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO `FUNCIONALIDAD` (`IdFuncionalidad`,`NombreFuncionalidad`, `DescripFuncionalidad`) 
				VALUES ('".$this->IdFuncionalidad."','".$this->NombreFuncionalidad."', '".$this->DescripFuncionalidad."');";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos el mensaje correspondiente
					
                    return 'Unknowed Error';
				
				}
				else{ //si no da error en la insercion
					return 'Success insert'; //devolvemos mensaje de que la inserccion ha sido correcta
				}
				
			}
			else // si ya existe ese valor de clave en la tabla
				return 'It is already in DB'; // devolvemos un mensaje de que ya existe
		}
    }
    else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
        return 'Introduce a value'; // introduzca un valor para el usuario
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
		$sql = "SELECT * FROM `FUNCIONALIDAD` ";
		if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
			return 'It does not exist in DB'; 
		}
		else{ // si existe se devuelve la tupla resultado
			$result = $resultado;
			return $result;
		}
	} //fin metodo AllData


//funcion SEARCH 
//hace una búsqueda en la tabla con los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	
	$sql; //variable que alberga la sentencia sql
	$resultado; //almacena la consulta sql

	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "SELECT *
       			from `FUNCIONALIDAD`
				where IdFuncionalidad LIKE '%".$this->IdFuncionalidad."%' AND
						NombreFuncionalidad LIKE '%".$this->NombreFuncionalidad."%' AND
						DescripFuncionalidad LIKE '%".$this->DescripFuncionalidad."%' ";
    
    if (!($resultado = $this->mysqli->query($sql))){ // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		return 'Query Error about DB';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH


// funcion DELETE
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
	function DELETE()
	{	
		$sql; //variable que alberga la sentencia sql
		$result; //almacena la consulta sql
		$sql2; //variable que alberga la sentencia sql2

		// se construye la sentencia sql de busqueda con los atributos de la clase
	    $sql = "SELECT * FROM `FUNCIONALIDAD` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";
	    
	    $result = $this->mysqli->query($sql); // se ejecuta la query
	    
	    if ($result->num_rows == 1) // si existe una tupla con ese valor de clave
	    {
	    	// se construye la sentencia sql de borrado
	        $sql = "DELETE FROM `FUNCIONALIDAD` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";
	        
	        if($this->mysqli->query($sql)){ // se ejecuta la query
				$sql2 = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";

				if($this->mysqli->query($sql2)){ // se ejecuta la query
					return "Correctly delete";
				}
			}
	        // se devuelve el mensaje de borrado correcto
	    	return "Correctly delete"; // se devuelve el mensaje de borrado correcto
	    } 
	    else // si no existe el login a borrar se devuelve el mensaje de que no existe
	        return "It does not exist";
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
		$sql = "SELECT * FROM `FUNCIONALIDAD` WHERE IdFuncionalidad = '".$this->IdFuncionalidad."'";
	    
	    if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados
			return 'It does not exist in DB'; // se devuelve el mensaje de que no existe
		}
	    else{ // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos


// funcion EDIT
// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria. Si existe se modifica
	function EDIT()
	{
		$sql; //variable que alberga la sentencia sql
		$result; //almacena la consulta sql
		$resultado; //almacena la consulta sql

		// se construye la sentencia de busqueda de la tupla en la bd
	    $sql = "SELECT * FROM `FUNCIONALIDAD` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";
	    
	    $result = $this->mysqli->query($sql); // se ejecuta la query
		
	    if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
	    {	
	        // se construye la sentencia de modificacion en base a los atributos de la clase
			$sql = "UPDATE `FUNCIONALIDAD` SET 
						NombreFuncionalidad = '".$this->NombreFuncionalidad."',
						DescripFuncionalidad = '".$this->DescripFuncionalidad."'
					WHERE ( IdFuncionalidad = '".$this->IdFuncionalidad."'
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


//funcion fetchAcciones
//recoger todas las acciones en la bd
	function fetchAcciones(){

		$sql; //variable que alberga la sentencia sql
		$resultado; //almacena la consulta sql
		$result; //almacena el valor de la variable resultado

		//Creamos a la sentencia sql para recoger las acciones
		$sql = "SELECT * FROM `ACCION` ";

		if (!($resultado = $this->mysqli->query($sql))){ //Si existe algun error al ejecutar la sentecia
			return 'It does not exist in DB'; //  se envia mensaje de que no existe en la bd
		}
		else{ // si existe se devuelve la tupla resultado
			$result = $resultado;
			return $result;
		}
	}//fin metodo fetchAcciones


//funcion fetchAccionesUsu
//funcion que recoge las acciones asignadas a una funcionalidad
	function fetchAccionesUsu(){

		$sql; //variable que alberga la sentencia sql
		$resultado; //almacena la consulta sql
		$result; //almacena el valor de la variable resultado

		//Creamos a la sentencia sql para recoger las acciones
		$sql = "SELECT IdAccion FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";
		
		if (!($resultado = $this->mysqli->query($sql))){ //Si existe algun error al ejecutar la sentecia 
			return 'It does not exist in DB'; // se envia mensaje de que no existe en la bd
		}
		else{ // si existe se devuelve la tupla resultado
			$result = $resultado;
			return $result;
		}
	}//fin metodo fetchAccionesUsu


//funcion delAccionFun 
//elimina las acciones de una funcionalidad
	function delAccionFun(){

		$sql; //variable que alberga la sentencia sql
		$result; //almacena la consulta sql

		//Creamos a la sentencia sql para eliminar las acciones
		$sql = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."') ";
		
		if ($result = $this->mysqli->query($sql)) { //si se ejecuta la query satisfactoriamente
			return 'Success delete'; //se muestra mensaje de que se borro correctamente
		}else{ //si no se ejecuto correctamente
			return 'Unknowed Error'; //muestra un mensaje de error
		}
	}//fin metodo delAccionFun


//funcion setAccion
//inserta una accion con una funcionalidad
	function setAccion($id){

		$sql; //variable que alberga la sentencia sql
		$result; //almacena la consulta sql

		//Creamos a la sentencia sql para insertar la accion con una funcionalidad
		$sql = "INSERT INTO `FUNC_ACCION` (`IdAccion`,`IdFuncionalidad`) VALUES ('".$id."','".$this->IdFuncionalidad."');";
		
		if ($result = $this->mysqli->query($sql)) {//si se ejecuta la query satisfactoriamente
			return 'Success insert'; //se muestra mensaje de que se inserto correctamente
		} else{ //si no se ejecuto correctamente
			return 'Unknowed Error'; //muestra mensaje de error
		}
		
	}

}//fin de clase

?> 
