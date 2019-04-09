
<?php

/**
 * Modelo que accede a la base de datos para gestionar un usuario
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */
class USUARIOS_Model { //declaración de la clase

	var $login; // declaración del atributo login
	var $DNI; // declaración del atributo DNI
	var $password; // declaración del atributo password
	var $correouser; // declaración del atributo edad
	var $nombreuser; // declaración del atributo hora nacimiento usuario
	var $apellidouser; // declaración del atributo apellido
	var $telefono; // declaración del atributo telefono
	var $direccion; // declaración del atributo direccion
	var $mysqli; // declaración del atributo manejador de la bd

//Constructor de la clase
//

function __construct($login,$DNI,$password,$correouser,$nombreuser,$apellidouser,$telefono,$direccion){
	//asignación de valores de parámetro a los atributos de la clase
	$this->login = $login;
	$this->DNI = $DNI;
	$this->password = $password;
	$this->correouser = $correouser;
	$this->nombreuser = $nombreuser;
	$this->apellidouser = $apellidouser;
	$this->telefono = $telefono;
	$this->direccion = $direccion;

	

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

    if (($this->login <> '')){ // si el atributo clave de la entidad no esta vacio
		
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `USUARIO` WHERE (login = '$this->login')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO `USUARIO` (`login`,`DNI`, `password`,`Correo`, `Nombre`, `Apellidos`,
				 `Telefono`, `Direccion`) 
				VALUES ('".$this->login."','".$this->DNI."', '".$this->password."','".$this->correouser."', '".$this->nombreuser."',
				 '".$this->apellidouser."', '".$this->telefono."', '".$this->direccion."');";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Unknowed Error';
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
                    $sql2 = "INSERT INTO `USU_GRUPO` (`login`,`IdGrupo`) 
				VALUES ('".$this->login."','2')";
                    $this->mysqli->query($sql2);
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
	$sql = "SELECT * FROM `USUARIO` ";

	if (!($resultado = $this->mysqli->query($sql))){//Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		return 'It does not exist in DB'; 
	}
	else{ // si existe 
		$result = $resultado;//guarda el valor deresultado en result
		return $result; //devuelve result
	}
}//fin metodo AllData


//funcion SEARCH 
//hace una búsqueda en la tabla con los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	
	$sql; //variable que alberga la sentencia sql
    $resultado; //almacena la consulta sql
	
	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "SELECT *
       			from `USUARIO`
				where login LIKE '%".$this->login."%' AND
						DNI LIKE '%".$this->DNI."%' AND
						Password LIKE '%".$this->password."%' AND
						Correo LIKE '%".$this->correouser."%' AND
						Nombre LIKE '%".$this->nombreuser."%' AND
						Apellidos LIKE '%".$this->apellidouser."%' AND
						Telefono LIKE '%".$this->telefono."%' AND
						Direccion LIKE '%".$this->direccion."%'";
    
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

	// se construye la sentencia sql de busqueda con los atributos de la clase
    $sql = "SELECT * FROM `USUARIO` WHERE (login = '".$this->login."')";
    
    $result = $this->mysqli->query($sql);// se ejecuta la query
    
    if ($result->num_rows == 1) // si existe una tupla con ese valor de clave
    {
    	// se construye la sentencia sql de borrado
        $sql = "DELETE FROM `USUARIO` WHERE (login = '".$this->login."')";
        
        $this->mysqli->query($sql);// se ejecuta la query
        
    	return "Correctly delete";// se devuelve el mensaje de borrado correcto
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
	$sql = "SELECT * FROM `USUARIO` WHERE login = '".$this->login."'";
    
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
    $sql2; //variable que alberga la sentencia sql2
    $resultado; //almacena la consulta sql

	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM `USUARIO` WHERE (login = '".$this->login."')";
    
    $result = $this->mysqli->query($sql);// se ejecuta la query
	
    if ($result->num_rows == 1) // si el numero de filas es igual a uno es que lo encuentra
	{	
		// se construye la sentencia de modificacion en base a los atributos de la clase
		$sql2 = "UPDATE `USUARIO` SET 
					DNI = '".$this->DNI."',
					password = '".$this->password."',
					Nombre= '".$this->nombreuser."',
					Apellidos = '".$this->apellidouser."',
					Telefono = '".$this->telefono."',
					Direccion = '".$this->direccion."',
					Correo = '".$this->correouser."'
				WHERE ( login = '".$this->login."'
				)";
		
        if (!($resultado = $this->mysqli->query($sql2))){ // si hay un problema con la query se envia un mensaje de error en la modificacion
				return 'Unknowed Error';
		}
		else{ // si no hay problemas con la modificación se indica que se ha modificado

			return 'Success Modify';
		}
    }
    else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
    	return 'It does not exist in DB';
} // fin del metodo EDIT


// funcion login
//realiza la comprobación de si existe el usuario en la bd y despues si la pass es correcta para ese usuario. 
//Si es asi devuelve true, en cualquier otro caso devuelve el  error correspondiente
function login(){

	$sql; //variable que alberga la sentencia sql
    $resultado; //almacena la consulta sql
    $tupla; //almacena la tupla correspondiente

	// se construye la sentencia para buscar el usuario en base de datos
	$sql = "SELECT *
			FROM `USUARIO`
			WHERE login = '".$this->login."'";

	$resultado = $this->mysqli->query($sql); // se ejecuta la query

	if ($resultado->num_rows == 0){ //Si el resultado es 0 el usuario no existe y se envia el mensaje correspondiente
		return 'User does not exists';
	}
	else{ //Si existe   
		$tupla = $resultado->fetch_array();
		if ($tupla['password'] == $this->password){ //se comprueba que el password es correcto
			return true;
		}
		else{ //si no existe envia un mensaje de error
			return 'Incorrect password for this login';
		}
	}
}//fin metodo login


//funcion Register 
//se encarga de loguear a un usuario en la aplicacion
function Register(){

	$sql; //variable que alberga la sentencia sql
    $result; //almacena la consulta sql

		// se construye la sentencia para buscar el usuario en base de datos
		$sql = "SELECT * from `USUARIO` where login = '".$this->login."'";

		$result = $this->mysqli->query($sql); //se ejecut la query
		if ($result->num_rows == 1){  //si el resultado es 1 existe el usuario y se envia el mensaje correspondiente
				return 'User already exists';
		}
		else{ //si no existe 
				return true; //retorna true para que se registre
		}

}//fin metodo Register


//funcion registrar 
//añade un nuevo usuario a la base de datos
function registrar(){

	$sql; //variable que alberga la sentencia sql
    $result; //almacena la consulta sql

	if (($this->login <> '')){ // si el atributo clave de la entidad no esta vacio
		
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM `USUARIO` WHERE (login = '$this->login')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'It is not possible connect to DB'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)

				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO `USUARIO` (`login`,`DNI`, `password`, `Correo`, `Nombre`, `Apellidos`,
				 `Telefono`, `Direccion`) 
				VALUES ('".$this->login."','".$this->DNI."', '".$this->password."','".$this->correouser."', '".$this->nombreuser."',
				 '".$this->apellidouser."', '".$this->telefono."', '".$this->direccion."');";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					if($this->mysqli->error == "Duplicate entry 'alcado94@hotmail.com' for key 'email'") //si esta email duplicado
						return 'Duplicate email';
					else if($this->mysqli->error == "Duplicate entry '45671234A' for key 'DNI'"){ //si esta DNI duplicado
						return 'Duplicate DNI';
					}else{ //si no esta nada duplicado manda mensaje de error
						return 'Unknowed Error';
					}
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
                    $sql2 = "INSERT INTO `USU_GRUPO` (`login`,`IdGrupo`) 
				VALUES ('".$this->login."','2')";
                    $this->mysqli->query($sql2);
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
	
}//fin metodo registrar


//funcion fetchGrupos 
//se encarga de recoger todos los grupo existentes en la base de datos
function fetchGrupos(){

	$sql; //variable que alberga la sentencia sql
    $resultado; //almacena la consulta sql
    $result; //almacena el valor de la variable resultado

	//Se crea la sentecia para recoger todos los grupos
	$sql = "SELECT * FROM `GRUPO` ";

	if (!($resultado = $this->mysqli->query($sql))){ //si al ejecutar la queryno se encuentra el resultado
		return 'It does not exist in DB'; // mensaje de que no existe en la bd
	}
	else{ // si existe se devuelve la tupla resultado
		$result = $resultado;
		return $result;
	}
}//fin metodo fetchGrupos


//funcion fetchGruposUsu
//recoge los grupos correspondientes a un usuario
function fetchGruposUsu(){

	$sql; //variable que alberga la sentencia sql
    $resultado; //almacena la consulta sql
    $result; //almacena el valor de la variable resultado

	//Se crea la sentecia para recoger todos los grupos al que pertence el usuario
	$sql = "SELECT IdGrupo FROM `USU_GRUPO` WHERE (login = '".$this->login."')";
	
	if (!($resultado = $this->mysqli->query($sql))){ //si al ejecutar la queryno se encuentra el resultado
		return 'It does not exist in DB'; //mensaje de que no existe en la bd
	}
	else{ // si existe se devuelve la tupla resultado
		$result = $resultado;
		return $result;
	}
}//fin metodo fetchGruposUsu


//funcion delGruposUsu 
//elimina los grupos de un usuario
function delGrupoUsu(){

	$sql; //variable que alberga la sentencia sql
    $result; //almacena la consulta sql

	//Se crea la sentencia para el borrado de grupos
	$sql = "DELETE FROM `USU_GRUPO` WHERE (login = '".$this->login."') ";
	
	if ($result = $this->mysqli->query($sql)) { //se ejecuta la query
		return 'Success delete'; //mensaje de que se produjo correctamente el borrado
	}else{ //si se produce un error
		return 'Unknowed Error'; //mensaje correspondiente
	}
} //fin metodo delGrupoUsu


//funcion setGrupo 
//inserta un usuario con un grupo existente
function setGrupo($id){

	$sql; //variable que alberga la sentencia sql
    $result; //almacena la consulta sql

	//Se crea la sentencia sql para la insercion en USU_GRUPO del usuario y del grupo
		$sql = "INSERT INTO `USU_GRUPO` (`IdGrupo`,`login`) VALUES ('".$id."','".$this->login."');";
		
		if ($result = $this->mysqli->query($sql)) { //se ejecuta la query
			return 'Success insert'; //mensajede que la inserccion se ha realizado con exito
		} else{ //si se produce algun error
			return 'Unknowed Error'; //mensaje correspondiente
		}

}//fin metodo setGrupo

}//fin de clase

?> 
