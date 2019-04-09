<?php

/*
function IsAuthenticated()
Alex -Grupo Imeda
11/11/2017
Esta función valida si existe la variable de session login
Si no existe devuelve falso
Si existe devuelve true
*/
	
//Valida si existe la variable de session login
function IsAuthenticated(){

	//si no existe la variable $_SESSION retorna falso
	//sino devuelve true
	if (!isset($_SESSION['login'])){
		return false;
	}
	else{
		return true;
	}
} //end of function IsAuthenticated()
?>

