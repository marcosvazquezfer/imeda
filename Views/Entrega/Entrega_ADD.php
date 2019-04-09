<?php
/**
 * Vista para añadir acciones
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

class Entrega_ADD {

    function __construct($trabajos,$login){

        $this->pinta($trabajos,$login);

    }

//función que pinta la vista
    function pinta($trabajos,$login){
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
                <h3><?php echo $strings['Añadir Entrega']; ?></h3>
                <?php

                ?>

                <form class="form-basic" enctype="multipart/form-data"  method="post" action="../Controllers/Entrega_Controller.php" onsubmit="return comprobarEntADD();">
                    <div class="form-group">
                        <label class="form-label" for="idTrabajo"><?php echo $strings['Id Trabajo']; ?></label>
                        <select name="IdTrabajo" id="IdTrabajo">

                            <?php
                            //bucle que imprime un option por cada tupla
                            while($row = $trabajos->fetch_array()){

                                ?>

                                <option value="<?php echo $row['IdTrabajo'] ?>"><?php echo $row['IdTrabajo'] ?></option>

                                <?php

                            }
                            ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="login"><?php echo $strings['login']; ?></label>
                        <select name="login" id="login">

                            <?php
                            //bucle que imprime un option por cada tupla
                            while($row = $login->fetch_array()){

                                ?>

                                <option value="<?php echo $row['login'] ?>"><?php echo $row['login'] ?></option>

                                <?php

                            }
                            ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Alias']; ?></label>

                        <input type="text" class="form-control" maxlength="6" size="10" onblur="messagedel(this); comprobarstartEspacio(this); comprobarVacio(this); comprobarAlfaNumerico(this,6); comprobarEspacio(this)"
                        id="Alias" name="Alias"  tabindex="1">

                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Horas']; ?></label>

                        <input type="text" class="form-control" maxlength="2" size="10" onblur="messagedel(this); comprobarstartEspacio(this); comprobarVacio(this); comprobarEntero(this,0,99); comprobarEspacio(this)"

                               id="Horas" name="Horas" tabindex="1" >

                    </div>

                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Ruta']; ?></label>

                        <input type="file"  maxlength="100" size="100" onblur="messagedel(this); comprobarstartEspacio(this); comprobarVacio(this);"

                               id="Ruta" name="Ruta" tabindex="1" >

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
        <?php include '../Views/js/Entrega_validaciones.js'; ?>
        <script src="../Views/js/main.js"></script>
        </body>
        </html>

        <?php

    }
}
?>