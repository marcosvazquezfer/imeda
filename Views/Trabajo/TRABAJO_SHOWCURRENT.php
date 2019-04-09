<?php
/**
 * Vista que muestra todos los trabajos en detalle que hay en la BD
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 1/12/2017
 * Fecha fin: 1/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class TRABAJO_SHOWCURRENT {

        function __construct($trabajo){
            
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
                    <h4><?php echo $strings['ShowCurrent']; ?></h4> 
                    <br>
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Trabajo']; ?></h5>
                            <span> <?php echo $trabajo['IdTrabajo']; ?> </span>
                        </li>

                        <li>
                            <h5><?php echo $strings['Nombre Trabajo']; ?></h5>
                            <span><?php echo $trabajo['NombreTrabajo']; ?></span>
                        </li>

                        <li>
                            <h5><?php echo $strings['Fecha Inicio']; ?></h5>
                            <span> <?php echo $trabajo['FechaIniTrabajo']; ?> </span>
                        </li>

                        <li>
                            <h5><?php echo $strings['Fecha Fin']; ?></h5>
                            <span> <?php echo $trabajo['FechaFinTrabajo']; ?> </span>
                        </li>

                        <li>
                            <h5><?php echo $strings['Porcentaje Nota']; ?></h5>
                            <span> <?php echo $trabajo['PorcentajeNota']; ?> </span>
                        </li>
                    </ul>

                    <div class="boton-grup">
                        <form action="../Controllers/TRABAJO_Controller.php" method="">
                            <button name="action" value="" type="submit" class="boton-env">
                                <img src="../Views/imgs/return.png" alt="">
                            </button>
                        </form>

                        <form action="../Controllers/AsignarNotas_Controller.php" method="">
                            <button name="action" value="ENTREGAS" type="submit" class="boton-env">
                                <img src="../Views/imgs/evaluar.png" alt="">
                            </button>
                        </form>
                    </div>
                    
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