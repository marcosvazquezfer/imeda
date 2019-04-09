<script type="text/javascript">

/**
 * Funciones javascript con las respectivas validaciones
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 11/11/2017
 * Fecha fin: 11/11/2017
 */


//En todas las funciones se pasa el parametro campo donde es el input que se comprueba
//Con campo.value solicitamos el valor solicitado de ese input


//Se puede encontrar la funcion message y messagedel(las cuales estan definidas al final del codigo) las cuales interactuan con el DOM 
//para mostrar el error en la interfaz



//funciona que comprueba que los valores de login y password son correctos

console.log("hh");
function comprobarlogin(){

    var log; //almacena input login formulario
    var pass; //almacena input password formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos


    log = document.getElementById("login");
    pass = document.getElementById("password1");
    toret =true;

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(log) && comprobarEspacio(log) && comprobarTexto(log,25))){
        toret = false;

    }

    //comprobarVacio comprueba que un campo no este vacio

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(pass) && comprobarEspacio(pass) && comprobarTexto(pass,20))){
        toret = false;

    }
    //si toret es true, es decir, no hubo ningun error se encripta la password
    if(toret==true){
        encriptar();
    }
    return toret;

}

//comprobarVacio comprueba que un campo no este vacio
function comprobarVacio(campo){

    //Comprobamos que la longitud es 0 o este vacio, si es así retornamos falso
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

    var letras;  // Expresion regular que contiene todos los valores que se pueden aceptar

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
    else{
        return true;
    }

}


//comprobarEntero comprueba que un numero entero este entre dos valores solicitados
function comprobarEntero(campo, valormenor, valormayor){
    
    var reg;//reg es la expresion regular para comprobar que es un numero entero
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



//comprobarDNI compruebe el formato de un  DNI
function comprobarDni(campo){
    var exprRegDNI;//Variable que almacena la expresion regular que verifica el DNI
    var num; //almacena subconjunto del campo
    var letra; //almacena subconjunto del campo (letra)
    var letras; //almacena posibles letras del DNI

    exprRegDNI = /^\d{8}[a-zA-Z]$/;

    if(exprRegDNI.test(campo.value)){
            /*
            Si el DNI insertado cumple la expresion regular permitida pasa a comprobar si la letra es la correcta para ese DNI,
            sino devuelve un mensaje de error y obliga al usuario a introducirlo bien
            */
            num = campo.value.substr(0,campo.value.length-1);//En este caso la variable almacena un subconjunto de los valores introducidos en el campo por el formulario
            letra = campo.value.substr(campo.value.length-1,1);//En este caso la variable almacena un subconjunto de los valores introducidos en el campo por el formulario
            num = num % 23;//En este caso al subconjunto almacenado en num se le aplica el modulo 23 y se almacena en la propia variable
            letras='TRWAGMYFPDXBNJZSQVHLCKET';//Almacenamos en la variable las posibles letras del DNI
            letras=letras.substring(num,num+1);//Almacenamos en la variable un subconjunto del subconjunto almacenado en la variable num
            if (letras!=letra.toUpperCase()) {
                /*
                Si la letra introducido por el usuario es distinta de las letras permitidas devuelve un mensaje de error y obliga al usuario a introducirlo bien,
                sino devuelve un mensaje de aprobacion y permite al usuario seguir introduciendo datos
                */
                message("<?php echo $strings['DNI erroneo, la letra del NIF no se corresponde']; ?>",campo);
                return false;
            }
            else{
                //El DNI insertado es correcto entonces devuelve un mensaje de satisfaccion y deja al usuario continuar
                message("",campo);
                return true;
            }
        }
        else{
            //El DNI insertado no tiene el formato correcto y obliga al usuario a que lo introduzca bien
            message("<?php echo $strings['Incorrect format for DNI']; ?>",campo);
            return false;
        }
}



//Comprueba validez de un telefono
function comprobarTelf(campo)  {

    var valor; //almacena el valor de campo pasado como parametro
    var comprobar; //almacena expresión regular que valida formato
    var comprobar2; //almacena expresión regular que valida tamaño

    valor=campo.value; //tomamos el valor del campo
    comprobar=/^(34)\d{9}$/; //expresion regular valida telefono con formato internacional
    comprobar2=/^\d{9}$/;  //expresion regular valida telefono normal

    //si el tamaño introducido es igual a 9 comprobamos formato sin prefijo
    //sino comprobamos si cumple el formato con prefjo
    if(valor.length==9){

        //si no cumple el formato devolvemos false
        //sino devolvemos true
        if(!comprobar2.test(valor)) {
            message("<?php echo $strings['Incorrect format number']; ?>",campo);
            return false;

        }else{
            message("",campo);
            return true;
        }
    }else{
        //si no cumple el formato devolvemos false
        //sino devolvemos true
        if(!comprobar.test(valor)) {
            message("<?php echo $strings['Incorrect format number']; ?>",campo);
            return false;

        }else{
            message("",campo);
            return true;
        }

    }

}


//comprobarEmail comprueba que el valor del input email tenga un formato de email correcto
function comprobarEmail(campo){

    var em; //expresion regular para email

    em = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    //Se comprueba que el valor dado tiene formato de un email
    if(!(em.test(campo.value))){
        message("<?php echo $strings['Incorrect format email']; ?>",campo);
        return false;
    }else{

        return true;

    }

    return true;

}

//comprobarEspacio comprueba que no haya valores de espacio (" ") en los valores introducidos
function comprobarEspacio(campo){
    var esp; //Expresion regular de espacio (" ")

    esp = /([ ])/;

    //Comprueba si el valor introducido contiene espacios en blanco
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces']; ?>",campo);
        return false;
    }

    return true;
}

//comrpobarstartEspacio comprueba que no haya espacios al comienzo del valor introducido
function comprobarstartEspacio(campo){    
        
        var esp;//Expresion regular para un espacio al comienzo de un valor
        var esp = /^([ ])/;
        
        //Comprueba si hay espacios al inicia del valor introducido
        if(esp.test(campo.value)){
            message("<?php echo $strings['Can not content whitespaces at beginning']; ?>",campo);
            return false;
            
        }

    return true;
}



//comprobar() es la funcion que al hacer el submit comprueba todos los inputs del formulario.
//n difiere entre dos formularios (ADD y EDIT) para que su interacctuacion en el DOM sea correcta 
function comprobar(n){
    
    //Obtenemos los inputs del formulario
    var log;
    var pass;
    var em;
    var name ;
    var sur;
    var tele;
    var dir;
    var dni;
    var toret;

    log = document.getElementById("login"+n);
    pass = document.getElementById("password"+n);
    em = document.getElementById("Correo"+n);
    name = document.getElementById("Nombre"+n);
    sur = document.getElementById("Apellidos"+n);
    tele = document.getElementById("Telefono"+n);
    dir = document.getElementById("Direccion"+n);
    dni = document.getElementById("DNI"+n);
    toret =true;


    //comprobamos los inputs con sus respectivas funciones de comprobaciones 
    if(!(comprobarVacio(log) && comprobarEspacio(log) && comprobarTexto(log,9))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(pass) && comprobarEspacio(pass) && comprobarTexto(pass,20))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(name) && comprobarstartEspacio(name) && comprobarAlfabetico(name,30))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(sur) && comprobarstartEspacio(sur) && comprobarAlfabetico(sur,50))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(em) && comprobarEmail(em,40) && comprobarTexto(em,40))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(tele) && comprobarEspacio(tele) && comprobarTelf(tele))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(dir) && comprobarstartEspacio(dir) && comprobarTexto(dir,60))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(dni) && comprobarDni(dni))){
        toret = false;
        
    }

    //si no ha fallado nada, es decir, si toret es true, se llama a encriptar
    if(toret == true){
        encriptar();
    }
    
    return toret;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de editar sean correctos al hacer submit
function comprobaredit(n){
    

    var log; //almacena input formulario
    var pass; //almacena input formulario
    var em; //almacena input formulario
    var name; //almacena input formulario
    var sur; //almacena input formulario
    var tele; //almacena input formulario
    var dir; //almacena input formulario
    var dni; //almacena input formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos


    log = document.getElementById("login"+n);
    pass = document.getElementById("password"+n);
    em = document.getElementById("Correo"+n);
    name = document.getElementById("Nombre"+n);
    sur = document.getElementById("Apellidos"+n);
    tele = document.getElementById("Telefono"+n);
    dir = document.getElementById("Direccion"+n);
    dni = document.getElementById("DNI"+n);
    toret =true;


    //comprobamos los inputs con sus respectivas funciones de comprobaciones 
    if(!(comprobarVacio(log) && comprobarEspacio(log) && comprobarTexto(log,9))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(pass) && comprobarEspacio(pass) && comprobarTexto(pass,120))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(name) && comprobarstartEspacio(name) && comprobarAlfabetico(name,30))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(sur) && comprobarstartEspacio(sur) && comprobarAlfabetico(sur,50))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(em) && comprobarEspacio(em) && comprobarEmail(em,40) && comprobarTexto(em,40))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(dir) && comprobarstartEspacio(dir) && comprobarTexto(dir,60))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(tele) && comprobarEspacio(tele) && comprobarTelf(tele))){
        toret = false;
        
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(dni) && comprobarDni(dni))){
        toret = false;
        
    }

    //si no ha fallado nada, es decir, si toret es true, se llama a encriptar
    if(toret == true){
        encriptar();
    }

    return toret;
}

//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de Search sean correctos al hacer submit
function comprobarbus(){


    var log; //almacena input formulario
    var pass; //almacena input formulario
    var em; //almacena input formulario
    var name; //almacena input formulario
    var sur; //almacena input formulario
    var tele; //almacena input formulario
    var dni; //almacena input formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    
    log = document.getElementById("login2");
    pass = document.getElementById("password1");
    name = document.getElementById("name2");
    sur = document.getElementById("surname2");
    em = document.getElementById("email2");
    date = document.getElementById("date2");
    tele = document.getElementById("telefono2");
    dni = document.getElementById("DNI2");
    toret =true;

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarTexto(log) && comprobarEspacio(log) && comprobarEspacio(log))){
        toret = false;
    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarTexto(pass,25) && comprobarEspacio(pass) && comprobarEspacio(pass))){
        toret = false;
    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarAlfabetico(name,20) && comprobarstartEspacio(name))){
        toret = false;
    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarAlfabetico(sur,25) && comprobarstartEspacio(sur))){
        toret = false;
    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarEspacio(em) && comprobarTexto(em,50))){
        toret = false;
    }

    //si no es true
    if(!(true)){
        toret = false;
    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarEspacio(tele))){
        toret = false;
    }
        //si no es true
    if(!(true)){
        toret = false;  
    }
    

    return toret;
}





//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de ADD (Historia) sean correctos al hacer submit
function comprobarHistoriaAdd(){

    var id; //almacena input formulario
    var id2; //almacena input formulario
    var text; //almacena input formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    id = document.getElementById("idHistoria1");
    id2 = document.getElementById("idTrabajo1");
    text = document.getElementById("TextoHistoria1");
    toret =true;

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(text) && comprobarstartEspacio(text) && comprobarTexto(text,300))){
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