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

//comrpueba si está autenticado
if (!IsAuthenticated()){

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php');

}else{


    require_once("../Models/PERMISO_Modelo.php");
    require_once("../Models/FUNC_ACCION_Model.php");
    include '../Views/Permiso/Permiso_SHOWALL.php';
    include '../Views/Permiso/Permiso_SEARCH.php';
    include '../Views/Permiso/Permiso_Seleccionar_funcion.php';
    include '../Views/Permiso/Permiso_Asignar.php';


    function get_data_form(){ //recoge los valores del formulario

        $NombreGrupo= $_REQUEST['NombreGrupo'];
        $NombreFuncionalidad = $_REQUEST['NombreFuncionalidad'];
        $NombreAccion = $_REQUEST['NombreAccion'];
        $action = $_REQUEST['action'];

        //crea un grupo
        $HISTORIA = new PERMISO_Modelo(
            $NombreGrupo,
            $NombreFuncionalidad,
            $NombreAccion);

        return $HISTORIA;
    }

    //si no hay accion, la asigna vacía
    if (!isset($_REQUEST['action'])){
        $_REQUEST['action'] = '';
    }

    //Crea permiso
    $Permi = new PERMISO_Modelo('','','');

    //switch case que controla las acciones
    Switch ($_REQUEST['action']){

        //acción buscar
        case 'SEARCH':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('PERMISO','SEARCH', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    new PERMISO_SEARCH();
                }
                else{
                    $PERMISO = get_data_form();
                    $datos = $PERMISO->SEARCH();
                    
                    $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
                    new PERMISO_SHOWALL($datos, '../Controllers/Permiso_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        case 'Seleccionar_Funcionalidad':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('PERMISO','ASIGNAR', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){

                    $GRUPO= $_REQUEST['NombreGrupo'];
                    $FUNCIONALIDAD= new FUNC_ACCION_Model('','');
                    $FUN_POSIBLES=$FUNCIONALIDAD->SEARCHNOMFUN();


                    new SELEC_FUNC_View($GRUPO,$FUN_POSIBLES);
                }
                else{
                    $GRUPO= $_REQUEST['NombreGrupo'];
                    $FUNCIONALIDAD= $_REQUEST['NombreFuncionalidad'];


                    new MESSAGE($Datos,'../Controllers/Grupo_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }



        case 'ASIGNAR':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('PERMISO','ASIGNAR', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){

                    $GRUPO= $_REQUEST['NombreGrupo'];
                    $FUNCIONALIDAD= $_REQUEST['NombreFuncionalidad'];
                    $ACCIONES= new FUNC_ACCION_Model($FUNCIONALIDAD,'');
                    $ACCIONES_POSIBLES=$ACCIONES->SEARCHNOMBRES($FUNCIONALIDAD);

                    new ASIGNAR_ACCIONES_View($GRUPO,$FUNCIONALIDAD,$ACCIONES_POSIBLES);
                }
                else{

                    $GRUPO= $_REQUEST['NombreGrupo'];
                    $FUNCIONALIDAD= $_REQUEST['NombreFuncionalidad'];
                    if (!isset($_REQUEST['NombreAccion'])){
                        $_REQUEST['NombreAccion'] = '';
                    }

                    $ACCIONES= $_REQUEST['NombreAccion'];
                    $PERMISO = get_data_form();
                   $PERMISO->DELETE($GRUPO,$FUNCIONALIDAD);
                   if($ACCIONES!=''){
                    foreach ($ACCIONES as $Accion){
                        $datos = $PERMISO->ADD($FUNCIONALIDAD,$Accion,$GRUPO);
                    }
                   }else{$datos='Success insert';}
                    new MESSAGE($datos,'../Controllers/Grupo_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        
        default:

        if($Permi->check('PERMISO','SHOWALL', $_SESSION['login'])){
            //comprueba si entra por get o por post
            if (!$_POST){
                $PERMISO = new PERMISO_Modelo('','','');
            }
            else{
                $PERMISO = new PERMISO_Modelo($_REQUEST['NombreGrupo'], $_REQUEST['NombreFuncionalidad'], $_REQUEST['NombreAccion']);
            }
            //$grupos = $PERMISO->fetchGrupos();
            //$funcionalidades = $PERMISO->fetchFuncionalidades();
            //$acciones = $PERMISO->fetchAcciones();
            $datos = $PERMISO->showall();
            $lista = array('IdGrupo','NombreGrupo','DescripGrupo');
            new PERMISO_SHOWALL($datos, '../Controllers/Permiso_Controller.php');

        }else{
            new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
            die();
        }
    }

}
?>