<script type="text/javascript">
    /**

     * Funciones javascript para validar los campos de los formularios de las vistas de Entregas
     * Autor: Mauri-GRUPO IMEDA
     * Fecha inicio: 10/12/2017
     * Fecha fin: 21/12/2017

     */

//Expresion regular de espacio (" ")
var esp = /([ ])/;

//comprobarVacio comprueba que un campo no este vacio
function comprobarVacio(campo){

    //Si la longitud es 0 retornamos falso y mostramos mensaje
    if(campo.value.length === 0 || campo.value == ''){
        message("<?php echo $strings['El campo']; ?> " + campo.name + " <?php echo $strings['is empty']; ?>", campo);
        return false;
    }
    return true;
}

//comprobarstartEspacio comprueba que no haya espacios al comienzo del valor introducido
function comprobarstartEspacio(campo){

    //Expresion regular para un espacio al comienzo de un valor
    var esp = /^([ ])/;

    //Comprueba si hay espacios al inicia del valor introducido
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces at beginning']; ?>",campo);
        return false;

    }

    return true;
}


//comprobarEntero comprueba que un numero sea entero y esté entre dos valores solicitados para el formulario Search
function comprobarEnteroSearch(campo, valormenor, valormayor){

    //reg es la expresion regular para comprobar que es un numero entero
    var reg = /([0-9])+/;

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


//comprobarEntero comprueba que un numero sea entero y esté entre dos valores solicitados
function comprobarEntero(campo, valormenor, valormayor){

    //reg es la expresion regular para comprobar que es un numero entero
    var reg = /^([0-9]){0,2}$/;

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


//comprobarAlfaNumerico comprueba que un campo esté formado por numeros, por letras o ambas
function comprobarAlfaNumerico(campo,size){

    // Expresion regular que contiene todos los valores que se pueden aceptar
    var letras = /^[a-zA-Z0-9ñÑ]{6}$/;

    //Comprueba si el valor introducido contiene algun caracter no permitido
    //sino devuelve true
    if(!letras.test(campo.value)){

        //Si el tamaño del campo es distinto del solicitado, devolvemos falso y mostramos mensaje de error
        //sino, mostramos mensaje de error por caracter incorrecto
        if(campo.value.length != size){
            message("<?php echo $strings['Introduce un alias de 6 caracteres']; ?>",campo);
            return false;
        }else{
            message("<?php echo $strings['Introduced characters not allow']; ?>",campo);
            return false;
        }

    }
    return true;
}


//comprobarAlfaNumerico comprueba que un campo esté formado por numeros, por letras o ambas
//para el formulario Search
function comprobarAlfaNumericoSearch(campo,size){

    // Expresion regular que contiene todos los valores que se pueden aceptar
    var letras = /^[a-zA-Z0-9ñÑ]{0,6}$/;

    //Si el tamaño del campo es distinto del solicitado, devolvemos falso y mostramos mensaje de error
    if(!letras.test(campo.value)){
        message("<?php echo $strings['Introduced characters not allow']; ?>",campo);
        return false;
    }

    return true;
}

//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de añadir sean correctos al hacer submit
function comprobarEntADD(){

    var Alias = document.getElementById("Alias"); //almacena el valor del Alias del formulario
    var Horas = document.getElementById("Horas"); //almacena el valor de Horas del formulario
    var Ruta = document.getElementById("Ruta"); //Almacena el valor de Ruta del formulario
    var toret=true; //variable a devolver que comprueba que todos los valores son correctos o no

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarVacio(Alias) && comprobarstartEspacio(Alias) && comprobarAlfaNumerico(Alias,6) && comprobarEspacio(Alias))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarVacio(Horas) && comprobarstartEspacio(Horas) && comprobarEntero(Horas,0,99) && comprobarEspacio(Horas))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarVacio(Ruta))){
        toret = false;
    }

    return toret;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de editar sean correctos al hacer submit
function comprobarEntEDIT(){

    //Obtenemos los inputs del formulario
    var Alias = document.getElementById("Alias"); //almacena el valor del Alias del formulario
    var Horas = document.getElementById("Horas"); //almacena el valor de Horas del formulario
    var toret =true; //variable a devolver que comprueba que todos los valores son correctos o no

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarVacio(Alias) && comprobarstartEspacio(Alias) && comprobarAlfaNumerico(Alias,6) && comprobarEspacio(Alias))){
        toret = false;

    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarVacio(Horas) && comprobarstartEspacio(Horas) && comprobarEntero(Horas,0,99) && comprobarEspacio(Horas))){
        toret = false;

    }

    return toret;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de búsqueda sean correctos al hacer submit
function comprobarEntSEARCH(){

    //Obtenemos los inputs del formulario
    var Alias = document.getElementById("Alias");//almacena el valor del Alias del formulario
    var Horas = document.getElementById("Horas");//almacena el valor de Horas del formulario
    var Ruta = document.getElementById("Ruta2");//Almacena el valor de Ruta del formulario
    var toret=true;//variable a devolver que comprueba que todos los valores son correctos o no

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarstartEspacio(Alias) && comprobarAlfaNumericoSearch(Alias,6) && comprobarEspacio(Alias))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarstartEspacio(Horas) && comprobarEnteroSearch(Horas,0,99) && comprobarEspacio(this))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    //si estas funciones nos retornan falso ponemos a falso la variable toret
    if(!(comprobarstartEspacio(Ruta) && comprobarEspacio(Ruta))){
        toret = false;
    }
    return toret;
}


//comprobarEspacio comprueba que no haya valores de espacio (" ") en los valores introducidos
function comprobarEspacio(campo){

    //Si el valor introducido contiene espacios en blanco devuelve falso
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces']; ?>",campo);
        return false;
    }

    return true;
}



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


    _this = this; //almacena this
    _sheetId = "pseudoStyles"; //almacena el estilo
    _head = document.head || document.getElementsByTagName('head')[0]; //almacena el head
    _sheet = document.getElementById(_sheetId) || document.createElement('style'); //almacena archivo
    _sheet.id = _sheetId;
    className = "pseudoStyle" + UID.getNew(); //almacena nombre de la clase

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