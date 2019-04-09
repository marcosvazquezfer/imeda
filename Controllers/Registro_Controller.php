
<?php

/**
 * Archivo php donde se gestionan las acciones principales para el registro
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se gestiona el registro de un nuevo usuario, Autor: IMEDA, Fecha: 29/11/2017
session_start();


if(!isset($_POST['login'])){ //si no existe el login

	$register; //guarda el valor de registrar

	include '../Views/REGISTRO.php';
	$register = new Register();
}
else{//si existe
		
	$usuario; //crea un objecto del model
	$respuesta; //guarda el valor del usuario registrado

	include '../Models/USUARIOS_Model.php';
	$usuario = new USUARIOS_Model($_REQUEST['login'],$_REQUEST['DNI'],$_REQUEST['password'],$_REQUEST['Correo'],$_REQUEST['Nombre'],$_REQUEST['Apellidos'],$_REQUEST['Telefono'],$_REQUEST['Direccion']);
	$respuesta = $usuario->Register();

	Include '../Views/MESSAGE.php';

	if ($respuesta == 'true'){ //si esta registrado muestra mensaje correspondiente
		$respuesta = $usuario->registrar();
		
		new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
	}
	else{ //si no esta registrado muestra otro mensaje correspondiente a este caso
		new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
	}

}

?>

