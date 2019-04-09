<?php

/**
 * Vista que nos permite evaluar una entrega
 * Autor: Alex - Grupo Imeda
 * Fecha: 28/11/2017
 */

class EVALUACION_EVALUAR {

    

    function __construct($datos){

        $this->pinta($datos);

    }


    //Permite mostrar una vista
    function pinta($datos){

        $i; //Variable que hace de indice
        $datos; //Contiene todos las evalauciones a modificar

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

        <section class="form-basic-start">

                <div class="showall">

                <form action="../Controllers/Evaluacion_Controller.php" method="POST" >
                    <table class="showall-tab">
                        <tr>
                            <th><?php echo $strings['Id Historia']; ?></th>
                            <th><?php echo $strings['Texto Historia']; ?></th>
                            
                            <th><?php echo $strings['Correcto']; ?></th>
                            <th><?php echo $strings['Incorrecto']; ?></th>
                            <th><?php echo $strings['Texto Correcion']; ?></th>
                            
                        </tr>
                        <?php

                        $i = 0;
                        //Recorre todas las evaluaciones para un corrector dado
                        while ($row = $datos->fetch_array()){

                            ?>
                            <tr>
                                <input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>">
                                <input type="hidden" name="AliasEvaluado" value="<?php echo $row['AliasEvaluado']; ?>">
                                <input type="hidden" name="LoginEvaluador" value="<?php echo $row['LoginEvaluador']; ?>">
                                <td><input type="hidden" name="IdHistoria[]" value="<?php echo $row['IdHistoria']; ?>"><?php echo $row['IdHistoria']; ?></td>
                                <td><?php echo $row['TextoHistoria']; ?></td>
                                <td><input type="radio" value="1" name="correcion<?php echo $i ?>" <?php 
                                /*Si el valor es 1 muestra el checkbox como checked*/ 
                                if($row['CorrectoA'] == 1){ echo 'checked';} ?> id=""></td>
                                <td><input type="radio" value="0" name="correcion<?php echo $i ?>" <?php 
                                /*Si el valor es 1 muestra el checkbox como checked*/
                                if($row['CorrectoA'] == 0){ echo 'checked';} ?> id=""></td>
                                <td><textarea cols="30" maxlength="300" rows="10" value="<?php echo $row['ComenIncorrectoA']; ?>" name="correcionTexto<?php echo $i ?>" id=""><?php echo $row['ComenIncorrectoA']; ?></textarea></td>                                    
                            </tr>


                            <?php
                            $i++;
                        }

                        ?>

                    </table>
                    <button name="action" value="EVALUAR" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                    </form>
                </div>

                <a href="../Controllers/Funcionalidad_Controller.php?action=default">
                    <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
                </a>

            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <script src="../Views/js/md5.js"></script>
        <script src="../Views/js/Funcionalidades_validaciones.js"></script>
        <script src="../Views/js/main.js"></script>
        <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>