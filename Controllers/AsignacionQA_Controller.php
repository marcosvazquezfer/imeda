<?php
/**
 * Archivo php donde se gestiona las acciones principales para la asignacion de QA
 * Created by PhpStorm.
 * Autor: Mauri -Grupo Imeda
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
    require_once('../Models/ASIGNACIONQA_Model.php');
    include '../Views/AsignacionQA/AsignacionQA_SHOWALL.php';
    include '../Views/AsignacionQA/AsignacionQA_ADD.php';
    include '../Views/AsignacionQA/AsignacionQA_SEARCH.php';
    include '../Views/AsignacionQA/AsignacionQA_SHOWCURRENT.php';
    include '../Views/AsignacionQA/AsignacionQA_EDIT.php';
    include '../Views/AsignacionQA/AsignacionQA_DELETE.php';
    include '../Views/AsignacionQA/AsignacionQA_GENERAR.php';
    include '../Views/AsignacionQA/AsignacionQA_GEN_HISTORIAS.php';

    //recoge los valores del formulario
    function get_data_form(){

        $IdTrabajo= $_REQUEST['IdTrabajo'];
        $LoginEvaluador = $_REQUEST['LoginEvaluador'];
        $LoginEvaluado = $_REQUEST['LoginEvaluado'];
        $AliasEvaluado = $_REQUEST['AliasEvaluado'];
        $action = $_REQUEST['action'];

        //crea un grupo
        $FUNCIONALIDAD = new AsignacionQA_Model($IdTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado);

        return $FUNCIONALIDAD;
    }

    //si no hay accion, la asigna vacía
    if (!isset($_REQUEST['action'])){
        $_REQUEST['action'] = '';
    }

    //Crea permiso
    $Permi = new PERMISO_Modelo('','','');

    //switch case que controla las acciones
    Switch ($_REQUEST['action']){

        //acción añadir
        case 'ADD':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','ADD', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    new AsignacionQA_ADD();
                }
                else{
                    $AsigQA = get_data_form();
                    $respuesta = $AsigQA->ADD();
                    new MESSAGE($respuesta, '../Controllers/AsignacionQA_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','DELETE', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    $AsigQA = new AsignacionQA_Model($_REQUEST['IdTrabajo'], $_REQUEST['LoginEvaluador'], $_REQUEST['LoginEvaluado'],$_REQUEST['AliasEvaluado']);
                    $valores = $AsigQA->RellenaDatos();
                    new AsignacionQA_DELETE($valores);
                }
                else{
                    $AsigQA = new AsignacionQA_Model($_REQUEST['IdTrabajo'], $_REQUEST['LoginEvaluador'], $_REQUEST['LoginEvaluado'],$_REQUEST['AliasEvaluado']);

                    $respuesta = $AsigQA->DELETE();

                    new MESSAGE($respuesta, '../Controllers/AsignacionQA_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción editar
        case 'EDIT':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','EDIT', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){

                    $AsigQA = new AsignacionQA_Model($_REQUEST['IdTrabajo'], $_REQUEST['LoginEvaluador'], $_REQUEST['LoginEvaluado'],$_REQUEST['AliasEvaluado']);
                    $valores = $AsigQA->RellenaDatos();
                    new AsignacionQA_EDIT($valores);
                }
                else{
                    $FUNCIONALIDAD = get_data_form();
                    $respuesta = $FUNCIONALIDAD->EDIT();
                    new MESSAGE($respuesta, '../Controllers/AsignacionQA_Controller.php');
                }

                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción buscar
        case 'SEARCH':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','SEARCH', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    new AsignacionQA_SEARCH();
                }
                else{
                    $AsigQA = get_data_form();
                    $datos = $AsigQA->SEARCH();

                    new AsignacionQA_SHOWALL($datos, '../Controllers/AsignacionQA_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción mostrar en detalle
        case 'SHOWCURRENT':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','SHOWCURRENT', $_SESSION['login'])){

                $FUNCIONALIDAD = new AsignacionQA_Model($_REQUEST['IdTrabajo'],$_REQUEST['LoginEvaluador'], $_REQUEST['LoginEvaluado'],$_REQUEST['AliasEvaluado']);
                $valores = $FUNCIONALIDAD->RellenaDatos();
                new AsignacionQA_SHOWCURRENT($valores);
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        case 'GenerarQA':
            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','GENERARQA', $_SESSION['login'])){
            if (!$_POST){
                $asignModel= new AsignacionQA_Model('','','','');
                $Trabajos= $asignModel->buscarTrabajos("ET");
                new AsignacionQA_GENERAR($Trabajos);
            }
            else{
                $NombreTrabajo= $_REQUEST['NombreTrabajo'];
                $NumAsig= $_REQUEST['NumeroAsig'];
                $modeloAsignacion= new AsignacionQA_Model('','','','');
                $entregas=$modeloAsignacion->buscarEntregas($NombreTrabajo);
                $LoginsEvaluador= array();
                $AliasEvaluado= array();

                while($row = $entregas->fetch_array()){
                    array_push($LoginsEvaluador,$row['login']);
                    array_push($AliasEvaluado,$row['Alias']);
                }
                $LoginEvaluado=$LoginsEvaluador;
                $AliasEvaluador=$AliasEvaluado;
                $contador=0;

                for($i=0;$i<count($LoginsEvaluador);$i++){

                    for($u=0;$u<$NumAsig;$u++){

                        if($AliasEvaluador[$i]==($AliasEvaluado[$contador])){
                            $contador++;
                        }

                        $modeloAsignacion->InsertarAsignaQA($NombreTrabajo,$LoginsEvaluador[$i],$LoginEvaluado[$contador],$AliasEvaluado[$contador]);

                        $contador=$contador+1;

                        if ($contador==count($AliasEvaluado)){
                            $contador=0;
                        }
                    }
                }
                $respuesta='Success insert';
                new MESSAGE($respuesta, '../Controllers/AsignacionQA_Controller.php');
            }
            break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        case 'GenerarHistorias':
            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ASIGNACIONQA','GENERARHISTORIAS', $_SESSION['login'])){
                if (!$_POST){
                    $asignModel= new AsignacionQA_Model('','','','');
                    $Trabajos= $asignModel->buscarTrabajos("QA");

                    new AsignacionQA_GEN_HISTORIAS($Trabajos);
                }
                else{
                    $NombreTrabajo= $_REQUEST['NombreTrabajo'];
                    
                    $modeloAsignacion= new AsignacionQA_Model('','','','');
                    $asignaciones= $modeloAsignacion->asignaciones($NombreTrabajo);
                    $hist= $modeloAsignacion->historias($NombreTrabajo);
                    $LoginsEvaluador= array();
                    $AliasEvaluado= array();
                    $idHistorias=array();


                    while($row = $asignaciones->fetch_array()){
                        array_push($LoginsEvaluador,$row['LoginEvaluador']);
                        array_push($AliasEvaluado,$row['AliasEvaluado']);
                    }
                    while($row = $hist->fetch_array()){
                        array_push($idHistorias,$row['IdHistoria']);

                    }

                    
                    for($i=0;$i<count($LoginsEvaluador);$i++){

                        for($u=0;$u<count($idHistorias);$u++){
                            
                            
                            $respuesta=$modeloAsignacion->InsertaHistoria($NombreTrabajo,$LoginsEvaluador[$i],$AliasEvaluado[$i],$idHistorias[$u]);
                           


                        }
                    }
                    $respuesta='Success insert';
                    new MESSAGE($respuesta, '../Controllers/AsignacionQA_Controller.php');
                }
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        default:

            //comprueba si entra por get o por post
        if($Permi->check('ASIGNACIONQA','SHOWALL', $_SESSION['login'])){
            if (!$_POST){
                $AsigQA = new AsignacionQA_model('','','','');
            }
            else{

                $AsigQA =new AsignacionQA_model($_REQUEST['IdTrabajo'], $_REQUEST['LoginEvaluador'], $_REQUEST['LoginEvaluado'],$_REQUEST['AliasEvaluado']);
            }
            $datos = $AsigQA->AllData();

            new AsignacionQA_SHOWALL($datos, '../Controllers/AsignacionQA_Controller.php');

        }else{
            new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
            die();
        }
    }

}
?>