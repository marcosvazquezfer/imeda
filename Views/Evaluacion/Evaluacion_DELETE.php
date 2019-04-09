<?php

/**
 * Vista que muestra la evaluacion a eliminar
 * Autor: Alex
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class EVALUACION_DELETE {

        function __construct($eva){
            
            $this->pinta($eva);

        }

    
    //Crea la vista a mostrar
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
                <h4><?php echo $strings['Delete']; ?></h4>
                <br>
                <h4><?php echo $strings['Esta a punto de eliminar esta informacion'];?></h4>
                <form enctype="multipart/form-data"  action="../Controllers/Evaluacion_Controller.php" method="post">
                <ul>
                        <li>
                            <h5><?php echo $strings['Id Trabajo']; ?></h5>
                            <span><input type="hidden" id="login" name="IdTrabajo" value="<?php echo $eva['IdTrabajo']; ?>"><?php echo $eva['IdTrabajo']; ?></span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Login']; ?></h5>
                            <span><input type="hidden" id="login" name="login" value="<?php echo $eva['LoginEvaluador']; ?>"><?php echo $eva['LoginEvaluador']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Alias']; ?></h5>
                            <span><input type="hidden" id="login" name="Alias" value="<?php echo $eva['AliasEvaluado']; ?>"><?php echo $eva['AliasEvaluado']; ?> </span>
                        </li>
                        <li>
                            <h5><?php echo $strings['Id Historia']; ?></h5>
                            <span><input type="hidden" id="login" name="IdHistoria" value="<?php echo $eva['IdHistoria']; ?>"><?php echo $eva['IdHistoria']; ?> </span>
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