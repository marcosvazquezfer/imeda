<?php
/**
 * Archivo php donde nos permite seleccionar la entrega de la que queremos generar sus notas
 * Autor: Marcos -Grupo Imeda
 * Fecha: 16/12/2017
 **/

class NotasEntregas_GENERAR {

    function __construct($notas){

        //if(!is_string($user))
        //$user = $user->fetch_array();
        $this->pinta($notas);

    }


//función que pinta la vista
    function pinta($notas){
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
                <h4>Generación de Notas de Entregas</h4>
                <form action="../Controllers/NOTAS_Controller.php" method="post" onblur="">
                    <select name="NombreTrabajo">
                        <?php
                        //bucle para cada tupla imprime un option
                        while($row = $notas->fetch_array()){
                            ?>
                            <option value="<?php echo $row['IdTrabajo']?>" ><?php echo $row['NombreTrabajo']?></option>
                        <?php }?>
                    </select>
                    <br>

                    <div class="boton-grup">
                        <button name="action" value="ENTREGAS" type="submit" class="boton-env">
                            <img src="../Views/imgs/ok.png" alt="" width="25" height="25">
                        </button>
                </form>

            </div>

            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 11/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: yn8idg</h6>
            </footer>
        </section>
        <script src="../Views/js/main.js"></script>
        <script src="../Views/js/"></script>

        </body>
        </html>

        <?php

    }
}
?>
