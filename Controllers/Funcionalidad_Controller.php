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
    require_once('../Models/FUNCIONALIDAD_Model.php');
    include '../Views/Funcionalidad/Funcionalidad_SHOWALL.php';
    include '../Views/Funcionalidad/Funcionalidad_ADD.php';
    include '../Views/Funcionalidad/Funcionalidad_SEARCH.php';
    include '../Views/Funcionalidad/Funcionalidad_SHOWCURRENT.php';
    include '../Views/Funcionalidad/Funcionalidad_EDIT.php';
    include '../Views/Funcionalidad/Funcionalidad_DELETE.php';
    include '../Views/Funcionalidad/Funcionalidad_ASIGNACION.php';

    
    function get_data_form(){ //recoge los valores del formulario

        $IdFuncionalidad= $_REQUEST['IdFuncionalidad']; //Variable para el id de la funcionalidad
        $NombreFuncionalidad = $_REQUEST['NombreFuncionalidad']; //Variable para el nombre de la funcionalidad
        $DescripFuncionalidad = $_REQUEST['DescripFuncionalidad']; //Variable para la descirpcion de la funcionalidad
        $action = $_REQUEST['action']; //Variable action para la accion a realizar

        //crea una funcionalidad
        $FUNCIONALIDAD = new FUNCIONALIDAD_Model(
            $IdFuncionalidad,
            $NombreFuncionalidad,
            $DescripFuncionalidad);

        return $FUNCIONALIDAD;
    }

    if (!isset($_REQUEST['action'])){//si no hay accion, la asigna vacía
        $_REQUEST['action'] = '';
    }

    $Permi = new PERMISO_Modelo('','',''); //Crea permiso

    
    Switch ($_REQUEST['action']){ //switch case que controla las acciones

        //acción añadir
        case 'ADD':

            $FUNCIONALIDAD; //coge los datos del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje

            if($Permi->check('FUNCIONALIDAD','ADD', $_SESSION['login'])){ //si se tiene permiso

                if (!$_POST){ //Si es por get envia un formulario para insertar funcionalidad
                    new FUNCIONALIDAD_ADD();
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $FUNCIONALIDAD = get_data_form();
                    $respuesta = $FUNCIONALIDAD->ADD();
                    new MESSAGE($respuesta, '../Controllers/Funcionalidad_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $FUNCIONALIDAD; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('FUNCIONALIDAD','DELETE', $_SESSION['login'])){ //si se tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos de la funcionalidad que se quiere borrar
                    $FUNCIONALIDAD = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'], '', '');
                    $valores = $FUNCIONALIDAD->RellenaDatos();
                    new FUNCIONALIDAD_DELETE($valores);
                }
                else{ //Si entra por post envía los datos de la funcionalidad que se quiere borrar a la BD y manda mensaje
                    $FUNCIONALIDAD = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'], '', '');
                    $respuesta = $FUNCIONALIDAD->DELETE();
                    new MESSAGE($respuesta, '../Controllers/Funcionalidad_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción editar
        case 'EDIT':

            $FUNCIONALIDAD; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('FUNCIONALIDAD','EDIT', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos dela funcionalidad que se quiere editar

                    $FUNCIONALIDAD = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'], '', '');
                    $valores = $FUNCIONALIDAD->RellenaDatos();
                    new FUNCIONALIDAD_EDIT($valores);
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $FUNCIONALIDAD = get_data_form();
                    $respuesta = $FUNCIONALIDAD->EDIT();
                    new MESSAGE($respuesta, '../Controllers/Funcionalidad_Controller.php');
                }

                break;
            }else{ //si no tiene permiso
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción buscar
        case 'SEARCH':

            $FUNCIONALIDAD; //coge los datos del formulario
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos que busca
            $lista; //crea un array de los datos

            if($Permi->check('FUNCIONALIDAD','SEARCH', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario para buscar por los diferentes campos que tiene una funcionalidad
                    new FUNCIONALIDAD_SEARCH();
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $FUNCIONALIDAD = get_data_form();
                    $datos = $FUNCIONALIDAD->SEARCH();
                    $lista = array('IdFuncionalidad','NombreFuncionalidad','DescripFuncionalidad');
                    new FUNCIONALIDAD_SHOWALL($datos, '../Controllers/Funcionalidad_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $FUNCIONALIDAD; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('FUNCIONALIDAD','SHOWCURRENT', $_SESSION['login'])){ //si tiene permiso
                //Envia los datos de la funcionalidad que se quiere ver en detalle
                $FUNCIONALIDAD = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'],'', '');
                $valores = $FUNCIONALIDAD->RellenaDatos();
                new FUNCIONALIDAD_SHOWCURRENT($valores);
                break;
            }else{//si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        case 'ASIGNACION':

            $FUNC; //almacena un objecto funcionalidad
            $grupos; //recoge las acciones de FUNC
            $grupouser; //recoge las acciones de usuario de FUN
            $respuesta; //almacena la respuesta que muestra el mensaje
            $id; //nombre que le va a poner a los IdAccion

            if($Permi->check('FUNCIONALIDAD','ASIGNACION', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){//si entra por get
                    $FUNC = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'],'','');
                    $grupos = $FUNC->fetchAcciones();
                    $gruposuser = $FUNC->fetchAccionesUsu();
                    
                    new FUNCIONALIDAD_ASIGNACION($grupos,$gruposuser,$_REQUEST['IdFuncionalidad']);
                }
                else{//si entra por post
                    $FUNC = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'],'','');
                    $FUNC->delAccionFun();
                    if (!isset($_REQUEST['IdAccion'])){ //si no esta el IdAccion que es requerido que pone como vacio
                            $_REQUEST['IdAccion'] = '';
                        }
                        if($_REQUEST['IdAccion'] != ''){ //si el IdAccion requerido no está vacio
                            foreach($_POST['IdAccion'] as $id){ //le pasa todas las IdAccion a setAccion 
                                $respuesta = $FUNC->setAccion($id);
                            }
                        }else{$respuesta='Success insert';}
                    new MESSAGE($respuesta, '../Controllers/Funcionalidad_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        default:

            $FUNCIONALIDAD; //crea un objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos
            $lista; //crea un array vacio

            if($Permi->check('FUNCIONALIDAD','SHOWALL', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get muestra vista SHOWALL 
                    $FUNCIONALIDAD = new FUNCIONALIDAD_Model('','','');
                }
                else{//Si entra por post muestra SHOWALL con el atributo designado
                    
                    $FUNCIONALIDAD = new FUNCIONALIDAD_Model($_REQUEST['IdFuncionalidad'], '', '');
                }

                //lo hace de todas formas
                $datos = $FUNCIONALIDAD->AllData();
                $lista = null;
                new FUNCIONALIDAD_SHOWALL($datos, '../Controllers/Funcionalidad_Controller.php');

            }else{//si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
    }

}
?>