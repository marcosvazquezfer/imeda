<?php
/**
 * Archivo php donde se gestiona las acciones principales para una nota
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php';
include '../Views/MESSAGE.php';

//comrpueba si está autenticado
if (!IsAuthenticated()){

    new MESSAGE('You need sign in', '../Controllers/Login_Controller.php');

}else{


    require_once("../Models/PERMISO_Modelo.php");
    require_once('../Models/NOTAS_Model.php');
    require_once("../Models/ASIGNARNOTAS_Model.php");
    include '../Views/Notas/Notas_SHOWALL.php';
    include '../Views/Notas/Notas_ADD.php';
    include '../Views/Notas/Notas_SEARCH.php';
    include '../Views/Notas/Notas_SHOWCURRENT.php';
    include '../Views/Notas/Notas_EDIT.php';
    include '../Views/Notas/Notas_DELETE.php';
    include '../Views/Notas/Notas_CONSULTARET.php';
    include '../Views/Notas/Notas_CONSULTARQA.php';
    include '../Views/Notas/MisNotas_VIEW.php';
    include '../Views/Notas/Notas_Admin.php';
    include '../Views/GenerarNotas/NotasEntregas_GENERAR.php';
    include '../Views/GenerarNotas/NotasQAS_GENERAR.php';

    //recoge los valores del formulario
    function get_data_form(){

        $login = $_REQUEST['login'];
        $IdTrabajo = $_REQUEST['IdTrabajo'];
        $NotaTrabajo = $_REQUEST['NotaTrabajo'];
        $action = $_REQUEST['action'];

        //crea un objeto nota
        $NOTA = new NOTAS_Model(
            $login,
            $IdTrabajo,
            $NotaTrabajo);

        return $NOTA;
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

            $NOTA;//almacena los valores obtenidos del form
            $respuesta;//almacena la respuesta que almacena el mensaje

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','ADD', $_SESSION['login'])){

                //si entra por get
                if (!$_POST){
                    new Notas_ADD();
                }
                //si entra por post
                else{
                    $NOTA = get_data_form();
                    $respuesta = $NOTA->ADD();
                    new MESSAGE($respuesta, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }


        //acción eliminar
        case 'DELETE':

            $NOTA;//almacena un objeto nota
            $valores;//almacena un objeto nota con sus valores
            $respuesta;//almacena la respuesta que almacena el mensaje

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','DELETE', $_SESSION['login'])){

                //si entra por get
                if (!$_POST){
                    $NOTA = new NOTAS_Model($_REQUEST['login'], '', '');
                    $valores = $NOTA->RellenaDatos();
                    new Notas_DELETE($valores);
                }
                //si entra por post
                else{
                    $NOTA = new NOTAS_Model($_REQUEST['login'],'', '');
                    $respuesta = $NOTA->DELETE();
                    new MESSAGE($respuesta, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción editar
        case 'EDIT':

            $NOTA;//almacena un objeto nota
            $valores;//almacena un objeto nota con sus valores
            $respuesta;//almacena la respuesta que almacena el mensaje

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','EDIT', $_SESSION['login'])){

                //comprueba si entra por get o por post
                if (!$_POST){

                    $NOTA = new NOTAS_Model($_REQUEST['login'],'', '');
                    $valores = $NOTA->RellenaDatos();
                    new Notas_EDIT($valores);
                }
                else{
                    $NOTA = get_data_form();
                    $respuesta = $NOTA->EDIT();
                    new MESSAGE($respuesta, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

        //acción buscar
        case 'SEARCH':

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','SEARCH', $_SESSION['login'])){

                $NOTA;//almacena los valores obtenidos del form
                $datos;//almacena la respuesta que almacena el mensaje
                $lista;//almacena un array

                //si entra por get
                if (!$_POST){
                    new Notas_SEARCH();
                }
                //si entra por post
                else{
                    $NOTA = get_data_form();
                    $datos = $NOTA->SEARCH();
                    $lista = array('login','IdTrabajo','NotaTrabajo');
                    new Notas_SHOWALL($lista, $datos, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        //acción consultar correcion de la entrega
        case 'CONSULTAET':

            $NOTA;//almacena un objeto nota
            $id;//almacena una concatenación de caracteres
            $hist;//almacena historias
            $datos;//almacena QAS
        
            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','CONSULTAET', $_SESSION['login'])){
     
                $NOTA = new NOTAS_Model($_REQUEST['login'],'', '');
                $hist = $NOTA->getHist($_REQUEST['IdTrabajo']);
                $datos = $NOTA->fetchQAs($_REQUEST['IdTrabajo'],$_REQUEST['login']);
                new Notas_CONSULTARET($datos,$hist);
            
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

            break;
        //acción consultar todas los resultados de los trabajos 
        case 'CONSULTARESUL':
        
            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','CONSULTARESUL', $_SESSION['login'])){

                $NOTA = new NOTAS_Model($_SESSION['login'],'', '');
                
                $datos = $NOTA->fetchTrabAlu();
                new Notas_SHOWALL($datos,'../Controllers/NOTAS_Controller.php');

            //sino muestra mensaje
            }else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
            break;
        //acción consultar correcion de la qa
        case 'CONSULTAQA':

            $NOTA;//almacena un objeto nota
            $hist;//almacena historias
            $datos;//almacena QAS
        
            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','CONSULTAQA', $_SESSION['login'])){
                $trab='ET'.substr($_REQUEST['IdTrabajo'],2);
                $NOTA = new NOTAS_Model($_REQUEST['login'],'', '');
                $hist = $NOTA->getHist($trab);
                $datos = $NOTA->fetchQAscorr($_REQUEST['IdTrabajo'],$_REQUEST['login']);
                new Notas_CONSULTARQA($datos,$hist);
                
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
            break;
        //acción mostrar en detalle
        case 'SHOWCURRENT':

            $NOTA;//almacena un objeto nota
            $valores;//almacena el objeto nota con sus valores

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','SHOWCURRENT', $_SESSION['login'])){
                $NOTA = new NOTAS_Model($_REQUEST['login'],'', '');
                $valores = $NOTA->RellenaDatos();
                new Notas_SHOWCURRENT($valores);
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        //acción asignar notas de entregas
        case 'ENTREGAS':

            $NOTA;//almacena un objeto nota
            $trabajos;//almacena trabajos
            $IdTrabajo;//almacena el id
            $modelo;//almacena un objeto asignarnotas
            $entregas;//almacnea entregas
            $LoginsEvaluado;//almacena un array
            $datos;//almacena objetos

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','ASIGNARNOTASENTREGAS', $_SESSION['login'])){

                //si entra por get
                if (!$_POST){
                    $NOTA = new ASIGNARNOTAS_Model('', '', '');
                    $trabajos = $NOTA->buscarTrabajo();
                    new NotasEntregas_GENERAR($trabajos);
                }
                //si entra por post
                else{
                    $IdTrabajo = $_REQUEST['NombreTrabajo'];
                    $modelo = new ASIGNARNOTAS_Model('','','');
                    $entregas = $modelo->buscarEntregas($IdTrabajo);
                    $LoginsEvaluado = array();

                    //mientras existan elemento los va metiendo en un array
                    while($row = $entregas->fetch_array()){
                        array_push($LoginsEvaluado,$row['login']);
                    }

                    //repite el proceso tantas veces como numero de usuarios de los que se quiere calcular la nota hay
                    for($i=0;$i<count($LoginsEvaluado);$i++){
                        $datos=$modelo->GeneraNotasEntregas($IdTrabajo,$LoginsEvaluado[$i]);
                        $numHistorias = 0;//contador de historias
                        $correctos = 0;//contador de historias correctas
                        $nota = 0;//almacena la nota de la entrega

                        //mientras existan elementos incrementa el contador
                        while ($row = $datos->fetch_array()) {
                            $numHistorias++;

                            //si cumple la condición incrementa el contador
                            if($row['CorrectoP']==1){
                                $correctos++;
                            }  
                        }

                        $nota=($correctos*10)/$numHistorias;
                        $modelo->InsertarNotas($LoginsEvaluado[$i],$IdTrabajo,$nota);
                   }
                    $respuesta='Success insert';
                    new MESSAGE($respuesta, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
            //acción asignar notas de QAS
        case 'QAS':

            $NOTA;//almacena un objeto asignarnotas
            $trabajos;//almacena trabajos
            $IdTrabajo;//almacena el id
            $QA;//almacena una concatenación de caracteres
            $modelo;//almacena un objeto asignarnotas
            $qas;//almacena QAS
            $LoginsEvaluador;//almacena un array
            $AliasEvaluado;//almacena un array
            $respuesta;//almacena un mensaje

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','ASIGNARNOTASQAS', $_SESSION['login'])){

                //si entra por get
                if (!$_POST){
                    $NOTA = new ASIGNARNOTAS_Model('', '', '');
                    $trabajos = $NOTA->buscarTrabajo2();
                    new NotasQAS_GENERAR($trabajos);
                }
                //si entra por post
                else{
                    $IdTrabajo = $_REQUEST['NombreTrabajo'];
                    $QA="ET".substr($IdTrabajo, 2);
                    $modelo = new ASIGNARNOTAS_Model('','','');
                    $qas = $modelo->buscarQAS($QA);
                    $LoginsEvaluador = array();
                   
                    //mientras existan elementos los mete en un array
                    while($row = $qas->fetch_array()){
                        array_push($LoginsEvaluador,$row['LoginEvaluador']);
                    }

                    //repite el proceso tantas veces como numero de usuarios de los que se quiere calcular la nota hay
                    for($i=0;$i<count($LoginsEvaluador);$i++){

                        $notaF=0;//almacena la nota final del usuario
                        $qas = $modelo->buscarQAS2($QA,$LoginsEvaluador[$i]);
                        $AliasEvaluado=array();

                        //mientras existan elementos, los mete en un array
                        while($row = $qas->fetch_array()){
                            array_push($AliasEvaluado,$row['AliasEvaluado']);
                        }
                        
                        //repite el proceso tantas veces como trabajos tenga que evaluar el usuario
                        for($u = 0; $u < count($AliasEvaluado);$u++){ 
                            $datos=$modelo->GeneraNotasQAS($QA,$LoginsEvaluador[$i],$AliasEvaluado[$u]);
                            //$correctoP = 0;//contador de correctos del profesor
                            $numHistorias = 0;
                            $ok=0;//contador de oks del usuario
                            $nota = 0;//almacena la suma de las notas de cada qa

                            //mientras existan elementos
                            while($row = $datos->fetch_array()) {

                                /*//si el atributo cumple la condición incrementa el contador
                                if($row['CorrectoP'] == 1){
                                    $correctoP++;
                                }
                                else{
                                    if($row['CorrectoP'] == 1 && $row['OK']==1){
                                        $correctoP++;
                                    }
                                }*/
                                $numHistorias++;
                                //si el atributo cumple la condición incrementa el contador
                                if($row['OK']==1){
                                    $ok++;
                                }  
                            } 
                            $nota=($ok*10)/$numHistorias;
                            $notaF = $notaF + $nota;
                        }
                        $notaF = $notaF/count($AliasEvaluado);
                        $modelo->InsertarNotas($LoginsEvaluador[$i],$IdTrabajo,$notaF);
                    }
                    $respuesta='Success insert';
                    new MESSAGE($respuesta, '../Controllers/NOTAS_Controller.php');
                }
                break;
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }
        case 'MISNOTAS':

                $NOTA; //almacena un objeto de AsignarNotas_Model
                $datosTodos; //almacena en un array todos los datos para la muestra de notas para el admin
                $TRABAJOS; //almacena los trabajos que hay disponibles
                $trabajostodos; //array que almacena todos los nombres de los trabajos
                $row; //almacena una tupla de las consultas
                $notas; //almacena en un array todos los datos para la muestra de notas para un usuario



                //Comprueba que tengas permiso para ver la vista de admin
                //si true, recoge los datos para la vista de admin y muestra la vista
                //si false, recoge los datos para el usuario y los muestra en la vista
                if($Permi->check('NOTAS','NOTASADMIN', $_SESSION['login'])){
                    $NOTA = new ASIGNARNOTAS_Model('','','');

                    $datosTodos  = $NOTA->DatosNotasAdmin();

                    $TRABAJOS = $NOTA->Trabajos();

                    $trabajostodos =array();

                    //while que recorre todas las tuplas devueltas y las almacena en un array
                    while($row = $TRABAJOS->fetch_array()){
                        array_push($trabajostodos ,$row);
                    }



                    new Notas_Admin($datosTodos,$trabajostodos);


                }else{
                    $NOTA = new ASIGNARNOTAS_Model($_SESSION['login'],'','');
                    $notas = $NOTA->RellenaDatos2();
                    new MisNotas_VIEW($notas);
                }

                break;



        default:

            $NOTA;//almacena un objeto nota
            $datos;//almacena notas

            //comprueba si el usuario tiene permisos para realizar la acción
            if($Permi->check('NOTAS','SHOWALL', $_SESSION['login'])){
                $datos = array();

                //comprueba si el usuario tiene permisos para ver las notas de todos los usuarios
                if($Permi->check('NOTAS','MOSTRARNOTAS', $_SESSION['login'])){
                    $NOTA = new NOTAS_Model('','','');
                    $datos = $NOTA->AllData();
                }
                //si no le muestra solo las suyas
                else{
                    $NOTA = new NOTAS_Model('','','');
                    $datos = $NOTA->getNotasAlum($_SESSION['login']);
                } 
                new Notas_SHOWALL( $datos, '../Controllers/NOTAS_Controller.php');
            }
            //si no muestra mensaje
            else{
                new MESSAGE('You havent permissions', '../Controllers/Login_Controller.php');
                die();
            }

    }

}
?>