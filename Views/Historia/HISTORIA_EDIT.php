<?php

/**
 * Archivo php donde se muestra el apartado Editar historia
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */

class HISTORIA_EDIT {

    function __construct($funcion,$trabajos){

        $this->pinta($funcion,$trabajos);

    }


    //función que contiene la vista
    function pinta($funcion,$trabajos){
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

            <div class="form">

                <?php

                ?>
                <h3><?php echo $strings['Edit']; ?></h3>
                <?php

                ?>

                <form class="form-basic" enctype="multipart/form-data"  method="post" action="../Controllers/Historia_Controller.php" onsubmit="return comprobarHistoriaAdd(1)">
                    <div class="form-group">
                        <label class="form-label" for="idHistoria"><?php echo $strings['Id Historia']; ?></label>
                        <input type="text" class="input-peq form-control" readonly value="<?php echo $funcion['IdHistoria']; ?>" maxlength="6" size="6" onblur="messagedel(this); comprobarVacio(this); comprobarEspacio(this); comprobarTexto(this,6)" id="idHistoria1" name="IdHistoria"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="idTrabajo"><?php echo $strings['Id Trabajo']; ?></label>
                        <select name="IdTrabajo" id="idTrabajo1">

                        <?php

                            $row;//almacena trabajos

                            //mientras existan trabajos, imprime el nombre del trabajo en un campo seleccionable
                            while($row = $trabajos->fetch_array()){

                                ?>

                                    <option <?php if($row['IdTrabajo']==$funcion['IdTrabajo']){ echo 'selected'; }else{ echo 'disabled'; } ?> value="<?php echo $row['IdTrabajo'] ?>"><?php echo $row['NombreTrabajo'] ?></option>

                                <?php

                            }
                        ?>

                        </select>
                    </div>
                    

                    <div class="form-group">
                        <label class="form-label" for="TextoHistoria"><?php echo $strings['Texto Historia']; ?></label>
                        <textarea type="text"  rows="10" cols="31" class="textarea-wi2 form-control" maxlength="300" size="300" onblur="messagedel(this); comprobarVacio(this); comprobarstartEspacio(this); comprobarTexto(this,300)" id="TextoHistoria1" name="TextoHistoria"  tabindex="1" ><?php echo $funcion['TextoHistoria']; ?></textarea>
                    </div>

                    <button name="action" value="EDIT" type="submit" class="boton-env">
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
        <script src="../Views/js/Funcionalidades_validaciones.js"></script>
        <script src="../Views/js/main.js"></script>
        <?php include '../Views/js/validaciones.js'; ?>
        </body>
        </html>

        <?php

    }
}
?>