<?php

/**
 * Vista que nos permite añadir un usuario
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se muestra el apartado Añadir Usuario: yn8idg, Fecha: 11/11/2017
    class USUARIOS_ADD {

        function __construct(){

            $this->pinta();

        }

    
    //función que contiene la vista
    function pinta(){
        //comprueba si hay un idioma en $_SESSION
        //si no, inserta el idioma español
        if(!isset($_SESSION['idioma'])){
            $_SESSION['idioma'] = 'SPANISH'; 
        }

        include_once '../Locales/Strings_index.php';

        $stringslang;//almacena idioma
        $lang;//almacena el idioma en uso

        //bucle foreach que comprueba que idioma esta seleccionado para cargar los strings
        foreach($stringslang as $lang){
            //Comprueba que idioma está seleccionado y carga el strings correspondiente
            if($lang == $_SESSION['idioma'])
                include_once '../Locales/Strings_'. $lang .'.php';
        }

        include '../Views/HEADER_View.php';

        new HEADER();
        ?>

            <section>
                    
            <div class="form">

            <?php

                ?>
                    <h3><?php echo $strings['Add']; ?></h3>        
                <?php
               
            ?>
            
                <form class="form-basic" enctype="multipart/form-data" method="post" action="../Controllers/USUARIOS_Controller.php" onsubmit="return comprobar(1)">
                    <div class="form-group">
                        <label class="form-label" for="login"><?php echo $strings['Login']; ?></label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,9)" id="login1" name="login" tabindex="1">
                    </div>    
                    <div class="form-group">
                        <label class="form-label" for="password"><?php echo $strings['Password']; ?></label>
                        <input type="password" class="form-control" maxlength="20" size="12" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,20)" id="password1" name="password" maxlength="5"tabindex="1" >
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="DNI"><?php echo $strings['DNI']; ?></label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarDni(this); comprobarTexto(this,9)" id="DNI1" name="DNI" maxlength="5"  tabindex="1" >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Correo"><?php echo $strings['Email']; ?></label>
                        <input type="text" class="form-control" maxlength="40" size="42" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarEmail(this,40); comprobarTexto(this,40)" id="Correo1" name="Correo"  tabindex="1" >
                    </div>  
                    <div class="form-group">
                        <label class="form-label" for="Nombre"><?php echo $strings['Name']; ?></label>
                        <input type="text" class="form-control" maxlength="30" size="31" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarAlfabetico(this,30)" id="Nombre1" name="Nombre" tabindex="1" >
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="Apellidos"><?php echo $strings['Surname']; ?></label>
                        <input type="text" class="form-control" maxlength="50" size="53" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarAlfabetico(this,50)" id="Apellidos1" name="Apellidos"  tabindex="1" >
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="Telefono"><?php echo $strings['Phone']; ?></label>
                        <input type="text" class="form-control" maxlength="11" size="11" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTelf(this); comprobarTexto(this,11)" id="Telefono1" name="Telefono"  tabindex="1">
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="Direccion"><?php echo $strings['Adress']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="64" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarTexto(this,60)" id="Direccion1" name="Direccion" tabindex="1">
                    </div> 
                    
                    <button name="action" value="ADD" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                </form>
            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            <script src="../Views/js/md5.js"></script>
            <?php include '../Views/js/validaciones.js'; ?>
            <script src="../Views/js/main.js"></script>
        </body>
        </html>
        
        <?php
    
        }
    }
?>