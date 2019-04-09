<?php

/**
 * Vista que muestra todas las acciones en detalle que hay en la BD
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

include_once '../Functions/Authentication.php';


class Entrega_SHOWCURRENT {

    function __construct($group){

        $this->pinta($group);

    }
//función que pinta la vista
    function pinta($group){
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
                        <h5><?php echo $strings['login']; ?></h5>
                        <span> <?php echo $group['login']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Id Trabajo']; ?></h5>
                        <span> <?php echo $group['IdTrabajo']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Alias']; ?></h5>
                        <span><?php echo $group['Alias']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Horas']; ?></h5>
                        <span> <?php echo $group['Horas']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Ruta']; ?></h5>
                        <span> <?php echo $group['Ruta']; ?> </span>
                    </li>

                </ul>
                <div class="boton-grup">
                    <form action="../Controllers/Entrega_Controller.php" method="">
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
        </body>
        </html>

        <?php

    }
}
?>