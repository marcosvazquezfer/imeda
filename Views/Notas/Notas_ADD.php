<?php
/**
 * Vista para añadir notas
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */

    class NOTAS_ADD {

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
                    <h3><?php echo $strings['Añadir Nota']; ?></h3>        
                <?php
               
            ?>
            
                <form class="form-basic" enctype="multipart/form-data" method="post" action="../Controllers/NOTAS_Controller.php" onsubmit="return comprobarNotasADD()">
                    <div class="form-group">
                        <label class="form-label" for="login"><?php echo $strings['Login']; ?></label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,9) ; comprobarEspacio(this); comprobarstartEspacio(this)" id="login1" name="login" placeholder="<?php echo $strings['Login']; ?>" tabindex="1">
                    </div>    
                    <div class="form-group">
                        <label class="form-label" for="idtrabajo"><?php echo $strings['Id Trabajo']; ?></label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,6); comprobarEspacio(this); comprobarstartEspacio(this)" id="idtrabajo1" name="IdTrabajo" tabindex="1" >
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="notatrabajo"><?php echo $strings['Nota Trabajo']; ?></label>
                        <input type="number" class="form-control" maxlength="4" size="4" step="0.5" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,6); comprobarEspacio(this)" id="notatrabajo1" name="NotaTrabajo" tabindex="1" >
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
            <?php include '../Views/js/Notas_validaciones.js'; ?>
            <script src="../js/main.js"></script>
        </body>
        </html>
        
        <?php
    
        }
    }
?>