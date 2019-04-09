<?php
/**
 * Vista que muestra la nota que se desea borrar en detalle
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    class NOTAS_DELETE {

        function __construct($notas){

            //if(!is_string($user))
            //$user = $user->fetch_array();
            $this->pinta($notas);

        }

    
    //función que contiene la vista
    function pinta($notas){
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
        <div class="form2">
            <h4><?php echo $strings['Eliminar Nota']; ?></h4>

            <form enctype="multipart/form-data" action="../Controllers/NOTAS_Controller.php" method="post">
                <ul>
                    <li>
                        <h5><?php echo $strings['Login']; ?></h5>

                        <span><input type="hidden" name="login" value="<?php echo $notas['login']; ?>"><?php echo $notas['login']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Id Trabajo']; ?></h5>
                        <span><input type="hidden" name="IdTrabajo" value="<?php echo $notas['IdTrabajo']; ?>"><?php echo $notas['IdTrabajo']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Nota Trabajo']; ?></h5>
                        <span><input type="hidden" name="NotaTrabajo" value="<?php echo $notas['NotaTrabajo']; ?>"><?php echo $notas['NotaTrabajo']; ?></span>
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
        </body>
        </html>
        
        <?php
    
        }
    }
?>