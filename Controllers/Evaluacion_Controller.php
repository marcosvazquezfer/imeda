<?php
/**
 * Archivo php donde se gestiona las acciones principales para evaluacion
 * Created by PhpStorm.
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 28/11/2017
 * 
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';

//comrpueba si está autenticado
if (!IsAuthenticated()){

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php');

}else{


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/EVALUACION_Model.php');
    include '../Views/Evaluacion/Evaluacion_SHOWALL.php';
    include '../Views/Evaluacion/Evaluacion_EVALUAR.php';
    include '../Views/Evaluacion/Evaluacion_EVALUAR2.php';
    include '../Views/Evaluacion/Evaluacion_EVALUARQA.php';
    include '../Views/Evaluacion/Evaluacion_ADD.php';
    include '../Views/Evaluacion/Evaluacion_SEARCH.php';
    include '../Views/Evaluacion/Evaluacion_SHOWCURRENT.php';
    include '../Views/Evaluacion/Evaluacion_DELETE.php';
    include '../Views/Evaluacion/Evaluacion_SHOWALLQAS.php';

    $IdHistoria; //Variable para el indice de historia
    $IdTrabajo; //Variable para el indice de trabajo
    $AliasEvaluado; //Variable para el alias que es evaluado
    $LoginEvaluador; //Variable para el login que va a evaluar
    $action; //Variable para recoger la accion ques eva ejecutar
    $CorrectoA; //Variable que indica si una hisotira esta correcta por parte del alumno
    $CorrectoP; //Variable que indica si una hisotira esta correcta por parte del profesor
    $ComenIncorrectoA; //Variable para el comentario de una historia incorrecta por parte del alumno
    $ComenIncorrectoP; //Variable que indica si una hisotira esta correcta por parte del profesor
    $OK; //Variable que guarda si la correcion por parte de un alumno esta correcta
    $EVA; //Variable que guarde el modelo de evaluacion creado
    $Permi; //Variable que gurada el modelo de permisos creado
    $trabajos; //Variable que guarda trabajos
    $alias; //Variable que gurada alias
    $logins; //Variable que guarda logins
    $historias; //Variable que guarda historias
    $respuesta; //Variable que guarda un mensaje proveniente del modelo
    $valores; //Variable que guarda los valores de un formulario
    $trab; //Variable guarda el id del trabajo requerido
    $datos; //Variable que guarada los valores que manda el modelo para generara formualrios para los QAs
    $i; //Variable que guarda indices para la sentencias de control
    $r; //Variable que guarda nombres de variables requeridas
    $corr; //Variable que guarda una correcion
    $comen; //Variable que guarada el comentario
    $pos; //Variable que guarda indices para la sentencias de control
    $fechaTrabajo; //Variable para guardar una fecha
    $fechaTrabajo2; //Variable para guardar una fecha
    $hoy; //Variable para guardar una fecha de hoy
    $fechaActual; //Variable para guardar una fecha dehoy

    //get_data_form recoge los valores de historia, trabajo, alias, login y la accion a ejecutar del formulario
    function get_data_form(){


        $IdHistoria= $_REQUEST['IdHistoria'];
        $IdTrabajo = $_REQUEST['IdTrabajo'];
        $AliasEvaluado= $_REQUEST['AliasEvaluado'];
        $LoginEvaluador = $_REQUEST['LoginEvaluador'];
        $action = $_REQUEST['action'];

        //crea una evaluacion
        $EVA = new EVALUACION_Model(
            $IdTrabajo,
            $IdHistoria,
            $AliasEvaluado,
            $LoginEvaluador,
            '',
            '',
            '',
            '',
            ''
        );

        return $EVA;
    }

    //get_data_formAlumno recoge los valores de historia, trabajo, alias, login, la correcion del alumno 
    // el comentario y la accion a ejecutar del formulario
    function get_data_formAlumno(){
        
        $IdHistoria= $_REQUEST['IdHistoria'];
        $IdTrabajo = $_REQUEST['IdTrabajo'];
        $AliasEvaluado= $_REQUEST['AliasEvaluado'];
        $LoginEvaluador = $_REQUEST['LoginEvaluador'];
        $CorrectoA = $_REQUEST['CorrectoA'];
        $ComenIncorrectoA = $_REQUEST['ComenIncorrectoA'];
        $action = $_REQUEST['action'];

        //crea una evaluacion
        $EVA = new EVALUACION_Model(
            $IdTrabajo,
            $IdHistoria,
            $AliasEvaluado,
            $LoginEvaluador,
            $CorrectoA,
            $ComenIncorrectoA,
            '',
            '',
            ''
        );

        return $EVA;
    }

    //get_data_form2 recoge los valores de trabajo, alias, login, la correcion del alumno,  
    //el comentario incorrecto del alumno, la correcion de profesor, 
    //el comentario del profesor, el ok por parte del profesor y 
    //la accion a ejecutar del formulario

    function get_data_form2(){
        
        $IdTrabajo = $_REQUEST['IdTrabajo'];
        $AliasEvaluado= $_REQUEST['AliasEvaluado'];
        $LoginEvaluador = $_REQUEST['LoginEvaluador'];
        //Si existe la variable asigna un 1 a la variable correspondiente
        if(isset($_POST['CorrectoA'])){
            $CorrectoA = 1;
            //Sino asigna 0 a la variable
        }else{
            $CorrectoA = 0;
        }
        $ComenIncorrectoA = $_POST['ComenIncorrectoA'];

        //Si existe la variable asigna un 1 a la variable correspondiente
        if(isset($_POST['CorrectoP'])){
            $CorrectoP = 1;
            //Sino asigna 0 a la variable
        }else{
            $CorrectoP = 0;
        }
        $ComenIncorrectoP = $_POST['ComentIncorrectoP'];

        //Si existe la variable asigna un 1 a la variable correspondiente
        if(isset($_POST['OK'])){
            $OK = 1;
            //Sino asigna 0 a la variable
        }else{
            $OK = 0;
        }
        $action = $_REQUEST['action'];

        //crea una evaluacion
        $EVA = new EVALUACION_Model(
            $IdTrabajo,
            $LoginEvaluador,
            $AliasEvaluado,
            '',
            $CorrectoA,
            $ComenIncorrectoA,
            $CorrectoP,
            $ComenIncorrectoP,
            $OK
        );

        return $EVA;
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
            if($Permi->check('EVALUACION','ADD', $_SESSION['login'])){

                //comprueba si entra por get 
                if (!$_POST){

                    $EVA = new EVALUACION_Model('','','','','','','','','');
                    $trabajos=$EVA->fetchEntregasQA();
                    $alias=$EVA->fetchAlias();
                    $logins=$EVA->fetchLogin();
                    $historias=$EVA->fetchHistorias();
                    new Evaluacion_ADD($trabajos,$alias,$logins,$historias);
                    
                }
                //comprueba si entra por get 
                else{

                    $EVA = get_data_form2();
                    $respuesta = $EVA->ADD($_REQUEST[$_REQUEST['IdTrabajo']]);
                    new MESSAGE($respuesta, '../Controllers/Evaluacion_Controller.php');
                }
                break;
                //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            //comprueba si el usuario tiene permisos para realizar la acción
    
            if($Permi->check('HISTORIA','DELETE', $_SESSION['login'])){

                //comprueba si entra por get
                if (!$_POST){
                    $EVA = new EVALUACION_Model($_REQUEST['IdTrabajo'],$_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado'],$_REQUEST['IdHistoria'],'','','','', '');
                    $valores = $EVA->RellenaDatos();
                    new EVALUACION_DELETE($valores);
                    
                }
                //comprueba si entra por post
                else{
                    $EVA = new EVALUACION_Model($_REQUEST['IdTrabajo'],$_REQUEST['login'], $_REQUEST['Alias'],$_REQUEST['IdHistoria'],'','','','', '');
                    $respuesta = $EVA->DELETE();
                    new MESSAGE($respuesta, '../Controllers/Evaluacion_Controller.php');
                }
                break;
                //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción buscar
        case 'SEARCH':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('EVALUACION','SEARCH', $_SESSION['login'])){

                //comprueba si entra por get 
                if (!$_POST){
                    $EVA = new EVALUACION_Model('','','','','','','','','');
                    $trabajos=$EVA->fetchEntregasQA();
                    $alias=$EVA->fetchAlias();
                    $logins=$EVA->fetchLogin();
                    $historias=$EVA->fetchHistorias();
                    new Evaluacion_SEARCH($trabajos,$alias,$logins,$historias);

                }
                //comprueba si entra por post
                else{
                    $EVA = get_data_form2();
                    //Si el IdTrabajo es vacio pone la variable IdTrabajo a vacio
                    if($_REQUEST['IdTrabajo'] == ''){
                        $IdTrabajo = '';
                    //Sino la variable IdTrabajo sera el valor del input que se le pasa com IdTrabajo
                    }else{
                        $IdTrabajo = $_REQUEST[$_REQUEST['IdTrabajo']];
                    }
                    $datos = $EVA->SEARCH($IdTrabajo);
                    
                    new Evaluacion_SHOWALL($datos, '../Controllers/Evaluacion_Controller.php');
                }
                break;
                //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción mostrar en detalle
        case 'SHOWCURRENT':

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('NOTAS','SHOWCURRENT', $_SESSION['login'])){

                $EVA = new EVALUACION_Model($_REQUEST['IdTrabajo'],$_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado'],$_REQUEST['IdHistoria'],'','','','', '');
                $valores = $EVA->RellenaDatos();
                new EVALUACION_SHOWCURRENT($valores);
                break;
            //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        //Accion mostrar QAs asignada a cada usuario o todas al profesor
        case 'MOSTRARQAS':
            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('EVALUACION','MOSTRARQAS', $_SESSION['login'])){

                //Comprueba si el usuario tiene permiso como profesor(MOSTRARQASCORRECTOR) y 
                //muestra todas las QAs que hay que realizar
                if($Permi->check('EVALUACION','MOSTRARQASCORRECTOR', $_SESSION['login'])){
                    $EVA = new EVALUACION_Model('','','','','','','','','');
                    $datos=$EVA->getQAS();
                    new Evaluacion_SHOWALLQAS($datos, '../Controllers/Evaluacion_Controller.php');
                //Sino muestra solo las QAs que le corresponde al usuario
                }else{
                    $EVA = new EVALUACION_Model('',$_SESSION['login'],'','','','','','','');
                    $datos=$EVA->getQAS();
                    new Evaluacion_SHOWALLQAS($datos, '../Controllers/Evaluacion_Controller.php');
                }

            //sino muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

            break;
        //Accion Evaluar una entrega en concreto como QA
        case 'EVALUAR':
        
            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('EVALUACION','EVALUAR', $_SESSION['login'])){

                //comprueba si entra por get
                if (!$_POST){
                    $trab='QA'.substr($_REQUEST['IdTrabajo'],2);

                    //Comprueba si el usuario es un profesor(EVALUARCORRECTOR) y recoge los valores de ese usuario
                    if($Permi->check('EVALUACION','EVALUARCORRECTOR', $_SESSION['login'])){ 
                        $EVA = new EVALUACION_Model($_REQUEST['IdTrabajo'],'',$_REQUEST['AliasEvaluado'],'','','','','','');
                        $datos=$EVA->fetchFormEvaluacionCorr();
                        new EVALUACION_EVALUAR2($datos);
                    //Sino recoge los valores como usuario-alumno
                    }else{
                        $EVA = new EVALUACION_Model($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado'],'','','','','','');
                        $datos=$EVA->fetchFormEvaluacion();

                        $fechaTrabajo = $EVA->getFechasFin($trab);
                        $fechaTrabajo2 = date_create(substr($fechaTrabajo,0,4).'-'.substr($fechaTrabajo,5,6).'-'.substr($fechaTrabajo,8,9));
                        $hoy=getdate();
                        $fechaActual=date_create($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);

                        //Se comprueba si no esta disponible para realizar la QA por la fecha de fin de trabajo y manda un mensaje
                        if($fechaTrabajo2<$fechaActual){
                            $respuesta="Ha expirado el plazo para editar esta QA";
                            new MESSAGE($respuesta, '../Controllers/Evaluacion_Controller.php?action=MOSTRARQAS');
                        //Sino le muestra el formualrio para realizar la QA
                        }else{
                            new EVALUACION_EVALUAR($datos);
                        }
                    }
                    
                }
                //comprueba si entra por post
                else{
                    $EVA = new EVALUACION_Model('',$_SESSION['login'],'','','','','','','');
                    $i = 0;
                    
                    //Por cada input del formulario con name IdHistoria 
                    foreach($_POST['IdHistoria'] as $id){
                        $r = 'correcion'.$i;
                        
                        //Si el valor de la correcion es igual a 0 pone el valor de la correcion a 0
                        //y recoge el valor del comentario
                        if($_POST[$r] == '0'){
                            
                            $corr = 0;
                            $comen = $_POST['correcionTexto'.$i];

                        //Sino pone el valor de la correcion a 1 y el comentario (si existe) vacio
                        }else{
                            
                            $corr = 1;
                            $comen = '';
                        }
                       
                        //Comprueba si la tupla va a ser modificado por un profesor
                        if($Permi->check('EVALUACION','EVALUARCORRECTOR', $_SESSION['login'])){
                        
                            $datos = $EVA->EditEvaluacionHistoriaProfesor($id,$corr,$comen,$_REQUEST['AliasEvaluado'],$_REQUEST['IdTrabajo']);
                        //Sino lo modificara como alumno que hace de QA
                        }else{
                            
                            $datos = $EVA->EditEvaluacionHistoria($id,$corr,$comen,$_REQUEST['LoginEvaluador'],$_REQUEST['AliasEvaluado'],$_REQUEST['IdTrabajo']);
                        }
                        
                         
                        $i++;
                    }
                    
                    //Comprueba que permiso tiene para mostrar todas las entregas 
                    if($Permi->check('EVALUACION','EVALUARCORRECTOR', $_SESSION['login'])){
                        $EVA = new EVALUACION_Model('','','','','','','','','');
                        $datos = $EVA->getQAS();
                    //Sino le muestra las entregas que le corresponde
                    }else{
                        $datos = $EVA->getQAS();
                    }
                    new Evaluacion_SHOWALLQAS($datos, '../Controllers/Evaluacion_Controller.php');
                    
                }
                break;
                //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        //accion evaluar las QAs que hicieron los alumnos 
        case 'EVALUARQA':
        
            //comprueba si el usuario tiene permisos para realizar la acción
           
            if($Permi->check('EVALUACION','EVALUARQA', $_SESSION['login'])){

                //comprueba si entra por get
                if (!$_POST){
                    $trab='QA'.substr($_REQUEST['IdTrabajo'],2,3);
                    $EVA = new EVALUACION_Model($trab,'',$_REQUEST['AliasEvaluado'],'','','','','','');
                    $trabajos=$EVA->fetchQAs();
                    $historias=$EVA->fetchQAsHistoria($_REQUEST['IdTrabajo']);
                    new EVALUACION_EVALUARQA($trabajos,$historias);

                }
                //comprueba si entra por post
                else{
                    $EVA = new EVALUACION_Model('','','','','','','','','');
                    $EVA->DefaultQAS($_REQUEST['IdTrabajo'],$_REQUEST['AliasEvaluado']);
                    $r=0;
                    $EVA->eliminarvaloresQAS($_REQUEST['IdTrabajo'],$_REQUEST['AliasEvaluado']);

                    //Por cada input del formulario con name IdHistoria 
                    foreach($_POST['IdHistoria'] as $id){
                        
                        $pos = 0;
                        
                         //Por cada input del formulario con name LoginEvaluador y un indice asignado
                        foreach($_POST['LoginEvaluador'.$r] as $log){
                                
                            //Si el valor del ok de una correcion de una historia del formulario es afirmativo
                            if(isset($_POST['ok'.$r.$pos])){
                                
                                $EVA->EvaluarQAS($_REQUEST['IdTrabajo'],$_REQUEST['AliasEvaluado'],$id,$log,$_POST['ok'.$r.$pos]);
                            }
                            //Si el valor de la correcion del profesor es afirmativa
                            if(isset($_POST['CorrectoP'.$r])){
                                
                                $EVA->Evaluar($_REQUEST['IdTrabajo'],$_REQUEST['AliasEvaluado'],$id,$log,'',$_POST['CorrectoP'.$r]);
                            }
                            //Si el valor de la correcion del profesor no es afirmativa 
                            else{
                                
                                $EVA->EvaluarIncorrecto($_REQUEST['IdTrabajo'],$_REQUEST['AliasEvaluado'],$id,$log,$_POST['ComentIncorrectoP'.$r],0);
                            }
                            $pos++;
                        }
                        $r++;

                    }
                    //Comprueba si el usuario tiene permiso como profesor(MOSTRARQASCORRECTOR) y 
                    //muestra todas las QAs que hay que realizar
                    if($Permi->check('EVALUACION','MOSTRARQASCORRECTOR', $_SESSION['login'])){
                        $EVA = new EVALUACION_Model('','','','','','','','','');
                        $datos=$EVA->getQAS();
                        new Evaluacion_SHOWALLQAS($datos, '../Controllers/Evaluacion_Controller.php');
                    //Sino muestra solo las QAs que le corresponde al usuario
                    }else{
                        $EVA = new EVALUACION_Model('',$_SESSION['login'],'','','','','','','');
                        $datos=$EVA->getQAS();
                        new Evaluacion_SHOWALLQAS($datos, '../Controllers/Evaluacion_Controller.php');
                    }
                }
                break;
            //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        //accion de mostrar todos los valores
        default:

            //comprueba si entra por get o por post
            if($Permi->check('EVALUACION','SHOWALL', $_SESSION['login'])){
                
                $EVA = new EVALUACION_Model('','','','','','','','','');

                $datos=$EVA->Alldata();
                
                new Evaluacion_SHOWALL($datos, '../Controllers/Evaluacion_Controller.php');
                //si no muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

    }

}
?>