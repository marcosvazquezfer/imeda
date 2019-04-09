<?php

/**
 * Archivo php donde se muestra el apartado Showcurrent historia
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */


class HISTORIA_SHOWCURRENT {

    function __construct($funcion){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($funcion);

    }


    //función que contiene la vista
    function pinta($funcion){
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

            <div class="form2">
                <h4><?php echo $strings['ShowCurrent']; ?></h4>
                <ul>
                    <li>
                        <h5><?php echo $strings['Id Trabajo']; ?></h5>
                        <span> <?php echo $funcion['IdTrabajo']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Id Historia']; ?></h5>
                        <span><?php echo $funcion['IdHistoria']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Texto Historia']; ?></h5>
                        <span> <?php echo $funcion['TextoHistoria']; ?> </span>
                    </li>
                </ul>
                <div class="boton-grup">
                    <form action="../Controllers/Historia_Controller.php" method="">
                        <button name="action" value="" type="submit" class="boton-env">
                            <img src="../Views/imgs/ok.png" alt="">
                        </button>
                    </form>

                </div>

            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 11/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: yn8idg</h6>
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
