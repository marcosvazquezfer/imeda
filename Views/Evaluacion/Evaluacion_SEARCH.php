<?php
/**
 * Vista para buscar evaluaciones
 * Autor: Alex - Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

class Evaluacion_SEARCH {

    function __construct($trabajos,$alias,$logins,$historias){

        $this->pinta($trabajos,$alias,$logins,$historias);

    }
    //Muestra las vista a enseñar
    function pinta($trabajos,$alias,$logins,$historias){
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

            <div class="form">

                <?php

                ?>
                <h3><?php echo $strings['Buscar Evaluacion']; ?></h3>
                <?php

                ?>

                <form class="form-basic" enctype="multipart/form-data" onsubmit="return comprobarEvaBus()"  method="post" action="../Controllers/Evaluacion_Controller.php" >

                    <div class="centrar form-group">
                        <label class="form-label" for="IdTrabajo"><?php echo $strings['Id Trabajo']; ?></label>
                        <select name="IdTrabajo" id="IdTrabajo" onchange="chooseHist()">
                            <option value=""></option>
                            <?php 
                            //recorre todos los trabajos que existen
                                while($row=$trabajos->fetch_array()){
                                    ?>
                                        <option value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="nombregrupo"><?php echo $strings['Login Evaluador']; ?></label>
                        <select name="LoginEvaluador" id="LoginEvaluador">
                            <option value=""></option>
                        <?php 
                        //Recorre todos los posibles logins que existen
                            while($row2=$logins->fetch_array()){
                                
                                ?>
                                    <option value="<?php echo $row2['login']; ?>"><?php echo $row2['login']; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Alias Evaluado']; ?></label>
                        <select name="AliasEvaluado" id="AliasEvaluado">
                            <option value=""></option>
                        <?php 
                        //Recorre todos los posibles alias que existen
                            while($row3=$alias->fetch_array()){
                                ?>
                                    <option value="<?php echo $row3['Alias']; ?>"><?php echo $row3['Alias']; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Id Historia']; ?></label>
                        <?php 
                            
                            $historiasAll = array(); //Variable que guarda todas las historias
                            $historiaTrab = array(); //Variable que guarda las historias de un trabajo
                            $historiascop; //Variable que guarda una copia de los ids de trabajo
                            $indice=0; //Variable que se usa de usa de indice

                            //Recorre todas las historias que existen
                            while($row4 = $historias->fetch_array()){
                                //Si en el array historiaTrab no existe la clave que se le pasa $row4['IdTrabajo']
                                //se mete como array y se hace copia de esa id de trabajo
                                if (!array_key_exists($row4['IdTrabajo'], $historiaTrab)){
                                    $historiaTrab[$row4['IdTrabajo']] = array();
                                    $historiascop[$indice] = $row4['IdTrabajo'];
                                    $indice++;
                                }
                                array_push($historiaTrab[$row4['IdTrabajo']],$row4);
                                array_push($historiasAll,$row4);
                            }
                            
                            //recorre todos los trabajos que existen
                            foreach($historiascop as $row5){
                                
                                ?>
                                <select class="hide" name="<?php echo $row5; ?>" id="<?php echo $row5; ?>">
                                    <option value=""></option>        
                                    <?php 
                                        //recorre todas las historias para un trabajo
                                        foreach($historiaTrab[$row5] as $value){
                                            ?>
                                                <option value="<?php echo $value['IdHistoria']; ?>"><?php echo $value['IdHistoria']; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <?php
                            }
                            
                        ?>
                        <select name="IdHistoria" id="IdHistoria" class="show">
                            <option value=""></option>
                            <?php 
                             //recorre todas las historias que existen
                            foreach($historiasAll as $row6){
                                
                                ?>
                                    <option value="<?php echo $row6['IdHistoria']; ?>"><?php echo $row6['IdTrabajo']; ?> - <?php echo $row6['IdHistoria']; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Correccion del Alumno']; ?></label>
                        <input type="checkbox" class="form-control" id="CorrectoA" name="CorrectoA" tabindex="1" >
                    </div>
                    
                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Comentario del Alumno']; ?></label>
                        <textarea class="textarea-wi form-control" rows="6" maxlength="300" onblur="messagedel(this);  comprobarTexto(this,300); comprobarstartEspacio(this)"
                               id="ComenIncorrectoA" name="ComenIncorrectoA" tabindex="1" ></textarea>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Correcion del Profesor']; ?></label>
                        <input type="checkbox" class="form-control" id="CorrectoP" name="CorrectoP" tabindex="1" >
                    </div>
                    
                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Comentario del Profesor']; ?></label>
                        <textarea type="text" class=" textarea-wi form-control" rows="6" maxlength="300" onblur="messagedel(this);  comprobarTexto(this,300); comprobarstartEspacio(this)"
                               id="ComentIncorrectoP" name="ComentIncorrectoP" tabindex="1" ></textarea>
                    </div>

                    <div class="centrar form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['OK']; ?></label>
                        <input type="checkbox" class="form-control" id="OK" name="OK" tabindex="1" >
                    </div>
                    <button name="action" value="SEARCH" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                </form>
            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <?php include '../Views/js/validaciones.js';?>
        <script src="../Views/js/main.js"></script>
        <script src="../Views/js/Evaluacion_validaciones.js"></script>
        </body>
        </html>

        <?php

    }
}
?>