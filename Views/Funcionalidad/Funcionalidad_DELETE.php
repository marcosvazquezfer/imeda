<?php

/**
 * Nos permite eliminar una funcionalidad
 * Autor: Ruben - Grupo Imeda
 * Fecha: 28/11/2017
 */

class FUNCIONALIDAD_DELETE {

    function __construct($user){

        //if(!is_string($user))
        //$user = $user->fetch_array();
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
                <br>
                <h4><?php echo $strings['Esta a punto de eliminar esta informacion']; ?></h4>
                <form enctype="multipart/form-data" action="../Controllers/Funcionalidad_Controller.php" method="post">
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Funcionalidad']; ?></h5>
                            <span><input type="hidden" name="IdFuncionalidad" value="<?php echo $user['IdFuncionalidad']; ?>"><?php echo $user['IdFuncionalidad']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Nombre Funcionalidad']; ?></h5>
                            <span><input type="hidden" name="password" value="<?php echo $user['NombreFuncionalidad']; ?>"><?php echo $user['NombreFuncionalidad']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Descripcion Funcionalidad']; ?></h5>
                            <span><input type="hidden" name="DNI" value="<?php echo $user['DescripFuncionalidad']; ?>"><?php echo $user['DescripFuncionalidad']; ?></span>
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
        <script src="../js/main.js"></script>
        <?php include '../Views/js/validaciones.js' ?>
        </body>
        </html>

        <?php

    }
}
?>