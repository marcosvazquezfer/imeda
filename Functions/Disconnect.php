<?php
/*
Alex -Grupo Imeda
11/11/2017
Archivo php donde se se desconecta a un usuario logueado
*/
session_start();
session_destroy();
header('Location: ../index.php');

?>
