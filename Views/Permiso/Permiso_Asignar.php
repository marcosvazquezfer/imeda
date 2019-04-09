<?php

/**
 * Archivo php donde nos permite asignar acciones
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */

class ASIGNAR_ACCIONES_View {

    function __construct($GRUPO,$FUNCIONALIDAD,$ACCIONES_POSIBLES){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($GRUPO,$FUNCIONALIDAD,$ACCIONES_POSIBLES);

    }



    function pinta($GRUPO,$FUNCIONALIDAD,$ACCIONES_POSIBLES){
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
                <h4><?php echo $strings['Seleccione entre las diferentes acciones sobre']; ?> <?php echo $FUNCIONALIDAD?> <?php echo $strings['para']; ?> <?php echo $GRUPO?></h4>
                <form action="../Controllers/Permiso_Controller.php"method="post">

                        <?php
                        //bucle que inserta checkbox por cada tupla
                        while($row = $ACCIONES_POSIBLES->fetch_array()){
                            ?>
                            <input type="checkbox" value="<?php echo $row["NombreAccion"]?>" name="NombreAccion[]"> <p><?php echo $row["NombreAccion"]?></p>

                        <?php }?>
                    <input type="hidden" name="NombreGrupo" value="<?php echo $GRUPO?>">
                    <input type="hidden" name="NombreFuncionalidad" value="<?php echo $FUNCIONALIDAD?>">
                    <div class="boton-grup">

                        <button name="action" value="ASIGNAR" type="submit" class="boton-env">
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
        <?php include '../Views/js/validaciones.js'  ?>
        <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>
