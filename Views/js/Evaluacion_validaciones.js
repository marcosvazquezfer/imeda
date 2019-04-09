//Autor: Alex- Grupo Imeda
//Fecha: 22/12/2017
//Contiene las validacionees necesarias para lso formualrios de evaluaciones

//comprobarEVA hace comproibaciones de los campos de evaluaciones para añadir
function comprobarEva(){

    trabajo; //Guarda el valor de trabajo
    login; //Guarda el valore de login
    alias; //Guarda el valor de alias
    historia; //Guarda el valor de idHistoria
    comentA; //Guarda el valor del comentario del alumno
    comentP; //Guarda el valor del comentario del profesor
    correctoA; //Guarda el valor de la correcion del alumno
    correctoP; //Guarda el valor de la correcion del profesor
    
    var trabajo = document.getElementById("IdTrabajo");
    var login = document.getElementById("LoginEvaluador");
    var alias = document.getElementById("AliasEvaluado");
    var historia = document.getElementById("IdHistoria");
    var comentA = document.getElementById("ComenIncorrectoA");
    var comentP = document.getElementById("ComentIncorrectoP");
    var correctoA = document.getElementById("CorrectoA");
    var correctoP = document.getElementById("CorrectoP");


    var toret =true;
    
    
    //Comprueba que si el rtexto sea el requerido y no contenga espacios al principio del campo
    if(!(comprobarTexto(comentA,300) & comprobarstartEspacio(comentA) && comprobarAlfabetico(comentA))){
        if(!(correctoA.checked)){
            toret = false;
        }
    }
    //Comprueba que si el rtexto sea el requerido y no contenga espacios al principio del campo
    if(!(comprobarTexto(comentP,300) & comprobarstartEspacio(comentP) && comprobarAlfabetico(comentP))){
        if(!(correctoP.checked)){
            toret = false;
        }
    }
    

    return toret;
}

//comprobarEvabus() comprueba los campos de busqueda en evaluacion
function comprobarEvaBus(){

    comentA; //Guarda el valor del comentario del alumno
    comentP; //Guarda el valor del comentario del profesor
    
    var comentA = document.getElementById("ComenIncorrectoA");
    var comentP = document.getElementById("ComentIncorrectoP");

    var toret =true;

    //Comprueba que si el rtexto sea el requerido y no contenga espacios al principio del campo
    if(!( comprobarTexto(comentA,300) && comprobarstartEspacio(comentA) && comprobarAlfabetico(comentA))){
        toret = false;
    }
    //Comprueba que si el rtexto sea el requerido y no contenga espacios al principio del campo
    if(!( comprobarTexto(comentP,300) && comprobarstartEspacio(comentP) && comprobarAlfabetico(comentP))){
        toret = false;
    }
    
    

    return toret;
}

//Esta funcion hace que el select de historias se adapte al trabajo elegido
function chooseHist(){

    $trabajo; //Variable que guarda el value del select de trabajos

    $trabajo = document.getElementById("IdTrabajo").value;
    document.getElementsByClassName("show")[0].classList.add("hide");
    document.getElementsByClassName("show")[0].classList.remove("show");

    //Si existe la variable y su valor se muestra
    if($trabajo){
        document.getElementById($trabajo).classList.remove("hide");
        document.getElementById($trabajo).classList.add("show");

    //Sino se coge el select por defecto con todas las historias
    }else{
        document.getElementById("IdHistoria").classList.remove("hide");
        document.getElementById("IdHistoria").classList.add("show");
    }
}

