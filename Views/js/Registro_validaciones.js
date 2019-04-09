<script type="text/javascript">
/**
 * Funciones javascript para validar los campos del formulario de registro
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 22/12/2017
 */

	var esp; //Expresion regular de espacio (" ")
	esp = /([ ])/;



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

		var letras;// Expresion regular que contiene todos los valores que se pueden aceptar

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
	    else{ //si cumple el tamaño retornamos true
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
            return true;
        }
    }else{
        //si no cumple el formato devolvemos false
        //sino devolvemos true
        if(!comprobar.test(valor)) {
            message("<?php echo $strings['Incorrect format number']; ?>",campo);
            return false;

        }else{
            return true;
        }

    }

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

			var esp; //Expresion regular para un espacio al comienzo de un valor

			esp = /^([ ])/;
	        
	        //Comprueba si hay espacios al inicia del valor introducido
	        if(esp.test(campo.value)){
	            message("<?php echo $strings['Can not content whitespaces at beginning']; ?>",campo);
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



	//Funcion que comprueba que los datos introducidos en todos los campos del 
	//formulario de inserción sean correctos al hacer submit
	function comprobarRegistro(){

		//Obtenemos los inputs del formulario
		var login; //obtenemos input login del formulario
		var passwd; //obtenemos input passwd del formulario
		var DNI; //obtenemos input Dni del formulario
		var email; //obtenemos input email del formulario
		var nombre; //obtenemos input nombre del formulario
		var apellido; //obtenemos input apellido del formulario
		var telefono; //obtenemos input telefono del formulario
		var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

	    login = document.getElementById("login1");
	    passwd = document.getElementById("password1");
	    DNI = document.getElementById("DNI1");
	    email = document.getElementById("email1");
	    nombre = document.getElementById("name1");
	    apellido = document.getElementById("surname1");
	    telefono = document.getElementById("telefono1");
	    toret =true;

	    //comprobamos los inputs con sus respectivas funciones de comprobaciones 
	    if(!(comprobarVacio(login) && comprobarEspacio(login) && comprobarTexto(login,9))){
	        toret = false;
	        
	    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(passwd) && comprobarEspacio(passwd) && comprobarTexto(passwd,20))){
	        toret = false;
	        
	    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(DNI) && comprobarEspacio(DNI) && comprobarDni(DNI) && comprobarTexto(DNI,9))){
	        toret = false;
	        
	    }

		//comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(email) && comprobarEspacio(email) && comprobarEmail(email) && comprobarTexto(email,40))){
	        toret = false;
	        
	    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(nombre) && comprobarEspacio(nombre) && comprobarAlfabetico(nombre,30) && comprobarTexto(nombre,30))){
	        toret = false;
	        
	    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(apellido) && comprobarEspacio(apellido) && comprobarAlfabetico(apellido,50) && comprobarTexto(apellido,50))){
	        toret = false;
	        
	    }

        //comprobamos los inputs con sus respectivas funciones de comprobaciones
	    if(!(comprobarVacio(telefono) && comprobarEspacio(telefono) && comprobarTelf(telefono) && comprobarTexto(telefono,11))){
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