<?php

/**
 * Archivo php donde se muestra el apartado Buscar 
 * Autor: Alex -Grupo Imeda
 * Fecha: 11/11/2017
 */
class PERMISO_SEARCH {

    function __construct(){

        $this->pinta();

    }



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

                <form class="form-basic" method="post" action="../Controllers/Permiso_Controller.php" onsubmit="return comprobarbus()">
                    <div class="form-group">
                        <label class="form-label" for="NombreGrupo"><?php echo $strings['Nombre Grupo']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,60)" id="NombreGrupo" name="NombreGrupo"  >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="NombreFuncionalidad"><?php echo $strings['Nombre Funcionalidad']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,60)" id="NombreFuncionalidad" name="NombreFuncionalidad"  >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="NombreAccion"><?php echo $strings['Nombre Accion']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarEspacio(this); comprobarTexto(this,60)" id="NombreAccion" name="NombreAccion"  >
                    </div>


                    <button name="action" value="SEARCH" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                </form>
            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 11/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: yn8idg</h6>
            </footer>
        </section>
        <script src="../Views/js/md5.js"></script>
        <script src="../Views/js/main.js"></script>
        <script src="../Views/js/Funcionalidades_validaciones.js"></script>
        <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>