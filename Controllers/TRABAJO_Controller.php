<?php
/**
 * Archivo php donde se gestiona las acciones principales para un trabajo
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 03/12/2017
 * Fecha fin: 03/12/2017
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';

if (!IsAuthenticated()){ //si no esta autenticado

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php'); //muestra mensaje

}else{ //si lo esta


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/TRABAJO_Model.php');
    include '../Views/Trabajo/TRABAJO_SHOWALL.php';
    include '../Views/Trabajo/TRABAJO_ADD.php';
    include '../Views/Trabajo/TRABAJO_SEARCH.php';
    include '../Views/Trabajo/TRABAJO_SHOWCURRENT.php';
    include '../Views/Trabajo/TRABAJO_EDIT.php';
    include '../Views/Trabajo/TRABAJO_DELETE.php';


    function get_data_form(){ //recoge los valores del formulario

        $IdTrabajo= $_REQUEST['IdTrabajo']; //Variable para el id del trabajo
        $NombreTrabajo = $_REQUEST['NombreTrabajo']; //Variable para el nombre del trabajo
        $FechaIniTrabajo = $_REQUEST['FechaIniTrabajo']; //Variable para la fecha de inicio del trabajo
        $FechaFinTrabajo = $_REQUEST['FechaFinTrabajo']; //Variable para la fecha de finalizacion del trabajo
        $PorcentajeNota = $_REQUEST['PorcentajeNota']; //Variable para el porcentaje de la nota
        $action = $_REQUEST['action']; //Variable action para la accion a realizar

        //crea un trabajo
        $TRABAJO = new TRABAJO_Model(
            $IdTrabajo,
            $NombreTrabajo,
            $FechaIniTrabajo,
            $FechaFinTrabajo,
            $PorcentajeNota);

        return $TRABAJO;
    }

    if (!isset($_REQUEST['action'])){ //si no hay accion, la asigna vacía
        $_REQUEST['action'] = '';
    }

    $Permi = new PERMISO_Modelo('','',''); //Crea permiso

    Switch ($_REQUEST['action']){ //switch case que controla las acciones

        //acción añadir
        case 'ADD':

            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $TRABAJO; //coge los valores y los mete en la variable
            $guardar; //donde guarda el trabajo
            
            if($Permi->check('TRABAJO','ADD', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si es por get envia un formulario para insertar trabajo
                    new TRABAJO_ADD();
                }
                else { //Si entra por post
                    $TRABAJO = get_data_form();
                    $respuesta = $TRABAJO->ADD();
                    $guardar = '../Files/';
                    mkdir('../Files/' . $_REQUEST['IdTrabajo'], 0777); //concatena para guardar con el IdTrabajo
                    new MESSAGE($respuesta, '../Controllers/TRABAJO_Controller.php');
                }
                break;

            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $TRABAJO; //crea objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('TRABAJO','DELETE', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos del trabajo que se quiere borrar
                    $TRABAJO = new TRABAJO_Model($_REQUEST['IdTrabajo'], '', '', '', '');
                    $valores = $TRABAJO->RellenaDatos();
                    new TRABAJO_DELETE($valores);
                }
                else{ //Si entra por post envía los datos del trabajo que se quiere borrar a la BD y manda mensaje
                    $TRABAJO = new TRABAJO_Model($_REQUEST['IdTrabajo'], '', '', '', '');
                    $respuesta = $TRABAJO->DELETE();
                    new MESSAGE($respuesta, '../Controllers/TRABAJO_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción editar
        case 'EDIT':

            $TRABAJO; //crea objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos
            
            if($Permi->check('TRABAJO','EDIT', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){//Si entra por get envia un formulario con los datos del trabajo que se quiere editar

                    $TRABAJO = new TRABAJO_Model($_REQUEST['IdTrabajo'], '', '', '', '');
                    $valores = $TRABAJO->RellenaDatos();
                    new TRABAJO_EDIT($valores);
                }
                else{//Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $TRABAJO = get_data_form();
                    $respuesta = $TRABAJO->EDIT();
                    new MESSAGE($respuesta, '../Controllers/TRABAJO_Controller.php');
                }

                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción buscar
        case 'SEARCH':

            $TRABAJO; //se cogen los valores del formulario y los mete en la variable
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos que busca
            $lista; //crea un array de los datos
            
           if($Permi->check('TRABAJO','SEARCH', $_SESSION['login'])){ //si tiene permiso

            if (!$_POST){//Si entra por get envia un formulario para buscar por los diferentes campos que tiene un trabajo
                new TRABAJO_SEARCH();
            }
            else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                $TRABAJO = get_data_form();
                $datos = $TRABAJO->SEARCH();
                $lista = array('IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota');
                new TRABAJO_SHOWALL($lista, $datos, '../Controllers/TRABAJO_Controller.php');
            }
            break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $TRABAJO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('TRABAJO','SHOWCURRENT', $_SESSION['login'])){ //si tiene permiso
                //Envia los datos de la funcionalidad que se quiere ver en detalle
                $TRABAJO = new TRABAJO_Model($_REQUEST['IdTrabajo'],'', '', '', '');
                $valores = $TRABAJO->RellenaDatos();
                new TRABAJO_SHOWCURRENT($valores);
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        default:

            $TRABAJO; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos
            $lista; //crea un array de los datos
            if($Permi->check('TRABAJO','SHOWALL', $_SESSION['login'])){ //si tiene permiso
            if (!$_POST){ //Si entra por get muestra vista SHOWALL 
                $TRABAJO = new TRABAJO_Model('','','','','');
            }
            else{//Si entra por post muestra SHOWALL con el atributo designado
                $TRABAJO = new TRABAJO_Model($_REQUEST['IdTrabajo'], '', '', '', '');
            }

            //lo hace de todas formas
            $datos = $TRABAJO->AllData();
            $lista = array('IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota');
            new TRABAJO_SHOWALL($lista, $datos, '../Controllers/TRABAJO_Controller.php');
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
    }

}
?>