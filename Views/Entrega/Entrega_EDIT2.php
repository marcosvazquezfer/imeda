<?php
/**
 * Vista para editar grupos
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

class Entrega_EDIT2{

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
                <h3><?php echo $strings['Editar Entrega']; ?></h3>
                <form class="form-basic" enctype="multipart/form-data"  method="post" action="../Controllers/Entrega_Controller.php" onsubmit="return comprobarEntEDIT();">
                    <div class="form-group">
                        <label class="form-label" for="login"><?php echo $strings['login']; ?></label>
                        <input readonly type="text" value="<?php echo $group['login']; ?>" class="form-control" maxlength="9" size="10" id="login" name="login"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="idgrupo"><?php echo $strings['Id Trabajo']; ?></label>
                        <input readonly type="text" value="<?php echo $group['IdTrabajo']; ?>" class="form-control" maxlength="6" size="10" id="IdTrabajo" name="IdTrabajo"  tabindex="1">
                        <input type="hidden" value="<?php echo $group['login']?>" id="login" name="login">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nombregrupo"><?php echo $strings['Alias']; ?></label>
                        <input type="text" value="<?php echo $group['Alias']; ?>" class="form-control" maxlength="6" size="10" id="Alias" name="Alias" tabindex="1"
                               onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarAlfaNumerico(this,6); comprobarEspacio(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Horas']; ?></label>
                        <input type="text" value="<?php echo $group['Horas']; ?>" class="form-control" maxlength="2" size="10"  id="Horas" name="Horas" tabindex="1"
                               onblur="messagedel(this); comprobarstartEspacio(this); comprobarVacio(this); comprobarEntero(this,0,99); comprobarEspacio(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Ruta']; ?></label>
                        <input type="file" id="Ruta" name="Ruta" value="<?php echo $group['Ruta']?>" class="form-control">
                        <input type="hidden" id="Ruta2" name="Ruta2" value="<?php echo $group['Ruta']?>">
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
        <?php include '../Views/js/Entrega_validaciones.js'; ?>
        <script src="../Views/js/main.js"></script>
        </body>
        </html>

        <?php

    }
}
?>