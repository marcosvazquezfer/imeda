<?php

/**
 * Nos permite buscar una Asignación de QA
 * Autor: Ruben -Grupo Imeda
 * Fecha: 28/11/2017
 */

class AsignacionQA_SEARCH {

    function __construct(){

        $this->pinta();

    }


//función que pinta la vista
    function pinta(){
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

            <div class="form">
                <h3><?php echo $strings['Search']; ?></h3>

                <form class="form-basic" method="post" action="../Controllers/AsignacionQA_Controller.php" onsubmit="return comprobarAsigSEARCH()">
                    <div class="form-group">
                        <label class="form-label" for="idTrabajo">Id Trabajo</label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,6)" id="IdTrabajo" name="IdTrabajo"  >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="loginEvaluador">Login Evaluador</label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,9)" id="LoginEvaluador" name="LoginEvaluador" >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="loginEvaluado">Login Evaluado</label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,9)" id="LoginEvaluado" name="LoginEvaluado" >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="loginEvaluado">Alias Evaluado</label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,6)" id="AliasEvaluado" name="AliasEvaluado" >
                    </div>


                    <button name="action" value="SEARCH" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                </form>
            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <script src="../js/md5.js"></script>
        <script src="../js/main.js"></script>
        <?php include '../Views/js/AsignacionQA_validaciones.js'; ?>
        <script type="text/javascript" src="../js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>