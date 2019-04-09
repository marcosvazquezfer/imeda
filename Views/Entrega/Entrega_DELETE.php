<?php

/**
 * Vista que nos permite eliminar una accion
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */


class Entrega_DELETE {

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
                <br>
                <h4><?php echo $strings['Esta a punto de eliminar esta informacion'];?></h4>
                <form enctype="multipart/form-data"  action="../Controllers/Entrega_Controller.php" method="post">
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Trabajo']; ?></h5>
                            <span><input type="hidden" id="login" name="IdTrabajo" value="<?php echo $user['IdTrabajo']; ?>"><?php echo $user['IdTrabajo'];?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['login']; ?></h5>
                            <span><input type="hidden" id="login" name="login" value="<?php echo $user['login']?>"><?php echo $user['login'];?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Alias']; ?></h5>
                            <span><input type="hidden" name="Alias" value="<?php echo $user['Alias']; ?>"><?php echo $user['Alias'];?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Horas']; ?></h5>
                            <span><input type="hidden" name="Horas" value="<?php echo $user['Horas']; ?>"><?php echo $user['Horas'];?></span>
                        </li>

                        <li>
                            <h5><?php echo $strings['Ruta']; ?></h5>
                            <span><input type="hidden" name="Ruta" value="<?php echo $user['Ruta']; ?>"><?php echo $user['Ruta'];?></span>
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