<?php

/**
 * Archivo php donde se muestran mensajes de error
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */
    class MESSAGE {

        function __construct($message,$dir){

            //if(!is_string($user))
            //$user = $user->fetch_array();
            $this->pinta($message,$dir);

        }

    
    //función que contiene la vista
    function pinta($message,$dir){
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
                    <h3><?php echo $strings[$message]; ?></h3>
                    <div class="boton-grup">
                        <form action="<?php echo $dir; ?>" method="">
                            <button name="action" value="" type="submit" class="boton-env">
                                <img src="../Views/imgs/ok.png" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            <script src="../Views/js/main.js"></script>
            <?php include '../Views/js/validaciones.js'  ?>
            <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>
        
        <?php
    
        }
    }
?>