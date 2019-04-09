/**
 * Archivo php donde se situa funciones para el correcto funcionamiento de la pagina web
 * Autor: Alex-Grupo Imeda
 * Fecha inicio: 11/11/2017
 * Fecha fin: 11/11/2017
 */

//funcion que añade clase al menu
function menu(){

    var t = document.getElementById("menu");
    console.log(t);
    t.classList.add("show-aside");
    console.log(t);
    
}

//función que cambia la clase del menu
function hide(){
    document.getElementById("menu").classList.remove("show-aside");
}

//funcion que encripta contraseña
function encriptar(){
    
    document.getElementById('password1').value = hex_md5(document.getElementById('password1').value);
    return true;
}



