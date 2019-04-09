<script type="text/javascript">
    /**
     * Funciones javascript para validar los campos de los formularios de las vistas de generacion automatica
     * Autor: Ruben -Grupo Imeda
     * Fecha inicio: 1/12/2017
     * Fecha fin: 1/12/2017
     */



//Borra la alerta del DOM
function messagedel(campo){

    document.getElementById(campo.id).parentElement.pseudoStyle("after","opacity","0");
    document.getElementById(campo.id).parentElement.pseudoStyle("after","content","''");

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


//comrprobarstartEspacio comprueba que no haya espacios al comienzo del valor introducido
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


//comprobarTexto comprueba que un campo sea menor de un numero de caracteres(size) solicitado
function comprobarTexto(campo, size){

    //Comprobamos que la longitud de un value es menor de una dada(size)
    if(campo.value.length > size){
        message("<?php echo $strings['Introduce less of']; ?> " + size + " <?php echo $strings['characters for']; ?> " + campo.name,campo);

        return false;
    }
    return true;
}


//Funcion que comprueba que el numero de asignacion sea correcto para el
//formulario de la vista AsignacionQA_GENERAR
function generaQA(n){

   var id; //almacena input numero de asignacion
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

   id = document.getElementById("NumeroAsig"+n);
    toret =true;

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,2))){
        toret = false;

    }


    return toret;
}

</script>
