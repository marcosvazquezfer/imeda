<script type="text/javascript">

    /**
     * Funciones javascript para validar los campos de los formularios de las vistas funcionalidades
     * Autor: Ruben -Grupo Imeda
     * Fecha inicio: 30/11/2017
     * Fecha fin: 30/11/2017
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

    //Expresion regular de espacio (" ")
    var esp = /([ ])/;

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

    //Comprueba si hay espacios al inicio del valor introducido, si los hay muestra mensaje
    if(esp.test(campo.value)){
        message("<?php echo $strings['Can not content whitespaces at beginning']; ?>",campo);
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


//Funcion que al hacer el submit comprueba todos los inputs del formulario.
//difiere entre dos formularios (ADD y EDIT) para que su interacctuacion en el DOM sea correcta
function comprobarFun(n){

    var id; //obtenemos input IdFuncionalidad del formulario
    var nombre; //obtenemos input nombreFuncionalidad del formulario
    var description; //obtenemos input DescripcionFuncionalidad del formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    id = document.getElementById("idFuncionalidad"+n);
    nombre = document.getElementById("nombreFuncionalidad"+n);
    description = document.getElementById("DescripcionFuncionalidad"+n);
    toret =true;


    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;

    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(nombre) && comprobarstartEspacio(nombre) && comprobarTexto(nombre,60) && comprobarAlfabetico(nombre,60))){
        toret = false;

    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(description) && comprobarstartEspacio(description) && comprobarTexto(description,100))){
        toret = false;

    }

    return toret;
}

//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de EDIT sean correctos al hacer submit
function comprobareditFun(n){

   var id; //obtenemos input IdFuncionalidad del formulario
   var nombre; //obtenemos input nombreFuncionalidad del formulario
   var descripcion; //obtenemos input DescripcionFuncionalidad del formulario
   var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    id = document.getElementById("idFuncionalidad"+n);
    nombre = document.getElementById("nombreFuncionalidad"+n);
    descripcion = document.getElementById("descripcionFuncionalidad"+n);
    toret =true;


    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(id) && comprobarEspacio(id) && comprobarTexto(id,6))){
        toret = false;

    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(nombre) && comprobarEspacio(nombre) && comprobarTexto(nombre,60) && comprobarAlfabetico(nombre,60))){
        toret = false;

    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarVacio(descripcion) && comprobarstartEspacio(descripcion) && comprobarTexto(descripcion,100))){
        toret = false;

    }

    return toret;
}


//Funcion que comprueba que los datos introducidos en todos los campos del
//formulario de SEARCH sean correctos al hacer submit
function comprobarbusFun(){

    var id; //obtenemos input IdFuncionalidad del formulario
    var nombre; //obtenemos input nombreFuncionalidad del formulario
    var descripcion; //obtenemos input DescripcionFuncionalidad del formulario
    var toret; //devuelve true o false en funcion de si los campos del formulario son correctos

    id = document.getElementById("IdFuncionalidad");
    nombre = document.getElementById("NombreFuncionalidad");
    descripcion = document.getElementById("DescripFuncionalidad");
    toret =true;

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarTexto(id,6) && comprobarEspacio(id) )){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarTexto(nombre,60) && comprobarEspacio(nombre) )){
        toret = false;
    }

    //comprobamos los inputs con sus respectivas funciones de comprobaciones
    if(!(comprobarAlfabetico(descripcion,100) && comprobarstartEspacio(descripcion))){
        toret = false;
    }

    return toret;
}
</script>