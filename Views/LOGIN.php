<?php

/**
 * Vista que nos permite loguearnos
 * Autor: Lara -Grupo Imeda
 * Fecha: 29/11/2017
 */
    include_once '../Functions/Authentication.php';

    class Login {

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
                    <form class="form-basic" method="" action="../Controllers/Login_Controller.php" onsubmit="return comprobarlogin()">
                        <div class="form-group">
                            <label class="form-label" for="login"><?php echo $strings['Login']; ?></label>
                            <input type="text" class="form-control" maxlength="15" size="15" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,15)" id="login" name="login" tabindex="1">
                        </div>    
                        <div class="form-group">
                            <label class="form-label" for="password1"><?php echo $strings['Password']; ?></label>
                            <input type="password" class="form-control" maxlength="20" size="20" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,20)" id="password1" name="password" maxlength="5" tabindex="1" >
                        </div>
                        <button name="action" value="" type="submit" class="boton-env">
                            <img src="../Views/imgs/send.png" alt="">
                        </button>
                    </form> 
                    <form action="../Controllers/Registro_Controller.php" class="form-basic">
                       <input type="image" id="register" src="../Views/imgs/register.png">
                    </form>     
                </div>
                
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            <script src="../Views/js/md5.js"></script>
            <script src="../Views/js/main.js"></script>
            <?php include '../Views/js/validaciones.js'  ?>
            
        </body>
        </html>
        
        <?php
    
        }
    }
?>