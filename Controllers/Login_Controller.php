
<?php
/**
 * Archivo php donde se gestiona las acciones principales para loguearse
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */
session_start();

//Comprueba que si es un POST proveniente de Form de Login
if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){

	$login; //alberga el login

    include '../Functions/Authentication.php';

    if(!IsAuthenticated()){ //si no esta autenticado
        //Devuelve el el formulario para loguearse
        include '../Views/LOGIN.php';
        $login = new Login();
	}else{//si esta autenticado
		//muestra la vista de bienvenida
        include '../Views/Bienvenida.php';
        new Bienvenida();
	}

}
else{ //si no

	$usuario; //crea un objecto del modelo
	$respuesta; //guarda el valor del login

	include '../Models/USUARIOS_Model.php';
	$usuario = new USUARIOS_Model($_REQUEST['login'],'',$_REQUEST['password'],'','','','','','','');
	$respuesta = $usuario->login();

	//Comprueba si el usuario existe y coincide con la contraseña
        if ($respuesta == 'true') {
            $_SESSION['login'] = $_REQUEST['login'];
            include '../Views/Bienvenida.php';
            new Bienvenida();
        }
		else{
			//Si hay algun fallo devuelve el error devuelto por el modelo de datos
			include '../Views/MESSAGE.php';
			new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
		}

}//fin

?>
