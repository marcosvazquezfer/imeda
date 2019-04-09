<?php

/**
 * Archivo php donde se muestra el apartado Showcurrent funcionalidad
 * Autor: Ruben -Grupo Imeda
 * Fecha: 28/11/2017
 */

class AsignacionQA_SHOWCURRENT {

    function __construct($funcion){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($funcion);

    }


//función que pinta la vista
    function pinta($funcion){
        //comprueba si hay un idioma en $_SESSION
        //si no, inserta el idioma español
        if(!isset($_SESSION['idioma'])){
            $_SESSION['idioma'] = 'SPANISH';
        }

        include_once '../Locales/Strings_index.php';
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
                        <h5>IdTrabajo</h5>
                        <span> <?php echo $funcion['IdTrabajo']; ?> </span>
                    </li>
                    <li>
                        <h5>Login Evaluador</h5>
                        <span><?php echo $funcion['LoginEvaluador']; ?></span>
                    </li>
                    <li>
                        <h5>Login Evaluado</h5>
                        <span> <?php echo $funcion['LoginEvaluado']; ?> </span>
                    </li>
                    <li>
                        <h5>Alias Evaluado</h5>
                        <span> <?php echo $funcion['AliasEvaluado']; ?> </span>
                    </li>
                </ul>
                <div class="boton-grup">
                    <form action="../Controllers/AsignacionQA_Controller.php" method="">
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
        <script src="../js/main.js"></script>
        <?php include '../Views/js/validaciones.js' ?>
        <script type="text/javascript" src="../js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>
