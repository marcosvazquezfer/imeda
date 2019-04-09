<?php
/**
 * Archivo php donde se gestiona las acciones principales para un grupo
 * Created by PhpStorm.
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 28/11/2017
 * Fecha fin:28/11/2017
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';

if (!IsAuthenticated()){ //si no está autenticado

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php'); //muestra mensaje

}else{ //si está autenticado


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/HISTORIA_Model.php');
    include '../Views/Historia/HISTORIA_SHOWALL.php';
    include '../Views/Historia/Historia_ADD.php';
    include '../Views/Historia/Historia_SEARCH.php';
    include '../Views/Historia/HISTORIA_SHOWCURRENT.php';
    include '../Views/Historia/HISTORIA_EDIT.php';
    include '../Views/Historia/Historia_DELETE.php';


    function get_data_form(){ //recoge los valores del formulario

        $IdHistoria= $_REQUEST['IdHistoria']; //Variable para el id de la historia
        $IdTrabajo = $_REQUEST['IdTrabajo']; //Variable para el id del trabajo
        $TextoHistoria = $_REQUEST['TextoHistoria']; //Variable para el texto de la historia
        $action = $_REQUEST['action']; //Variable action para la accion a realizar

        //crea una historia
        $HISTORIA = new HISTORIA_Model(
            $IdTrabajo,
            $IdHistoria,
            $TextoHistoria);

        return $HISTORIA;
    }

    if (!isset($_REQUEST['action'])){ //si no hay accion, la asigna vacía
        $_REQUEST['action'] = '';
    }

    $Permi = new PERMISO_Modelo('','',''); //Crea permiso


    Switch ($_REQUEST['action']){ //switch case que controla las acciones

        //acción añadir
        case 'ADD':

            $HISTORIA; //objecto vacio del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $trabajos; //recoge los trabajos

            if($Permi->check('HISTORIA','ADD', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //si entra por get
                    $HISTORIA = new HISTORIA_Model('','','');
                    $trabajos=$HISTORIA->fetchTrabajos();
                    new HISTORIA_ADD($trabajos);
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $HISTORIA = get_data_form();
                    $respuesta = $HISTORIA->ADD();
                    new MESSAGE($respuesta, '../Controllers/Historia_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $HISTORIA; //objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('HISTORIA','DELETE', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //Si entra por get envia un formulario con los datos de la historia que se quiere borrar
                    $HISTORIA = new HISTORIA_Model($_REQUEST['IdTrabajo'], $_REQUEST['IdHistoria'], '');
                    $valores = $HISTORIA->RellenaDatos();
                    new HISTORIA_DELETE($valores);
                }
                else{
                    $HISTORIA = new HISTORIA_Model($_REQUEST['IdTrabajo'], $_REQUEST['IdHistoria'], '');
                    $respuesta = $HISTORIA->DELETE();
                    new MESSAGE($respuesta, '../Controllers/Historia_Controller.php');
                }
                break;
            }else{ //Si entra por post envía los datos de la historia que se quiere borrar a la BD y manda mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción editar
        case 'EDIT':

            $HISTORIA; //objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $respuesta; //almacena la respuesta que muestra el mensaje
            $valores; //almacena los datos tras rellenarlos
            $trabajos; //recoge los trabajos

            if($Permi->check('HISTORIA','EDIT', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //si entra por get
                    $HISTORIA = new HISTORIA_Model($_REQUEST['IdTrabajo'], $_REQUEST['IdHistoria'], '');
                    $valores = $HISTORIA->RellenaDatos();
                    $HISTORIA = new HISTORIA_Model('','','');
                    $trabajos=$HISTORIA->fetchTrabajos();
                    new HISTORIA_EDIT($valores,$trabajos);
                }
                else{ ///Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $HISTORIA = get_data_form();
                    $respuesta = $HISTORIA->EDIT();
                    new MESSAGE($respuesta, '../Controllers/Historia_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra el mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción buscar
        case 'SEARCH':

            $HISTORIA; //objecto vacio del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos que busca
            $lista; //crea un array de los datos
            $trabajos; //recoge los trabajos

            if($Permi->check('HISTORIA','SEARCH', $_SESSION['login'])){ //si tiene permiso

                if (!$_POST){ //si entra por get
                    $HISTORIA = new HISTORIA_Model('','','');
                    $trabajos=$HISTORIA->fetchTrabajos();
                    new HISTORIA_SEARCH($trabajos);
                }
                else{ //Si entra por post recoge los datos introducidos en el formulario, los envia a la BD y manda mensaje
                    $HISTORIA = get_data_form();
                    $datos = $HISTORIA->SEARCH();
                    $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
                    new HISTORIA_SHOWALL($lista, $datos, '../Controllers/Historia_Controller.php');
                }
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $HISTORIA; //objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $valores; //almacena los datos tras rellenarlos

            if($Permi->check('HISTORIA','SHOWCURRENT', $_SESSION['login'])){ //si tiene permiso
                //Envia los datos de la funcionalidad que se quiere ver en detalle
                $HISTORIA = new HISTORIA_Model($_REQUEST['IdTrabajo'], $_REQUEST['IdHistoria'], '');
                $valores = $HISTORIA->RellenaDatos();
                new HISTORIA_SHOWCURRENT($valores);
                break;
            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        default:

            $HISTORIA; //objecto del modelo
            $Permi; //variable que nos permite saber si tiene permisos
            $datos; //almacena los datos
            $lista; //crea un array de los datos

            if($Permi->check('HISTORIA','SHOWALL', $_SESSION['login'])){//si tiene permiso

                if (!$_POST){//Si entra por get muestra vista SHOWALL 
                    $HISTORIA = new HISTORIA_Model('','','');
                }
                else{ //Si entra por post muestra SHOWALL con el atributo designado
                    $HISTORIA = new HISTORIA_Model($_REQUEST['IdTrabajo'], $_REQUEST['IdHistoria'], '');
                }

                //lo hace de todas formas
                $datos = $HISTORIA->AllData();
                $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
                new HISTORIA_SHOWALL($lista, $datos, '../Controllers/Historia_Controller.php');

            }else{ //si no tiene permiso muestra mensaje
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

    }

}
?>