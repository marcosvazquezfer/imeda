<?php

/**
 * Archivo php donde se muestra el apartado Añadir funcionalidad
 * Autor: Ruben - Grupo Imeda
 * Fecha: 28/11/2017
 */
class FUNCIONALIDAD_ADD {

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

                <form class="form-basic" enctype="multipart/form-data" method="post" action="../Controllers/Funcionalidad_Controller.php" onsubmit="return comprobarFun(1)">
                    <div class="form-group">
                        <label class="form-label" for="idFuncionalidad"><?php echo $strings['Id Funcionalidad']; ?></label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,6)" id="idFuncionalidad1" name="IdFuncionalidad"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nombreFuncionalidad"><?php echo $strings['Nombre Funcionalidad']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarTexto(this,60); comprobarAlfabetico(this,60)" id="nombreFuncionalidad1" name="NombreFuncionalidad" tabindex="1" >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripcionFuncionalidad"><?php echo $strings['Descripcion Funcionalidad']; ?></label>
                        <textarea class="textarea-wi form-control" maxlength="100" cols="11" rows="2" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,100); comprobarstartEspacio(this)" id="DescripcionFuncionalidad1" name="DescripFuncionalidad"  tabindex="1"></textarea>
                        <!--<input type="text" class="form-control" maxlength="100" size="100" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarTexto(this,100)" id="DescripcionFuncionalidad1" name="DescripFuncionalidad"  tabindex="1" >-->
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
        <?php include '../Views/js/Funcionalidades_validaciones.js'; ?>
        <?php include '../Views/js/validaciones.js'; ?>
        <script src="../Views/js/main.js"></script>
        </body>
        </html>

        <?php

    }
}
?>