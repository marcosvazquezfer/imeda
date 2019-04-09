<?php
/*
Alex -Grupo Imeda
11/11/2017
Archivo php donde se gestiona el cambio de idioma
*/
session_start();
$idioma = $_POST['idioma'];
$_SESSION['idioma'] = $idioma;
header('Location:' . $_SERVER["HTTP_REFERER"]);
?>



