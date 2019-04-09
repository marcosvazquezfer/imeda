<?php
/**
 * Vista que muestra el trabajo que se desea borrar en detalle
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 1/12/2017
 * Fecha fin: 1/12/2017
 */
    class TRABAJO_DELETE {

        function __construct($trabajo){

            //if(!is_string($user))
            //$user = $user->fetch_array();
            $this->pinta($trabajo);

        }

    
    //función que contiene la vista
    function pinta($trabajo){
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
            <h4><?php echo $strings['Delete']; ?></h4> 
            <br>
            <h4>Esta a punto de eliminar esta informacion</h4>

            <form enctype="multipart/form-data"  action="../Controllers/TRABAJO_Controller.php" method="post">
                <ul>
                    <li>
                        <h5><?php echo $strings['Id Trabajo']; ?></h5>
                        <span><input type="hidden" name="IdTrabajo" value="<?php echo $trabajo['IdTrabajo']; ?>"><?php echo $trabajo['IdTrabajo']; ?></span>
                    </li>

                    <li>
                        <h5><?php echo $strings['Nombre Trabajo']; ?></h5>
                        <span><input type="hidden" name="text" value="<?php echo $trabajo['NombreTrabajo']; ?>"><?php echo $trabajo['NombreTrabajo']; ?></span>
                    </li>

                    <li>
                        <h5><?php echo $strings['Fecha Inicio']; ?></h5>
                        <span><input type="hidden" name="fechaini" value="<?php echo $trabajo['FechaIniTrabajo']; ?>"><?php echo $trabajo['FechaIniTrabajo']; ?></span>
                    </li>

                    <li>
                        <h5><?php echo $strings['Fecha Fin']; ?></h5>
                        <span><input type="hidden" name="fechafin" value="<?php echo $trabajo['FechaFinTrabajo']; ?>"><?php echo $trabajo['FechaFinTrabajo']; ?></span>
                    </li>

                    <li>
                        <h5><?php echo $strings['Porcentaje Nota']; ?></h5>
                        <span><input type="hidden" name="porcentaje" value="<?php echo $trabajo['PorcentajeNota']; ?>"><?php echo $trabajo['PorcentajeNota']; ?></span>
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
            <?php include '../Views/js/Trabajo_validaciones.js'  ?>
        </body>
        </html>
        
        <?php
    
        }
    }
?>