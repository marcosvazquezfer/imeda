<script type="text/javascript">
    /**
     * Funciones javascript para validar los campos de los formularios de las vistas de grupos
     * Autor: Mauri-Grupo Imeda
     * Fecha inicio: 30/11/2017
     * Fecha fin: 30/11/2017
     */



//Expresion regular de espacio (" ")
var esp = /([ ])/;


//comprobarVacio comprueba que un campo no esté vacio
function comprobarVacio(campo){

    //Comprobamos que la longitud no es 0
    if(campo.value.length === 0 || campo.value == ''){
        message("<?php echo $strings['El campo']; ?> " + campo.name + " <?php echo $strings['is empty']; ?>", campo);
        return false;
    }
    return true;
}


//comprobarTexto comprueba que un campo.value sea menor de un numero de caracteres(size) solicitado
function comprobarTexto(campo, size){

    //Comprobamos que la longitud de un value es menor de una dada(size)
    if(campo.value.length > size){
        message("<?php echo $strings['Introduce less of']; ?> " + size + " <?php echo $strings['characters for']; ?> " + campo.name,campo);

        return false;
    }
    return true;
}

//comprobarAlfabetico comprueba que el valor en el campo solo contenga letras del alfabeto español
//y sus respectivos acentos, dieresis o ñ  y un tamaño indicado
function comprobarAlfabetico(campo, size){

    var letras;//almacena expresion regular que contiene todos los valores que se pueden aceptar

   letras = /^(([a-zA-ZñÑáéíóúÁÉÍÓÚñ\s])*)$/;

    //Comprueba si el valor introducido contiene algun caracter no permitido
    if(!letras.test(campo.value)){
        message("<?php echo $strings['Introduced characters not allow']; ?>",campo);
        return false;
    }   //Si no se comprueba la longitud de valor introducido
    else if(campo.value > size){
        message("<?php echo $strings['Introduce less of']; ?> " + size + " <?php echo $strings['characters']; ?>",campo);
        return false;
    }
    else{//si cumple el tamaño retornamos true
        return true;
    }


}


//comprobarEntero comprueba que un numero entero este entre dos valores solicitados
function comprobarEntero(campo, valormenor, valormayor){

    var reg;  //reg es la expresion regular para comprobar que es un numero entero

    reg = /([0-9])+/;

    //Si el test de la expresion es correcto se conforma que es un numero sino se exige
    //un valor numerico
    if(!(reg.test(campo.value))){

        message("<?php echo $strings['Introduce numerical value']; ?>",campo);
        return false;

        //Si es un numero se comprueba que esta entre los dos valores dados(valormenor, valormayor)
    }else if(campo.value < valormenor || campo.value > valormayor){

        message("<?php echo $strings['Introduce a value between']; ?> " + valormenor + " <?php echo $strings['and']; ?> " + valormayor,campo);
        return false;

    }
    return true;

}


//comprobarEspacio comprueba que no haya valores de espacio (" ") en los valores introducidos
function comprobarEspacio(campo){

    //Comprueba si el valor introducido contiene espacios en blanco
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces']; ?>",campo);
        return false;
    }
    return true;
}


//comrpobarstartEspacio comprueba que no haya espacios al comienzo del valor introducido
function comprobarstartEspacio(campo){

    //Expresion regular para un espacio al comienzo de un valor
    var esp;

    esp= /^([ ])/;

    //Comprueba si hay espacios al inicia del valor introducido
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces at beginning']; ?>",campo);
        return false;

    }

    return true;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de inserción sean correctos al hacer submit
function comprobarAccionADD(){

    var id; //obtenemos input IdAccion del formulario
    var name; //obtenemos input NombreAccion del formulario
    var desc; //obtenemos input DescripAccion del formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    id = document.getElementById("IdAccion");
    name = document.getElementById("NombreAccion");
    desc = document.getElementById("DescripAccion");
    toret =true; //inicializamos a true

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(name) && comprobarEspacio(name) && comprobarTexto(name,60) && comprobarAlfabetico(name,60))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(desc) && comprobarstartEspacio(desc) && comprobarAlfabetico(desc,100) && comprobarTexto(desc,100))){
        toret = false;

    }
    return toret;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de edición sean correctos al hacer submit
function comprobarAccionEDIT(){

    var id; //obtenemos input IdAccion del formulario
    var name; //obtenemos input NombreAccion del formulario
    var desc; //obtenemos input DescripAccion del formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    //Obtenemos los inputs del formulario
    id = document.getElementById("IdAccion");
    name = document.getElementById("NombreAccion");
    desc = document.getElementById("DescripAccion");
    toret =true; //inicializamos a true

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(name) && comprobarEspacio(name) && comprobarTexto(name,60) && comprobarAlfabetico(name,60))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(desc) && comprobarstartEspacio(desc) && comprobarAlfabetico(desc,100) && comprobarTexto(desc,100))){
        toret = false;

    }
    return toret;
}

//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de búsqueda sean correctos al hacer submit
function comprobarAccionSEARCH(){

    var id; //obtenemos input IdAccion del formulario
    var name; //obtenemos input NombreAccion del formulario
    var desc; //obtenemos input DescripAccion del formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    //Obtenemos los inputs del formulario
    id = document.getElementById("IdAccion");
    name = document.getElementById("NombreAccion");
    desc = document.getElementById("DescripAccion");
    toret =true; //inicializamos a true


    //Comprobamos que se rellene al menos un campo
    if(!(comprobarVacioSEARCH(id) || comprobarVacioSEARCH(name) || comprobarVacioSEARCH(desc))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarEspacio(name) && comprobarTexto(name,60) && comprobarAlfabetico(name,60))){
        toret = false;

    }
    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarstartEspacio(desc) && comprobarAlfabetico(desc,100) && comprobarTexto(desc,100))){
        toret = false;

    }
    return toret;
}



//Funciones extras para interactuar con el DOM


//Utilidad para la funcion siguiente
var UID = {
    _current: 0,
    getNew: function(){
        this._current++;
        return this._current;
    }
};

//Busca los pseudoelementos en DOM dado unos parametros
HTMLElement.prototype.pseudoStyle = function(element,prop,value){
    var _this; //almacena this
    var _sheetId; //almacena el estilo
    var _head; //almacena el head
    var _sheet; //almacena archivo
    var className; //almacena la clase

    _this = this;
    _sheetId = "pseudoStyles";
    _head = document.head || document.getElementsByTagName('head')[0];
    _sheet = document.getElementById(_sheetId) || document.createElement('style');
    _sheet.id = _sheetId;
    className = "pseudoStyle" + UID.getNew();

    _this.className +=  " "+className;

    _sheet.innerHTML += " ."+className+":"+element+"{"+prop+":"+value+"}";
    _head.appendChild(_sheet);
    return this;
};


//Borra la alerta del DOM
function messagedel(campo){

    document.getElementById(campo.id).parentElement.pseudoStyle("after","opacity","0");
    document.getElementById(campo.id).parentElement.pseudoStyle("after","content","''");
}

//Muestra la alerta en el DOM
function message(alerta, campo){

    //si alerta es vacio ocultamos el estilo sobre el elemento
    //sino lo mostramos
    if(alerta === ""){
        document.getElementById(campo.id).parentElement.pseudoStyle("after","opacity","0");
        document.getElementById(campo.id).parentElement.pseudoStyle("after","content","'" + alerta + "'");
    }else{
        document.getElementById(campo.id).parentElement.pseudoStyle("after","opacity","1");
        document.getElementById(campo.id).parentElement.pseudoStyle("after","content","'" + alerta + "'");
    }
}


//Corrige un fallo con el input date dandole unos segundos para ejecutarse
function delay(campo){
    setTimeout(function() {
        comprobarVacio(campo);
    }, 400);
}


</script>