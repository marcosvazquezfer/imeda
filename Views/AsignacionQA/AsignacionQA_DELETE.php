<?php

/**
 * Nos permite eliminar una asignacion de QA
 * Autor: Ruben -Grupo Imeda
 * Fecha: 12/12/2017
 */

class AsignacionQA_DELETE {

    function __construct($asigQA){


        $this->pinta($asigQA);

    }


//función que pinta la vista
    function pinta($asigQA){
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
                <h4><?php echo $strings['Delete']; ?></h4>
                <br>
                <h4><?php echo $strings['Esta a punto de eliminar esta informacion']; ?></h4>
                <form enctype="multipart/form-data" action="../Controllers/AsignacionQA_Controller.php" method="post">
                    <ul>
                        <li>
                            <h5>id trabajo</h5>
                            <span><input type="hidden" name="IdTrabajo" value="<?php echo $asigQA['IdTrabajo']; ?>"><?php echo $asigQA['IdTrabajo']; ?></span>
                        </li>
                        <li>
                            <h5>Login Evaluador</h5>
                            <span><input type="hidden" name="LoginEvaluador" value="<?php echo $asigQA['LoginEvaluador']; ?>"><?php echo $asigQA['LoginEvaluador']; ?></span>
                        </li>
                        <li>
                            <h5>Login Evaluado</h5>
                            <span><input type="hidden" name="LoginEvaluado" value="<?php echo $asigQA['LoginEvaluado']; ?>"><?php echo $asigQA['LoginEvaluado']; ?></span>
                        </li>
                        <li>
                            <h5>Alias Evaluado</h5>
                            <span><input type="hidden" name="AliasEvaluado" value="<?php echo $asigQA['AliasEvaluado']; ?>"><?php echo $asigQA['AliasEvaluado']; ?></span>
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
        <script src="../js/main.js"></script>
        <?php include '../Views/js/validaciones.js' ?>
        </body>
        </html>

        <?php

    }
}
?>