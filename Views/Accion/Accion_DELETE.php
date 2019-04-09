<?php

/**
 * Vista que nos permite eliminar una accion
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se muestra el apartado Borrar Usuario: yn8idg, Fecha: 11/11/2017
class Accion_DELETE {

    function __construct($user){
        $this->pinta($user);

    }


//función que pinta la vista
    function pinta($user){
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
                <h4><?php echo $strings['Delete']; ?></h4>
                <form enctype="multipart/form-data"  action="../Controllers/ACCION_Controller.php" method="post">
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Accion']; ?></h5>
                            <span><input type="hidden" name="IdAccion" value="<?php echo $user['IdAccion']; ?>"><?php echo $user['IdAccion']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Nombre Accion']; ?></h5>
                            <span><input type="hidden" name="NombreAccion" value="<?php echo $user['NombreAccion']; ?>"><?php echo $user['NombreAccion']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Descripcion Accion']; ?></h5>
                            <span><input type="hidden" name="DescripAccion" value="<?php echo $user['DescripAccion']; ?>"><?php echo $user['DescripAccion']; ?></span>
                        </li>
                    </ul>
                    <div class="boton-grup">

                        <div class="boton-grup">
                            <button name="action" value="DELETE" class="boton-env">
                                <img src="../Views/imgs/delete.png" alt="">
                            </button>
                            <button name="action" value="" class="boton-env">
                                <img src="../Views/imgs/return.png" alt="" >
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <script src="../Views/js/main.js"></script>
        <?php include '../Views/js/validaciones.js'  ?>
        </body>
        </html>

        <?php

    }
}
?>