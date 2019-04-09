<?php
/**
 * Vista para editar grupos
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

class Accion_EDIT {

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

            <div class="form">

                <?php

                ?>
                <h3><?php echo $strings['Editar Accion']; ?></h3>
                <?php

                ?>

                <form class="form-basic" enctype="multipart/form-data"  method="post" action="../Controllers/ACCION_Controller.php"  onsubmit="return comprobarAccionEDIT()">
                    <div class="form-group">
                        <label class="form-label" for="idgrupo"><?php echo $strings['Id Accion']; ?></label>
                        <input readonly type="text" value="<?php echo $group['IdAccion']; ?>" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,6); comprobarEspacio(this)" id="IdAccion" name="IdAccion"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nombregrupo"><?php echo $strings['Nombre Accion']; ?></label>
                        <input type="text" value="<?php echo $group['NombreAccion']; ?>" class="form-control" maxlength="60" size="60" onblur=" messagedel(this);comprobarVacio(this); comprobarTexto(this,60); comprobarEspacio(this); comprobarAlfabetico(this)" id="NombreAccion" name="NombreAccion" tabindex="1" >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Descripcion Accion']; ?></label>
                        <textarea class="textarea-wi form-control" maxlength="100" cols="11" rows="2" onblur="messagedel(this); comprobarVacio(this); comprobarTexto(this,100); comprobarstartEspacio(this)" id="DescripAccion" name="DescripAccion"  tabindex="1"><?php echo $group['DescripAccion']; ?></textarea>
                    </div>

                    <button name="action" value="EDIT" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png">
                    </button>
                </form>



            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <?php include '../Views/js/Accion_validaciones.js'; ?>
        <script src="../Views/js/main.js"></script>
        </body>
        </html>

        <?php

    }
}
?>