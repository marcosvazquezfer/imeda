<?php

/**
 * Archivo php donde se muestra el apartado Añadir funcionalidad
 * Autor: Ruben -Grupo Imeda
 * Fecha: 12/12/2017
 */
class AsignacionQA_ADD {

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

                <?php

                ?>
                <h3><?php echo $strings['Add']; ?></h3>
                <?php

                ?>

                <form class="form-basic" enctype="multipart/form-data" method="post" action="../Controllers/AsignacionQA_Controller.php" onsubmit="return comprobarAsigADD()">
                    <div class="form-group">
                        <label class="form-label" for="idTrabajo">Id trabajo</label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,6)" id="idTrabajo1" name="IdTrabajo"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="loginEvaluador">login evaluador</label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,9)" id="loginEvaluador1" name="LoginEvaluador" tabindex="1" >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="loginEvaluado">Login Evaluado</label>
                        <input type="text" class="form-control" maxlength="9" size="9" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,9)" id="loginEvaluado1" name="LoginEvaluado"  tabindex="1" >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="aliasEvaluado">Alias Evaluado</label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,6)" id="aliasEvaluado1" name="AliasEvaluado"  tabindex="1" >
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
        <script src="../Views/js/md5.js"></script>
        <?php include '../Views/js/AsignacionQA_validaciones.js'; ?>
        <script src="../Views/js/main.js"></script>
        <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>