<?php
/**
 * Vista que muestra el grupo que se desea borrar en detalle
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */
    class GRUPO_DELETE {

        function __construct($group){

            //if(!is_string($user))
            //$user = $user->fetch_array();
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
        <div class="form2">
            <h4><?php echo $strings['Delete']; ?></h4>
            <h4><?php echo $strings['Esta a punto de eliminar esta informacion']; ?></h4>

            <form enctype="multipart/form-data" action="../Controllers/Grupo_Controller.php" method="post">
                <ul>
                    <li>
                        <h5><?php echo $strings['Id Grupo']; ?></h5>

                        <span><input type="hidden" name="IdGrupo" value="<?php echo $group['IdGrupo']; ?>"><?php echo $group['IdGrupo']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Nombre Grupo']; ?></h5>
                        <span><input type="hidden" name="NombreGrupo" value="<?php echo $group['NombreGrupo']; ?>"><?php echo $group['NombreGrupo']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Descripcion Grupo']; ?></h5>
                        <span><input type="hidden" name="DescripGrupo" value="<?php echo $group['DescripGrupo']; ?>"><?php echo $group['DescripGrupo']; ?></span>
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
            <?php include '../Views/js/Grupo_validaciones.js' ?>
        </body>
        </html>
        
        <?php
    
        }
    }
?>