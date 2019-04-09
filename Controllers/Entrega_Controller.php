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

//comrpueba si está autenticado
if (!IsAuthenticated()){

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php');

}else{


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/ENTREGA_Model.php');
    include '../Views/Entrega/Entrega_SHOWALL.php';
    include '../Views/Entrega/Entrega_ADD.php';
    include '../Views/Entrega/Entrega_EDIT.php';
    include '../Views/Entrega/Entrega_EDIT2.php';
    include '../Views/Entrega/Entrega_DELETE.php';
    include '../Views/Entrega/Entrega_SHOWCURRENT.php';
    include '../Views/Entrega/Entrega_SEARCH.php';

    $login; //almacena login usuario, a su vez logines de la tabla USUARIO
    $IdTrabajo; //almacena la ID de Trabajo
    $Alias; //almacena el alias del usuario
    $Horas; //almacena el nº de hora en la entrega
    $Ruta; //almacena la ruta de la entrega
    $action; //Variable para recoger la accion ques eva ejecutar
    $ENTREGA; //Variable que guarde el modelo de evaluacion creado
    $characters; //almacena los posibles valores que puede tomar el String a devolver
    $charactersLength ; //obtiene la longitud de la cadena characters
    $randomString; //almacena la cadena aleatoria a devolver
    $Permi; //Variable que gurada el modelo de permisos creado
    $trabajos; //almacena todos los trabajos
    $respuesta; //Variable que guarda un mensaje proveniente del modelo
    $valores; //Variable que guarda los valores de un formulario
    $fechaTrabajo; //almacena fecha fin trabajo
    $fechaTrabajo2; //almacena fecha fin trabajo con formato date
    $hoy; //almacena fecha del dia actual
    $fechaActual; //almacena fecha del dia actual en formato date
    $lista; //array con variables del modelo
    $datos; //almacena datos de la variable ENTREGA
    $comparacion; //resultado de la comparacion de la fechaFinTrabajo con la actual
    $comparacion2;//resultado de la comparacion de la fechaIniTrabajo con la actual



    //get_data_form recoge los valores del formulario  y la accion al enviarse el formulario
    function get_data_form(){
        $login= $_REQUEST['login'];
        $IdTrabajo= $_REQUEST['IdTrabajo'];
        $Alias = $_REQUEST['Alias'];
        $Horas = $_REQUEST['Horas'];

        //si existe un archivo
        //si no hay archivo cogemos el valor del input Ruta2
        if(isset($_FILES['Ruta']['name'])){
            //si el parametro ruta está vacio, cogemos los datos de input Ruta2
            //sino lo cogemos del input Ruta y le concatenamos la carpeta
            if($_FILES['Ruta']['name']==''){
                $Ruta=$_REQUEST['Ruta2'];
            }else{
                $Ruta="../Files/".basename($IdTrabajo)."/".basename($_FILES['Ruta']['name']);
            }
        }else{
            $Ruta=$_REQUEST['Ruta2'];
        }

        $action = $_REQUEST['action'];

        //crea una entrega
        $ENTREGA = new ENTREGA_Model(
            $login,
            $IdTrabajo,
            $Alias,
            $Horas,
            $Ruta);

        return $ENTREGA;
    }

    //Genera cadena aleatoria de un tamaño pasado como parametro
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        //asigna un carcarter a la variable randomString hasta el tamaño solicitado
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
            if($Permi->check('ENTREGA','ADD', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    $ENTREGA = new ENTREGA_Model('','','','','');
                    $trabajos=$ENTREGA->fetchIdTrabajo();
                    $login=$ENTREGA->fetchLogin();
                    new Entrega_ADD($trabajos,$login);
                }
                else{
                    $ENTREGA = get_data_form();
                    $respuesta = $ENTREGA->ADD();
                    new MESSAGE($respuesta, '../Controllers/Entrega_Controller.php');
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
            if($Permi->check('ENTREGA','DELETE', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    $ENTREGA = new ENTREGA_Model($_REQUEST['login'],$_REQUEST['IdTrabajo'], '', '','');
                    $valores = $ENTREGA->RellenaDatos();
                    new Entrega_DELETE($valores);
                }
                else{
                    $ENTREGA = new Entrega_Model($_REQUEST['login'],$_REQUEST['IdTrabajo'], '', '',$_REQUEST['Ruta']);
                    $respuesta = $ENTREGA->DELETE();

                    new MESSAGE($respuesta, '../Controllers/Entrega_Controller.php');
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
            if($Permi->check('ENTREGA','EDIT', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    if($Permi->check('ENTREGA','GESTIONENTREGA', $_SESSION['login'])){

                        $ENTREGA = new ENTREGA_Model($_REQUEST['login'],$_REQUEST['IdTrabajo'], '', '','');
                        $valores = $ENTREGA->RellenaDatos();
                        new Entrega_EDIT2($valores);
                    }else{
                        $ENTREGA = new ENTREGA_Model($_REQUEST['login'],$_REQUEST['IdTrabajo'], '', '','');
                        $valores = $ENTREGA->RellenaDatos();
                        $fechaTrabajo = $ENTREGA->getFechasFin();
                        $fechaTrabajo2 = date_create(substr($fechaTrabajo,0,4).'-'.substr($fechaTrabajo,5,6).'-'.substr($fechaTrabajo,8,9));
                        $hoy=getdate();
                        $fechaActual=date_create($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);

                        //si la fechaactual es mayor que la fecha de la Entrega muestra mensaje de error
                        //sino llama a vista de editar
                        if($fechaTrabajo2<$fechaActual){
                            $respuesta="Ha expirado el plazo para editar esta entrega";
                            new MESSAGE($respuesta, '../Controllers/Entrega_Controller.php');

                        }else{
                            new Entrega_EDIT($valores);
                        }

                    }

                }
                else{
                    $ENTREGA = get_data_form();
                    $respuesta = $ENTREGA->EDIT();
                    new MESSAGE($respuesta, '../Controllers/Entrega_Controller.php');
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
            if($Permi->check('ENTREGA','SEARCH', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){
                    $ENTREGA = new ENTREGA_Model('','','','','');
                    $trabajos=$ENTREGA->fetchIdTrabajo();
                    $login=$ENTREGA->fetchLogin();
                    new Entrega_SEARCH($trabajos,$login);
                }
                else{
                    $ENTREGA = get_data_form();
                    $datos = $ENTREGA->SEARCH();
                    $lista = array('login','IdTrabajo','Alias','Horas','Ruta');
                    new Entrega_SHOWALL($lista, $datos, '../Controllers/Entrega_Controller.php');
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
            if($Permi->check('ENTREGA','SHOWCURRENT', $_SESSION['login'])){

                $ENTREGA = new Entrega_Model('',$_REQUEST['IdTrabajo'],'', '','','');
                $valores = $ENTREGA->RellenaDatos();
                new Entrega_SHOWCURRENT($valores);
                break;
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        default:

            //comprueba si el usuario tiene permisos para realizar la acción
            //sino muestra mensaje
            if($Permi->check('ENTREGA','SHOWALL', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){

                    //comprueba si el tiene permisos para realizar esta accion, propia de un admin, muestra todas las Entregas
                    //sino siguiente if
                    if($Permi->check('ENTREGA','GESTIONENTREGA', $_SESSION['login'])){
                        $ENTREGA = new Entrega_Model('','','','','');
                        $datos = $ENTREGA->AllData2();


                    }else{

                        //Comrueba si el formulario trae algun valor en el campo FechaFinTrabajo, para saber si Viene de Trabajos o del Asider
                        if(isset($_REQUEST['FechaFinTrabajo'])){
                            $ENTREGA = new Entrega_Model($_SESSION['login'],$_REQUEST['IdTrabajo'],'','','');
                            $toret=$ENTREGA->EntregaCreada();
                        }else{
                            //Viene del Aside
                            $ENTREGA = new Entrega_Model($_SESSION['login'],'','','','');
                        }

                        //Si viene desde Trabajos comprueba las Fechas
                        //sino busca las Entregas
                        if (isset($_REQUEST['FechaFinTrabajo'])){

                            $fechaFin = $ENTREGA->getFechasFin();
                            $fechaFin2 = date_create(substr($fechaFin,0,4).'-'.substr($fechaFin,5,6).'-'.substr($fechaFin,8,9));
                            $fechaIni = $ENTREGA->getFechasIni();
                            $fechaIni2 = date_create(substr($fechaIni,0,4).'-'.substr($fechaIni,5,6).'-'.substr($fechaIni,8,9));
                            $hoy=getdate();
                            $fechaActual=date_create($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
                            $comparacion=$fechaFin2<$fechaActual;
                            $comparacion2=$fechaActual>$fechaIni2;

                            //Si la fecha actual esta entre la fecha inicial del trabajo y la final
                            //sino mensaje
                            if($comparacion!=1 && $comparacion2==1 ){

                                //si tiene una entrega creada, las busca
                                //sino las crea
                                if ($toret == true) {
                                    
                                    $datos = $ENTREGA->SearchEntregas();
                                } else {

                                    $ENTREGA->generarEntregas();
                                    $datos = $ENTREGA->SearchEntregas();
                                }

                            }else{
                                $respuesta="Ha expirado el plazo para editar esta entrega";
                                new MESSAGE($respuesta, '../Controllers/TRABAJO_Controller.php');
                                break;
                            }

                        }else{
                            $datos = $ENTREGA->SearchEntregas();
                        }

                    }

                }
                else{
                    //viene por post
                    $ENTREGA = new ENTREGA_Model($_REQUEST['login'],$_REQUEST['IdTrabajo'], '', '','');
                    $datos = $ENTREGA->AllData();
                }

                $lista = array('login','IdTrabajo','Alias','Horas','Ruta');
                new Entrega_SHOWALL($lista, $datos, '../Controllers/Entrega_Controller.php');
                break;

            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
    }

}
?>
