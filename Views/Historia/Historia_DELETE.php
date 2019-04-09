<?php

/**
 * Vista que nos permite eliminar una historia
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se muestra el apartado Borrar Usuario: yn8idg, Fecha: 11/11/2017
class HISTORIA_DELETE {

    function __construct($hist){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($hist);

    }


    //función que contiene la vista
    function pinta($hist){
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
                <h4><?php echo $strings['Delete']; ?></h4>
                <h4>Esta a punto de eliminar esta informacion</h4>
                <form enctype="multipart/form-data"  action="../Controllers/Historia_Controller.php" method="post">
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Historia']; ?></h5>
                            <span><input type="hidden" name="IdHistoria" value="<?php echo $hist['IdHistoria']; ?>"><?php echo $hist['IdHistoria']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Id Trabajo']; ?></h5>
                            <span><input type="hidden" name="IdTrabajo" value="<?php echo $hist['IdTrabajo']; ?>"><?php echo $hist['IdTrabajo']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Texto Historia']; ?></h5>
                            <span><input type="hidden" name="TextoHistoria" value="<?php echo $hist['TextoHistoria']; ?>"><?php echo $hist['TextoHistoria']; ?></span>
                        </li>
                    </ul>
                    <div class="boton-grup">

                        <div class="boton-grup">
                            <button name="action" value="DELETE" class="boton-env">
                                <img src="../Views/imgs/delete.png" alt="">
                            </button>
                            <button name="action" value="" class="boton-env">
                                <img src="../Views/imgs/return.png" alt="" >
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <script src="../Views/js/main.js"></script>
        <?php include '../Views/js/validaciones.js'  ?>
        </body>
        </html>

        <?php

    }
}
?>