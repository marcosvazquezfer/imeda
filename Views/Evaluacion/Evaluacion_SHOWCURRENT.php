<?php

/**
 * Vista que muestra las notas de las evaluaciones en detalle 
 * Autor: Alex
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class EVALUACION_SHOWCURRENT {

        function __construct($eva){
            
            $this->pinta($eva);

        }

    //Muestra las vista a enseñar
    function pinta($eva){

        //Comprueba si existe la variable en sesion para idioma y sino la crea
        if(!isset($_SESSION['idioma'])){
            $_SESSION['idioma'] = 'SPANISH';
        }

        include_once '../Locales/Strings_index.php';
        //recorre todos los posibles idiomas existentes 
        foreach($stringslang as $lang){
            //Comprueba cual es el idioma de la sesion y busca si coincide con $lang
            if($lang == $_SESSION['idioma'])
                include_once '../Locales/Strings_'. $lang .'.php';
        }

        include '../Views/HEADER_View.php';

        new HEADER();
        ?>
            <section>
            
                <div class="form2">
                    <h4><?php echo $strings['ShowCurrent']; ?></h4> 
                    <ul>
                        <li>
                            <h5><?php echo $strings['Id Trabajo']; ?></h5>
                            <span><?php echo $eva['IdTrabajo']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Login Evaluador']; ?></h5>
                            <span> <?php echo $eva['LoginEvaluador']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Alias Evaluado']; ?></h5>
                            <span> <?php echo $eva['AliasEvaluado']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Id Historia']; ?></h5>
                            <span> <?php echo $eva['IdHistoria']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Correccion del Alumno']; ?></h5>
                            <span> <?php echo $eva['CorrectoA']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Comentario del Alumno']; ?></h5>
                            <span> <?php echo $eva['ComenIncorrectoA']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Correcion del Profesor']; ?></h5>
                            <span> <?php echo $eva['CorrectoP']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Comentario del Profesor']; ?></h5>
                            <span> <?php echo $eva['ComentIncorrectoP']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['OK']; ?></h5>
                            <span> <?php echo $eva['OK']; ?> </span>
                        </li>
                    </ul>
                    <div class="boton-grup">
                        <form action="../Controllers/NOTAS_Controller.php" method="">
                            <button name="action" value="" type="submit" class="boton-env">
                                <img src="../Views/imgs/return.png" alt="" width="25" height="25">
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