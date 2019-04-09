<?php
/**
 * Archivo php donde se gestiona las acciones principales para un grupo
 * Created by PhpStorm.
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 28/11/2017
 * Fecha fin:28/11/2017
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';

if (!IsAuthenticated()){ //si no está autenticado

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php'); //muestra el mensaje

}else{ //si lo está


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/GRUPO_Model.php');
    include '../Views/Grupo/GRUPO_SHOWALL.php';
    include '../Views/Grupo/GRUPO_ADD.php';
    include '../Views/Grupo/GRUPO_SEARCH.php';
    include '../Views/Grupo/GRUPO_SHOWCURRENT.php';
    include '../Views/Grupo/GRUPO_EDIT.php';
    include '../Views/Grupo/GRUPO_DELETE.php';


    function get_data_form(){ //recoge los valores del formulario

        $IdGrupo= $_REQUEST['IdGrupo']; //Variable para el id del grupo
        $NombreGrupo = $_REQUEST['NombreGrupo']; //Variable para el nombre del grupo
        $DescripGrupo = $_REQUEST['DescripGrupo']; //Variable para la descripcion del grupo
        $action = $_REQUEST['action']; //Variable action para la accion a realizar

        //crea un grupo
        $GRUPO = new GRUPO_Model(
            $IdGrupo,
            $NombreGrupo,
            $DescripGrupo);

        return $GRUPO;
    }

    if (!isset($_REQUEST['action'])){ //si no hay accion, la asigna vacía
        $_REQUEST['action'] = '';
    }

    $Permi = new PERMISO_Modelo('','',''); //Crea permiso

    
    Switch ($_REQUEST['action']){ //switch case que controla las acciones

        //acción añadir
        case 'ADD':

            $GRUPO; //coge los valores del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje

            if($Permi->check('GRUPO','ADD', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si es por get envia un formulario para insertar grupo
                    new GRUPO_ADD();
                }
                else{//Sino recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $GRUPO = get_data_form();
                    $respuesta = $GRUPO->ADD();
                    new MESSAGE($respuesta, '../Controllers/Grupo_Controller.php');
                }
                break;
            }
            else{ //si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $GRUPO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos
            
            if($Permi->check('GRUPO','DELETE', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos del grupo que se quiere borrar
                    $GRUPO = new GRUPO_Model($_REQUEST['IdGrupo'], '', '');
                    $valores = $GRUPO->RellenaDatos();
                    new GRUPO_DELETE($valores);
                }
                else{//Si entra por post envía los datos del grupo que se quiere borrar a la BD y manda mensaje
                    $GRUPO = new GRUPO_Model($_REQUEST['IdGrupo'], '', '');
                    $respuesta = $GRUPO->DELETE();
                    new MESSAGE($respuesta, '../Controllers/Grupo_Controller.php');
                }
                break;
            }
            else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción editar
        case 'EDIT':

            $GRUPO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('GRUPO','EDIT', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos del grupo que se quiere editar

                    $GRUPO = new GRUPO_Model($_REQUEST['IdGrupo'], '', '');
                    $valores = $GRUPO->RellenaDatos();
                    new GRUPO_EDIT($valores);
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $GRUPO = get_data_form();
                    $respuesta = $GRUPO->EDIT();
                    new MESSAGE($respuesta, '../Controllers/Grupo_Controller.php');
                }
                break;
            }
            else{ //sino tiene permisos muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción buscar
        case 'SEARCH':

            $GRUPO; //coge los valores del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos que busca
            $lista; //crea un array de los datos

            if($Permi->check('GRUPO','SEARCH', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario para buscar por los diferentes campos que tiene un grupo
                    new GRUPO_SEARCH();
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $GRUPO = get_data_form();
                    $datos = $GRUPO->SEARCH();
                    $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
                    new GRUPO_SHOWALL($lista, $datos, '../Controllers/GRUPO_Controller.php');
                }
                break;
            }
            else{ //sino tiene permisos muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $GRUPO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('GRUPO','SHOWCURRENT', $_SESSION['login'])){ //si tiene permiso
                //Envia los datos del grupo que se quiere ver en detalle
                $GRUPO = new GRUPO_Model($_REQUEST['IdGrupo'],'', '');
                $valores = $GRUPO->RellenaDatos();
                new GRUPO_SHOWCURRENT($valores);
                break;
            }
            else{ //sino tiene permisos muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        default:

            $GRUPO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos
            $lista; //crea un array de los datos

            if($Permi->check('GRUPO','SHOWALL', $_SESSION['login'])){ //si tiene permiso
                
                if (!$_POST){ //Si entra por get muestra vista SHOWALL 
                    $GRUPO = new GRUPO_Model('','','');
                }
                else{ //Si entra por post muestra SHOWALL con el atributo designado
                    $GRUPO = new GRUPO_Model($_REQUEST['IdGrupo'], '', '');
                }

                //lo hace de todas formas
                $datos = $GRUPO->AllData();
                $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
                new GRUPO_SHOWALL($lista, $datos, '../Controllers/Grupo_Controller.php');
            }
            else{ //sino tiene permisos muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

    }

}
?>