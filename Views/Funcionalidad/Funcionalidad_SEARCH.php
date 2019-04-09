<?php

/**
 * Nos permite buscar una funcionalidad
 * Autor: Ruben - Grupo Imeda
 * Fecha: 28/11/2017
 */

class FUNCIONALIDAD_SEARCH {

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

                <form class="form-basic" method="post" action="../Controllers/Funcionalidad_Controller.php" onsubmit="return comprobarbusFun()">
                    <div class="form-group">
                        <label class="form-label" for="idFuncionalidad"><?php echo $strings['Id Funcionalidad']; ?></label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,6)" id="IdFuncionalidad" name="IdFuncionalidad"  >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nombreFuncionalidad"><?php echo $strings['Nombre Funcionalidad']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,60)" id="NombreFuncionalidad" name="NombreFuncionalidad" >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="descripcionFuncionalidad"><?php echo $strings['Descripcion Funcionalidad']; ?></label>
                        <textarea class="textarea-wi form-control" maxlength="100" cols="11" rows="2" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,100); comprobarstartEspacio(this)" id="DescripFuncionalidad" name="DescripFuncionalidad"  tabindex="1"></textarea>
                        <!--<input type="text" class="form-control" maxlength="100" size="100" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,100)" id="DescripFuncionalidad" name="DescripFuncionalidad" >-->
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
        <script src="../Views/js/main.js"></script>
        <?php include '../Views/js/Funcionalidades_validaciones.js'; ?>
        <?php include '../Views/js/validaciones.js'; ?>
        </body>
        </html>

        <?php

    }
}
?>