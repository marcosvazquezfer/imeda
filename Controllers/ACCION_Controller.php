<?php
/**
 * Archivo php donde se gestiona las acciones principales para las acciones
 * Created by PhpStorm.
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 30/11/2017
 * Fecha fin:30/11/2017
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';


if (!IsAuthenticated()){ //si no está autenticado

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php'); //muestra mensaje

}else{ //si lo esta


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/ACCION_Model.php');
    include '../Views/Accion/Accion_SHOWALL.php';
    include '../Views/Accion/Accion_ADD.php';
    include '../Views/Accion/Accion_SEARCH.php';
    include '../Views/Accion/Accion_SHOWCURRENT.php';
    include '../Views/Accion/Accion_EDIT.php';
    include '../Views/Accion/Accion_DELETE.php';


    function get_data_form(){ //recoge los valores del formulario

        $IdAccion= $_REQUEST['IdAccion']; //Variable para el id de la accion
        $NombreAccion = $_REQUEST['NombreAccion']; //Variable para el nombre de la accion
        $DescripAccion = $_REQUEST['DescripAccion']; //Variable para la descripcion de la accion
        $action = $_REQUEST['action']; //Variable action para la accion a realizar

        //crea una accion
        $ACCION = new ACCION_Model(
            $IdAccion,
            $NombreAccion,
            $DescripAccion);

        return $ACCION;
    }

    if (!isset($_REQUEST['action'])){ //si no hay accion, la asigna vacía
        $_REQUEST['action'] = '';
    }

    $Permi = new PERMISO_Modelo('','',''); //Crea permiso

    
    Switch ($_REQUEST['action']){ //switch case que controla las acciones

        //acción añadir
        case 'ADD':

            $ACCION; //coge todos los datos del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje

            if($Permi->check('ACCION','ADD', $_SESSION['login'])){ //si se tiene permiso

                if (!$_POST){ //Si es por get envia un formulario para insertar accion
                    new ACCION_ADD(); 
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $ACCION = get_data_form(); 
                    $respuesta = $ACCION->ADD();
                    new MESSAGE($respuesta, '../Controllers/ACCION_Controller.php');
                }
                break;
            }else{//si no tiene permisos muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $ACCION; //crea objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('ACCION','DELETE', $_SESSION['login'])){ //si se tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos de la accion que se quiere borrar
                    $ACCION = new ACCION_Model($_REQUEST['IdAccion'], '', '');
                    $valores = $ACCION->RellenaDatos();
                    new Accion_DELETE($valores);
                }
                else{ //Si entra por post envía los datos de la accion que se quiere borrar a la BD y manda mensaje
                    $ACCION = new ACCION_Model($_REQUEST['IdAccion'], '', '');
                    $respuesta = $ACCION->DELETE();
                    new MESSAGE($respuesta, '../Controllers/ACCION_Controller.php');
                }
                break;
            }else{ //si no tiene permisos muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción editar
        case 'EDIT':

            $ACCION; //crea objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('ACCION','EDIT', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos de la accion que se quiere editar

                    $ACCION = new ACCION_Model($_REQUEST['IdAccion'], '', '');
                    $valores = $ACCION->RellenaDatos();
                    new Accion_EDIT($valores);
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $ACCION = get_data_form();
                    $respuesta = $ACCION->EDIT();
                    new MESSAGE($respuesta, '../Controllers/ACCION_Controller.php');
                }

                break;
            }else{ //si no tiene permisos muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción buscar
        case 'SEARCH':

            $ACCION; //coge todos los datos del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos que busca
            $lista; //crea un array de los datos

            if($Permi->check('ACCION','SEARCH', $_SESSION['login'])){ //si se tiene permisos

                if (!$_POST){ //Si entra por get envia un formulario para buscar por los diferentes campos que tiene una accion
                    new ACCION_SEARCH();
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $ACCION = get_data_form();
                    $datos = $ACCION->SEARCH();
                    $lista = array('IdAccion','NombreAccion','DescripAccion');
                    new ACCION_SHOWALL($lista, $datos, '../Controllers/ACCION_Controller.php');
                }
                break;
            }else{ //si no tiene permisos muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $ACCION; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('ACCION','SHOWCURRENT', $_SESSION['login'])){ //si se tiene permiso
                //Envia los datos de la accion que se quiere ver en detalle
                $ACCION = new ACCION_Model($_REQUEST['IdAccion'],'', '');
                $valores = $ACCION->RellenaDatos();
                new ACCION_SHOWCURRENT($valores);
                break;
            }else{ //si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            
            }


        default:

        $ACCION; //crea un objecto del modelo
        $Permi; //variable que nos permite saber si tiene permisos
        $datos; //almacena los datos
        $lista; //crea un array de los datos

        if($Permi->check('ACCION','SHOWALL', $_SESSION['login'])){ //si tiene permiso
            
            if (!$_POST){ //Si entra por get muestra vista SHOWALL 
                $ACCION = new ACCION_Model('','','');
            }
            else{ //Si entra por post muestra SHOWALL con el atributo designado
                $ACCION = new ACCION_Model($_REQUEST['IdAccion'], '', '');
            }

            //lo hace de todas formas
            $datos = $ACCION->AllData();
            $lista = array('IdAccion','NombreAccion','DescripAccion');
            new Accion_SHOWALL($lista, $datos, '../Controllers/ACCION_Controller.php');

        }else{ //si no tiene permiso muestra el mensaje
            new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
            die();
        }
    }

}
?>