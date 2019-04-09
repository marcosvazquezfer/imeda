<?php

/**
 * Archivo php donde nos permite generar las historias en evaluaciones
 * Autor: Ruben -Grupo Imeda
 * Fecha: 15/12/2017
 */

class AsignacionQA_GEN_HISTORIAS {

    function __construct($trabajos){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($trabajos);

    }


//función que pinta la vista
    function pinta($trabajos){
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
                <h4><?php echo $strings['Generación de Historias en evaluación automática']; ?></h4>
                <form action="../Controllers/AsignacionQA_Controller.php" method="post" onblur="generaQA(1)">
                    <select name="NombreTrabajo">
                        <?php
                        //bucle que inserta un option por cada tupla
                        while($row = $trabajos->fetch_array()){
                            ?>
                            <option value="<?php echo $row['IdTrabajo']?>" ><?php echo $row['NombreTrabajo']?></option>
                        <?php }?>
                    </select>

                    <div class="boton-grup">
                        <button name="action" value="GenerarHistorias" type="submit" class="boton-env">
                            <img src="../Views/imgs/ok.png" alt="" width="25" height="25">
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
        <script src="../Views/js/GeneracionAutomatica_validaciones.js"></script>

        </body>
        </html>

        <?php

    }
}
?>
